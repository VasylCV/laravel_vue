<?php

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\BaseRepository;

/**
 * Class ArticleRepository
 * @package App\Repositories
 * @version April 19, 2022, 1:13 pm UTC
*/

class ArticleRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldSearchable = [
        'title',
        'text',
        'author_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Article::class;
    }

    /**
     * @param array $search
     * @param null $skip
     * @param null $limit
     * @param array|string[] $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $query = $this->allQuery($search, $skip, $limit);

        $query->with('author:id,name,role_id');

        return $query->get($columns);
    }

    /**
     * @param array $input
     * @return false|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function create($input)
    {
        $model = $this->model->newInstance($input);

        $create = $model->save();

        if (!$create) {
            return false;
        }

        return $this->findWithRelation($model->id, 'author:id,name');
    }

    /**
     * @param $id
     * @param $relation
     * @param string[] $columns
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findWithRelation($id, $relation, $columns = ['*'])
    {
        $query = $this->model->newQuery();

        $query->with($relation);

        return $query->find($id, $columns);
    }
}
