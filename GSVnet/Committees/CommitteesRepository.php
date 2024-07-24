<?php namespace GSVnet\Committees;

use App\Models\User;
use App\Models\Committee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelIdea\Helper\App\Models\_IH_Committee_C;


class CommitteesRepository
{
    public function byUserOrderByRecent(User $user): array|Collection|_IH_Committee_C
    {
        return $user->committees()->orderByRaw('-end_date ASC')->orderBy('end_date', 'ASC')->get();
    }

    public function all(): array|Collection|_IH_Committee_C
    {
        return Committee::all();
    }

    /**
     * Get by id.
     *
     * @param int $id
     * @return Committee
     */
    public function byId(int $id): Committee
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
     * @return Committee[]|LengthAwarePaginator|_IH_Committee_C
     */
    public function paginate(int $amount): array|LengthAwarePaginator|_IH_Committee_C
    {
        return Committee::orderBy('name', 'ASC')->paginate($amount);
    }

    /**
     * Create committee.
     *
     * @param array $input
     * @return Committee
     */
    public function create(array $input): Committee
    {
        $committee = new Committee();
        $committee->name = $input['name'];
        $committee->unique_name = $input['unique_name'];
        $committee->description = $input['description'];
        $committee->public = $input['public'];

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
    public function update(int $id, array $input): Committee
    {
        $committee = $this->byId($id);

        $committee->name = $input['name'];
        $committee->unique_name = $input['unique_name'];
        $committee->description = $input['description'];
        $committee->public = $input['public'];

        $committee->save();

        return $committee;
    }

    /**
     * Delete committee.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $committee = $this->byId($id);

        // Delete user-committee rows from linking table
        $committee->members()->detach();

        $committee->delete();
    }
}
