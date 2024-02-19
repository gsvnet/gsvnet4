<?php namespace GSVnet\Senates;

use App\Models\Senate;


class SenatesRepository
{
    public function all()
    {
        return Senate::orderBy('start_date', 'DESC')->get();
    }

    public function byId($id)
    {
        return Senate::findOrFail($id);
    }

    public function paginate(int $amount)
    {
        return Senate::with('members')->orderBy('updated_at', 'DESC')->paginate($amount);
    }

    /**
    * Create senate.
    *
    * @param array $input
    * @return Senate
    */
    public function create(array $input)
    {
        $senate              = new Senate();
        $senate->name        = $input['name'];
        $senate->body        = $input['body'];
        $senate->start_date  = $input['start_date'];
        $senate->end_date    = $input['end_date'];

        $senate->save();

        return $senate;
    }

    /**
    * Update senate.
    *
    * @param int $id
    * @param array $input
    * @return Senate
    */
    public function update($id, array $input)
    {
        $senate              = $this->byId($id);

        $senate->name        = $input['name'];
        $senate->body        = $input['body'];
        $senate->start_date  = $input['start_date'];
        $senate->end_date    = $input['end_date'];

        $senate->save();

        if (isset($input['members']))
        {
            $senate->members()->sync($input['members']);
        }

        return $senate;
    }

    /**
    * Delete senate.
    *
    * @param int $id
    * @return void
    */
    public function delete($id)
    {
        $senate = $this->byId($id);

        // Delete user-senate rows from linking table
        $senate->members()->detach();

        $senate->delete();
    }
}