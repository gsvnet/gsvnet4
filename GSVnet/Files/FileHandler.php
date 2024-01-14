<?php namespace GSVnet\Files;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File as F;
use Illuminate\Support\Facades\Storage;

// This class handles all file manipulation methods on disk. Warning: Does not handle database manipulation!
class FileHandler
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
    public function prependBasePath(string $path): string
    {
        // Do nothing if $path already starts with base path or is absolute
        if (str_starts_with($path, $this->basePath) || str_starts_with($path, '/'))
            return $path;

        return $this->join_paths($this->basePath, $path);
    }

    /**
     * Saves a file at the given location after prepending FileHandler->basePath.
     * 
     * @param UploadedFile $file
     * @param string $path
     * @return string
     */
    public function make(UploadedFile $file, $path = '/uploads/files/')
    {
        // Stream file to location and return generated file name
        return $this->disk->putFile($this->prependBasePath($path), $file);
    }

    /**
     * Update a file by first removing the old one and then making the new one.
     * 
     * @param UploadedFile $file
     * @param string $path
     */
    public function update($file, $path)
    {
        $this->destroy($path);
        $this->make($file, $path);
    }

    /**
     * Destroy the file at `$path`.
     * 
     * @param string $path
     */
    public function destroy(string $path)
    {
        $fullPath = $this->prependBasePath($path);

        if ($this->disk->exists($fullPath))
            $this->disk->delete($fullPath);
    }

    /**
     * Return the size of the file at `$path`.
     */
    public function fileSize(string $path)
    {
        return $this->disk->size($this->prependBasePath($path));
    }

    /**
     * Get extension of file at `$path`. May fail if file is not on local disk.
     */
    public function extension(string $path)
    {
        return F::extension($this->prependBasePath($path));
    }

    /**
     * Download file at `$path`.
     * 
     * @param string $path Path to file on disk, including disk file name. Does not need to have `$this->basePath` prepended to it.
     * @param string $name File name as seen by the user.
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(string $path, string $name)
    {
        return $this->disk->download($this->prependBasePath($path), $name);
    }
}