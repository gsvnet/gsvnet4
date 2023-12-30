<?php namespace GSVnet\Tags;

use App\Models\Tag;
use GSVnet\Core\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;

class TagRepository extends EloquentRepository
{
    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    public function getAllTagsBySlug($slugString)
    {
        if (is_null($slugString)) {
            return new Collection;
        }

        if (stristr($slugString, ',')) {
            $slugSlugs = explode(',', $slugString);
        } else {
            $slugSlugs = (array) $slugString;
        }

        return $this->model->whereIn('slug', (array) $slugSlugs)->get();
    }

    public function getTagIdList()
    {
        return $this->model->lists('id');
    }

    public function getTagsByIds($ids): Collection|null
    {
        if ( ! $ids) return null;
        return $this->model->whereIn('id', $ids)->get();
    }

    /**
     * Same as `Tag::all()`.
     * 
     * The GSVnet 3 database allowed forum- and article-specific tags, which is now deprecated. This function is kept for legacy reasons.
     * 
     * @return Collection
     */
    public function getAllForForum()
    {
        return $this->model->all();
    }

    public function getAllForArticles()
    {
        return $this->model->where('articles', '=', 1)->get();
    }
}
