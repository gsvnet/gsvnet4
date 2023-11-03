<?php 

namespace GSVnet\Core;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

// TODO: Extensively test this class. GSVnet 3 made use of Intervention's Image class,
// but that one does not seem to be maintained very well anymore (devs don't reply to
// issues about security concerns). I therefore opted for using the GD image functions,
// which are a bit more clunky.

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
     * @param string $path
     * @return string
     */
    public function get(string $path): string
    {
        return $this->disk->get($this->prependBasePath($path));
    }

    /**
     * Get URL to file specified by `$path`.
     * @param string $path
     * @return string
     */
    public function getUrl(string $path): string
    {
        return $this->disk->url($this->prependBasePath($path));
    }

    /**
     * Get absolute path to `$path`, after prepending `$this->basePath`.
     * @param string $path
     * @return string
     */
    public function getAbsolutePath(string $path): string
    {
        return $this->disk->path($this->prependBasePath($path));
    }

    /**
     * Try to fix orientation of image specified by `path`.
     * @param string $path
     * @return void
     */
    private function fixImageOrientation(string $path) {
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
        imagejpeg($image, $absPath);
    }
}