<?php namespace GSVnet\Committees;

use App\Models\User;
use App\Models\Committee;


class CommitteesRepository
{
    public function byUserOrderByRecent(User $user)
    {
        return $user->committees()->orderByRaw('-end_date ASC')->orderBy('end_date', 'ASC')->get();
    }

    public function all()
    {
        return Committee::all();
    }

    /**
     * Get by id.
     *
     * @param int $id
     * @return Committee
     */
    public function byId($id): Committee
    {
        return Committee::findOrFail($id);
    }

    public function bySlug($slug): Committee
    {
        return Committee::where('unique_name', '=', $slug)->firstOrFail();
    }

    /**
     * Get paginated committees.
     *
     * @param int $amount
     */
    public function paginate($amount)
    {
        return Committee::orderBy('name', 'ASC')->paginate($amount);
    }

    /**
    * Create committee.
    *
    * @param array $input
    * @return Committee
    */
    public function create(array $input)
    {
        $committee              = new Committee();
        $committee->name        = $input['name'];
        $committee->unique_name = $input['unique_name'];
        $committee->description = $input['description'];
        $committee->public      = $input['public'];

        $committee->save();

        return $committee;
    }

    /**
    * Update committee.
    *
    * @param int $id
    * @param array $input
    * @return Committee
    */
    public function update($id, array $input)
    {
        $committee              = $this->byId($id);

        $committee->name        = $input['name'];
        $committee->unique_name = $input['unique_name'];
        $committee->description = $input['description'];
        $committee->public      = $input['public'];

        $committee->save();

        return $committee;
    }

    /**
    * Delete committee.
    *
    * @param int $id
    * @return void
    */
    public function delete($id)
    {
        $committee = $this->byId($id);

        // Delete user-committee rows from linking table
        $committee->members()->detach();

        $committee->delete();
    }
}