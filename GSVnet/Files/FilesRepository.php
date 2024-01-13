<?php namespace GSVnet\Files;

use App\Models\File;
use GSVnet\Permissions\NoPermissionException;
use Illuminate\Support\Facades\Gate;
use Permission;

/**
 * Class that can view and edit File database information. Warning: Does not change file on disk!
 */
class FilesRepository
{
    /**
    * Get all files.
    *
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function all($published = true)
    {
        return File::published($published)->all();
    }

    /**
     * Get paginated files.
     *
     * @param int $amount
     * @param bool $published
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $amount, $published = true)
    {
        return File::published($published)
            ->orderBy('updated_at', 'desc')
            ->paginate($amount);
    }

    /**
    * Get all files belonging to the conjunction of selected labels.
    *
    * @param int $amount
    * @param array $labels
    * @param bool $published
    * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
    */
    public function paginateWhereLabels(
        int $amount, 
        array $labels = [], 
        bool $published = true
    ) {
        $count = count($labels);

        // Just return paginated data when we have no restriction on the labels
        if ($count == 0)
            return $this->paginate($amount, $published);

        // Return all files with the specified labels
        return File::published($published)
            ->withLabels($labels)
            ->orderBy('updated_at', 'desc')
            ->paginate($amount);
    }

    /**
     * Get all published files that have a name matching `$search` and belong to the selected labels.
     * 
     * @param int $amount
     * @param string $search
     * @param array $labels
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginatePublishedWhereSearchAndLabels(
        int $amount = 5,
        string $search, 
        array $labels 
    ) {
        $query = File::published();

        if ( ! empty($search))
            $query = $query->search('*' . $search . '*');

        if ( ! empty($labels))
            $query = $query->withLabels($labels);

        return $query->orderBy('updated_at', 'desc')->paginate($amount);
    }

    /**
     * Get by id.
     * 
     * @param int $id
     * @return File
     * @throws NoPermissionException
     */
    public function byId(int $id)
    {
        $file = File::findOrFail($id);

        if (! $file->published and Gate::denies('docs.publish'))
            throw new NoPermissionException;

        return $file;
    }

    /**
    * Create File in database.
    *
    * @param array $input
    * @return File
    */
    public function create(array $input)
    {
        $file = new File;
        $file->name = $input['name'];
        $file->file_path = $input['file_path'];

        if (Gate::allows('docs.publish'))
        {
            $file->published = $input['published'];
        }

        $file->save();

        if (isset($input['labels']))
        {
            $file->labels()->sync($input['labels']);
        }

        return $file;
    }

    /**
    * Update File in database.
    *
    * @param int $id
    * @param array $input
    * @return File
    */
    public function update($id, array $input)
    {
        $file = $this->byId($id);
        $file->fill($input);

        if (Gate::allows('docs.publish'))
        {
            $file->published = $input['published'];
        }
        
        $file->save();

        // Reset the selected labels
        if (isset($input['labels']))
        {
            $file->labels()->sync($input['labels']);
        }
        else
        {
            $file->labels()->sync(array());
        }

        return $file;
    }

    /**
    * Delete File from database.
    *
    * @param int $id
    * @return File
    */
    public function delete($id)
    {
        $file = $this->byId($id);
        $file->delete();

        return $file;
    }
}