<?php

namespace App\Repository;

use Illuminate\Container\Container as App;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class Repository implements RepositoryInterface {
    /**
     * @var App
     */
    private $app;

    /**
     * Query builder for this model
     */
    protected $modelInstance;

    /**
     * @throws RepositoryException
     */
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModelInstance();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract public function getModelClassName();

    public function all($columns = ['*'], $orderColumn = null, $order = null, $withRelationships = []) {
        $query = $this->modelInstance;

        if ($orderColumn) {
            $query = $query->orderBy($orderColumn, $order ? $order : 'asc');
        }
        if (count($withRelationships) > 0) {
            $query = $query->with($withRelationships);
        }

        return $query->get($columns);
    }

    public function allWithTrashed($columns = ['*'],
                                   $orderColumn = null,
                                   $order = null,
                                   $withRelationships = []): Collection {
        $query = $this->modelInstance;

        if ($orderColumn) {
            $query = $query->orderBy($orderColumn, $order ? $order : 'asc');
        }
        if (count($withRelationships) > 0) {
            $query = $query->with($withRelationships);
        }

        return $query->withTrashed()->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = ['*']) {
        return $this->modelInstance->orderBy('updated_at', 'desc')->paginate($perPage, $columns);
    }

    /**
     * @return mixed
     */
    public function create(array $data) {
        return $this->modelInstance->create($data);
    }

    /**
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = 'id') {
        return $this->modelInstance->where($attribute, '=', $id)->update($this->onlyFillable($data));
    }

    public function updateOrCreate($criteria, $data) {
        return $this->modelInstance->updateOrCreate(
            $criteria,
            $data
        );
    }

    protected function onlyFillable(array $items) {
        if (count($this->modelInstance->getFillable()) === 0) {
            return $items;
        }

        $qualified = [];
        foreach ($items as $key => $val) {
            if (in_array($key, $this->modelInstance->getFillable())) {
                $qualified[$key] = $val;
            }
        }

        return $qualified;
    }

    /**
     * @return mixed
     */
    public function delete($id) {
        return $this->modelInstance->destroy($id);
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'], array $withRelationships = []) {
        $query = $this->modelInstance;
        if (count($withRelationships)) {
            $query = $query->with($withRelationships);
        }

        return $query->findOrFail($id, $columns);
    }

    public function firstOrCreate($criteria, $data) {
        return $this->modelInstance->firstOrCreate(
            $criteria,
            $data
        );
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*'], bool $caseInsensitive = false, array $withRelationships = []) {
        $query = $this->modelInstance;
        if (count($withRelationships) > 0) {
            $query = $query->with($withRelationships);
        }

        if ($caseInsensitive) {
            $query = $query->whereRaw('LOWER(`' . $field . "`) LIKE '" .
                strtolower($value) . "'");
        } else {
            $query = $query->where($field, '=', $value);
        }

        $model = $query->first();

        if (!$model) {
            throw new ModelNotFoundException("Model with criteria: '" . $field . "' equal to '" . $value . "' was not found.");
        }

        return $model;
    }

    public function exists($whereArray): bool {
        $models = $this->allWhere($whereArray);

        return !$models->isEmpty();
    }

    public function where(array $whereArray, array $columns = ['*']) {
        return $this->modelInstance->where($whereArray)->first($columns);
    }

    public function allWhere(array $whereArray, $columns = ['*'], $orderColumn = null, $order = null, $withRelationships = []) {
        $query = $this->modelInstance->where($whereArray);

        if ($orderColumn) {
            $query = $query->orderBy($orderColumn, $order ? $order : 'asc');
        }
        if (count($withRelationships) > 0) {
            $query = $query->with($withRelationships);
        }

        return $query->get($columns);
    }

    public function whereWithTrashed($whereArray,
                                     $columns = ['*'],
                                     $orderColumn = null,
                                     $order = null,
                                     $withRelationships = []): Collection {
        $query = $this->modelInstance->where($whereArray);

        if ($orderColumn) {
            $query = $query->orderBy($orderColumn, $order ? $order : 'asc');
        }

        if (count($withRelationships) > 0) {
            $query = $query->with($withRelationships);
        }

        return $query->withTrashed()->get($columns);
    }

    /**
     * @throws RepositoryException
     * @throws BindingResolutionException
     */
    private function makeModelInstance(): Model {
        $tryToCreateModel = $this->app->make($this->getModelClassName());

        if (!$tryToCreateModel instanceof Model) {
            throw new RepositoryException("Class {$this->getModelClassName()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->modelInstance = $tryToCreateModel;
    }

    public function getModelInstance() {
        return $this->app->make($this->getModelClassName());
    }
}
