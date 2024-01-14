<?php namespace GSVnet\Files;

use App\Models\File;
use GSVnet\Core\Exceptions\FileStorageException;

/**
 * Class responsible for calling other classes that actually change file on disk and in database.
 */
class FileManager
{

    // TODO: Move validation to Admin\FilesController

    public function __construct(
        private FileHandler $fileHandler,
        private FilesRepository $files
    ) {}

    /**
     * Create File model and store file on disk.
     *
     * @param array $input
     * @return File
     */
    public function create(array $input)
    {
        // Store the file file and get its new path
        $this->uploadFile($input);
        // If the file was not given a name, use the file's name
        $this->nameFile($input);
        // Save the file to the database
        return $this->files->create($input);
    }

    /**
     * Update File model and optionally update file on disk.
     *
     * @param File $file
     * @param array $input
     * @return File
     */
    public function update(File $file, array $input)
    {
        // Optionally update the file's file
        if (isset($input['file']))
        {
            // Delete the old file file and store the new one
            $this->fileHandler->destroy($file->file_path);
            // Store the file file and get its new path
            $this->uploadFile($input);
            // If the file was not given a name, use the file's name
            $this->nameFile($input);
        }
        // Save the file to the database
        return $this->files->update($file->id, $input);
    }

    /**
     * Delete File model from database and destroy file on disk.
     * 
     * @param File $file
     */
    public function destroy(File $file)
    {
        $this->files->delete($file->id);
        // Delete file files
        $this->fileHandler->destroy($file->file_path);

        return $file;
    }

    // Uploads a file and adjust the input's file_path accordingly
    private function uploadFile(&$input)
    {
        if (! $input['file_path'] = $this->fileHandler->make($input['file'],
                "/uploads/files/"))
        {
            throw new FileStorageException;
        }
    }

    // Set file's name if name was not provided
    private function nameFile(&$input)
    {
        // If the file was not given a name, use the file's name
        if (! (isset($input['name'])) || $input['name'] == '')
        {
            $input['name'] = $input['file']->getClientOriginalName();
        }
    }
}