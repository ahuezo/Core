<?php

namespace TypiCMS\Modules\Core;

use Rinvex\Repository\Repositories\EloquentRepository as BaseRepository;

class EloquentRepository extends BaseRepository
{
    /**
     * Make a new instance of the entity to query on.
     *
     * @param array $with
     */
    public function make(array $with = [])
    {
        return $this->with($with);
    }

    /**
     * Get next model.
     *
     * @param Model $model
     * @param int   $category_id
     * @param array $with
     * @param bool  $all
     *
     * @return Model|null
     */
    public function next($model, $category_id = null, array $with = [], $all = false)
    {
        return $this->adjacent(1, $model, $category_id, $with, $all);
    }

    /**
     * Get prev model.
     *
     * @param Model $model
     * @param int   $category_id
     * @param array $with
     * @param bool  $all
     *
     * @return Model|null
     */
    public function prev($model, $category_id = null, array $with = [], $all = false)
    {
        return $this->adjacent(-1, $model, $category_id, $with, $all);
    }

    /**
     * Get prev model.
     *
     * @param int   $direction
     * @param Model $model
     * @param int   $category_id
     * @param array $with
     * @param bool  $all
     *
     * @return Model|null
     */
    public function adjacent($direction, $model, $category_id = null, array $with = [], $all = false)
    {
        $currentModel = $model;
        if ($category_id !== null) {
            $models = $this->with(['category'])->findWhere(['category_id', $category_id], ['id', 'slug']);
        } else {
            $models = $this->published()->findAll(['id', 'slug']);
        }
        foreach ($models as $key => $model) {
            if ($currentModel->id == $model->id) {
                $adjacentKey = $key + $direction;

                return isset($models[$adjacentKey]) ? $models[$adjacentKey] : null;
            }
        }
    }

    /**
     * Get single model by Slug.
     *
     * @param string $slug
     * @param array  $attributes
     *
     * @return mixed
     */
    public function bySlug($slug, $attributes = ['*'])
    {
        $model = $this
            ->findBy(column('slug'), $slug, $attributes);

        if (is_null($model)) {
            abort(404);
        }

        return $model;
    }

    public function published()
    {
        return $this->where(column('status'), '1');
    }
}