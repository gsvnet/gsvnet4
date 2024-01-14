<?php namespace Admin;

use View, Input, Redirect;

use App\Http\Controllers\Controller;
use GSVnet\Files\FileManager;
use GSVnet\Files\FilesRepository;

use GSVnet\Files\Labels\LabelsRepository;
use App\Http\Requests\StoreFileRequest;
use App\Models\File;
use App\Http\Requests\UpdateFileRequest;

class FilesController extends Controller
{
    public function __construct(
        private FilesRepository $files, 
        private LabelsRepository $labels, 
        private FileManager $fileManager
    ) {
        $this->authorize('docs.manage');
    }

    public function index()
    {
        $files = $this->files->paginate(10, false);
        $labels = $this->labels->all();

        $checked = array();

        foreach ($labels as $label)
            $checked[$label->id] = '';

        return view('admin.files.index')
            ->with(compact('files', 'labels', 'checked'));
    }

    public function store(StoreFileRequest $request)
    {
        $input = $request->all();
        $input['file'] = $request->file('file');
        $input['published'] = $request->get('published', false);

        $file = $this->fileManager->create($input);

        session()->flash('success', "{$file->name} is succesvol opgeslagen");

        return redirect()->action([$this::class, 'index']);
    }

    public function edit(File $file)
    {
        $labels = $this->labels->all();

        // Get the file's labels
        $checked = array();
        $fileIdLabels = $file->labels->pluck('id')->all();
        foreach ($labels as $label) {
            $checked[$label->id] = in_array($label->id, $fileIdLabels) ? 'checked' : '';
        }

        return view('admin.files.edit')
            ->with(compact('files', 'labels', 'checked'));
    }

    public function update(UpdateFileRequest $request, File $file)
    {
        $input = $request->all();
        $input['file'] = $request->file('file');
        $input['published'] = $request->get('published', false) == '1';

        $file = $this->fileManager->update($file, $input);

        session()->flash('success', "{$file->name} is succesvol bijgewerkt.");

        return redirect()->action([$this::class, 'index']);
    }

    public function destroy(File $file)
    {
        $file = $this->fileManager->destroy($file);

        session()->flash('success', "{$file->name} is succesvol verwijderd.");

        return redirect()->action([$this::class, 'index']);
    }

}