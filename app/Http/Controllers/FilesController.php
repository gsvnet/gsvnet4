<?php

namespace App\Http\Controllers;

use App\Models\File;
use GSVnet\Files\FileHandler;
use GSVnet\Files\FilesRepository;
use GSVnet\Files\Labels\LabelsRepository;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function __construct(
        private FilesRepository $files,
        private LabelsRepository $labels,
        private FileHandler $fileHandler
    ) {
        $this->authorize('docs.show');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Select all files which belong to (all of) the selected labels
        $selectedLabels = $request->get('labels');
        $search = $request->get('search');
        $filesPerPage = 10;

        $files = $this->files->paginatePublishedWhereSearchAndLabels(
            $filesPerPage, $search, $selectedLabels
        );

        $labels = $this->labels->all();

        return view('files.index')
            ->with(compact('files', 'labels'));
    }

    /**
     * Display the specified resource.
     *
     * @param File $file
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function show(File $file)
    {
        return $this->fileHandler->download(
            $file->file_path, 
            $file->name . $file->type);
    }
}
