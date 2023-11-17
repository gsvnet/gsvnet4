<?php 

namespace GSVnet\Core;
use GdImage;
use GSVnet\Core\Exceptions\FileNotFoundException;
use GSVnet\Core\Exceptions\ImageTypeNotValidException;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

// TODO: Extensively test this class. GSVnet 3 made use of Intervention's Image class,
// but that one does not seem to be maintained very well anymore (devs don't reply to
// issues about security concerns). I therefore opted for using the GD image functions,
// which are a bit more clunky.

// TODO: Destroy all derivatives when destroying original.

class ImageHandler
{
    protected $basePath;
    protected $disk;

    public function __construct(
        string $basePath = '',
        FilesystemAdapter $disk = null
    ) {
        $this->basePath = $basePath;
        // Can't set this statically, that's why it's not a default argument
        $this->disk = is_null($disk) ? Storage::disk('local') : $disk;
    }

    /**
     * Intelligently join path components.
     * 
     * See https://stackoverflow.com/questions/1091107/how-to-join-filesystem-path-strings-in-php.
     * @param string ...$args
     * @return string
     */
    private function join_paths(...$args): string
    {
        $paths = array();
    
        foreach ($args as $arg) {
            if ($arg !== '') { $paths[] = $arg; }
        }
    
        return preg_replace('#/+#', '/', join('/', $paths));
    }

    /**
     * Prepend `$this->basePath` to `$path` if it is not already there.
     * 
     * Will not modify path if it is absolute.
     * @param string $path
     * @return string
     */
    private function prependBasePath(string $path): string
    {
        // Do nothing if $path already starts with base path or is absolute
        if (str_starts_with($path, $this->basePath) || str_starts_with($path, '/'))
            return $path;

        return $this->join_paths($this->basePath, $path);
    }

    /**
    *   Check if `$dimension` is valid.
    *
    *   @param string $dimension
    *   @throws InvalidArgumentException
    */
    private function dimensionIsValid($dimension = ''): bool
    {
        $dimensions = config('images.dimensions');

        // An empty dimension is handled as the original image and considered valid.
        if ($dimension !== '' && ! array_key_exists($dimension, $dimensions))
            return false;
        
        return true;
    }

    /**
     * Add `$dimension` to filename in `$path`.
     * 
     * For instance, if `$path` is `"images/cat.png"` and `$dimension` is `"small"`, will return `"images/cat-small.png"`.
     * @param mixed $path
     * @param mixed $dimension
     * @return string
     */
    private function mergePathDimension($path, $dimension): string
    {
        if ($dimension == '')
            return $path;

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        return str_replace(".$ext", '', $path) . "-$dimension.$ext";
    }

    /**
     * Merge `$dimension` into `$path` and prepend with the base path.
     * 
     * Throws an error if `$dimension` does not match the array keys of the `'dimensions'` array in `config/images.php`.
     * @param string $path
     * @param string $dimension
     * @throws \InvalidArgumentException
     * @return string
     */
    private function getDerivedPath(string $path, string $dimension): string
    {
        if (! $this->dimensionIsValid($dimension))
            throw new InvalidArgumentException("Dimension '$dimension' should be any of the keys specified in config/images.php");

        return $this->prependBasePath($this->mergePathDimension($path, $dimension));
    }

    /**
     * Creates derivative from image if it does not exist.
     * 
     * Returns path to derivative.
     * @param string $path
     * @param string $dimension
     * @throws \GSVnet\Core\Exceptions\FileNotFoundException
     * @return string
     */
    private function createDerivative(string $path, string $dimension): string
    {
        $originalPath = $this->prependBasePath($path);

        // Check if there is a file to be derived from
        if (! $this->disk->exists($originalPath))
            throw new FileNotFoundException("File $originalPath does not exist");

        $derivedPath = $this->getDerivedPath($path, $dimension);

        // If the file already exists, we don't need to do anything
        if ($this->disk->exists($derivedPath))
            return $derivedPath;

        // Scale such that image at least completely fills the dimension frame.
        // Crop everything that falls outside of the frame.
        $dimensions = config('images.dimensions');
        [$frameWidth, $frameHeight] = $dimensions[$dimension];

        // Read original image into a string
        $imgString = $this->disk->get($originalPath);
        [$width, $height] = getimagesizefromstring($imgString);

        // Step 1: Fill. 
        // If the image is smaller than the frame, you want the largest scaling factor.
        // If the image is larger than the frame, you want the scaling factor that
        // downscales the least, i.e., the largest scaling factor.
        $scaleFactor = max($frameWidth / $width, $frameHeight / $height);

        // Create image object from string
        $originalImg = imagecreatefromstring($imgString);

        $scaledImg = imagescale(
            $originalImg, 
            $scaleFactor * $width, 
            $scaleFactor * $height,
            IMG_BICUBIC
        );

        // Step 2: Crop.
        $croppedImg = imagecrop(
            $scaledImg,
            [
                'x' => 0,
                'y' => 0,
                'width' => $frameWidth,
                'height' => $frameHeight
            ]
        );

        $this->writeGdImage($croppedImg, $derivedPath);

        return $derivedPath;
    }

    /**
     * Store `$image` and return generated file path.
     * @param \Illuminate\Http\File $image
     * @return string
     */
    public function store(File $image): string
    {
        $path = $this->disk->putFile($this->basePath, $image);
        
        $this->fixImageOrientation($path);
        
        return $path;
    }

    /**
     * Store `$image` with file name `$filename`. Return entire file path.
     * @param \Illuminate\Http\File $image
     * @param string $path
     * @return string
     */
    public function storeAs(File $image, string $path): string
    {
        return $this->disk->putFileAs($this->basePath, $image, $path);
    }

    /**
     * Destroy file specified by `$path`.
     * @param string $path
     * @return void
     */
    public function destroy(string $path): bool
    {
        return $this->disk->delete($this->prependBasePath($path));
    }

    /**
     * Replace original file at `$path` with `$image`.
     * @param \Illuminate\Http\File $image
     * @param string $path
     * @return string
     */
    public function update(File $image, string $path): string
    {
        $this->destroy($path);
        return $this->storeAs($image, $path);
    }

    /**
     * Get contents of file specified by `$path` as a string.
     * 
     * `$dimension` can be any of the keys of the `'dimensions'` array in `config/images.php`.
     * @param string $path
     * @param string $dimension
     * @return string
     */
    public function get(string $path, string $dimension = ''): string
    {
        return $this->disk->get($this->createDerivative($path, $dimension));
    }

    /**
     * Get URL to file specified by `$path`.
     * 
     * `$dimension` can be any of the keys of the `'dimensions'` array in `config/images.php`.
     * @param string $path
     * @param string $dimension
     * @return string
     */
    public function getUrl(string $path, string $dimension = ''): string
    {
        return $this->disk->url($this->createDerivative($path, $dimension));
    }

    /**
     * Get absolute path to `$path`, after prepending `$this->basePath`.
     * 
     * `$dimension` can be any of the keys of the `'dimensions'` array in `config/images.php`.
     * @param string $path
     * @param string $dimension
     * @return string
     */
    public function getAbsolutePath(string $path, string $dimension = ''): string
    {
        return $this->disk->path($this->createDerivative($path, $dimension));
    }

    /**
     * Write `$image` to `$path`.
     * 
     * Actual write location determined by `$this->getAbsolutePath`. Currently supports GIF, JPEG, and PNG. Will throw an error if anything else is supplied.
     * @param \GdImage $image
     * @param string $path
     * @throws \GSVnet\Core\Exceptions\ImageTypeNotValidException
     * @return void
     */
    private function writeGdImage(GdImage $image, string $path): void
    {
        $absPath = $this->getAbsolutePath($path);
        [ , , $imgType] = getimagesize($absPath);

        switch ($imgType) {
            case IMAGETYPE_GIF:
                imagegif($image, $absPath);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($image, $absPath);
                break;
            case IMAGETYPE_PNG:
                imagepng($image, $absPath);
                break;
            default:
                throw new ImageTypeNotValidException('Only GIF, JPEG, and PNG are supported.');
        }
    }

    /**
     * Restrict size to `dimensions['max']`, as specified in `config/images.php`.
     * @param string $path
     * @return void
     */
    private function restrictSize(string $path) 
    {
        [$maxWidth, $maxHeight] = config('images.dimensions.max');

        // Read image into a string
        $imgString = $this->get($path);
        [$width, $height] = getimagesizefromstring($imgString);

        if ($width > $maxWidth || $height > $maxHeight) {
            // Downscaling by the strictest (smallest) factor will also
            // satisfy the constraint for the other dimension
            $scaleFactor = min($maxWidth / $width, $maxHeight / $height);

            // Create image object from string
            $originalImg = imagecreatefromstring($imgString);

            $scaledImg = imagescale(
                $originalImg, 
                $scaleFactor * $width, 
                $scaleFactor * $height,
                IMG_BICUBIC
            );

            // Replace original image by scaled image
            $this->writeGdImage($scaledImg, $path);
        }
    }

    /**
     * Try to fix orientation of image specified by `path`.
     * @param string $path
     * @return void
     */
    private function fixImageOrientation(string $path) 
    {
        $absPath = $this->getAbsolutePath($path);
        $exif = exif_read_data($absPath);
        
        // Create image object in memory
        $image = imagecreatefromstring($this->get($path));
        
        if (!empty($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 3:
                    $image = imagerotate($image, 180, 0);
                    break;
                
                case 6:
                    $image = imagerotate($image, 90, 0);
                    break;
                
                case 8:
                    $image = imagerotate($image, -90, 0);
                    break;
            }
        }

        // Write rotated image object over original file
        $this->writeGdImage($image, $path);
    }
}