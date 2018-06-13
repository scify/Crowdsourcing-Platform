<?php

namespace App\Repository;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface {

    /**
     * @var App
     */
    private $app;

    /**
     * Query builder for this model
     * @var
     */
    protected $modelQuery;

    /**
     * @param App $app
     * @throws RepositoryException
     */
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModelQuery();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function getModelClassName();

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*')) {
        return $this->modelQuery->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')) {
        return $this->modelQuery->orderBy('updated_at', 'desc')->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {
        return $this->modelQuery->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute="id") {
        return $this->modelQuery->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->modelQuery->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')) {
        return $this->modelQuery->find($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*')) {
        return $this->modelQuery->where($attribute, '=', $value)->first($columns);
    }

    public function where($whereArray, $columns = array('*')) {
        return $this->modelQuery->where($whereArray)->first($columns);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    private function makeModelQuery() {
        $tryToCreateModel = $this->app->make($this->getModelClassName());

        if (!$tryToCreateModel instanceof Model)
            throw new RepositoryException("Class {$this->getModelClassName()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->modelQuery = $tryToCreateModel->newQuery();
    }



    public function getModelInstance() {
        return $this->app->make($this->getModelClassName());
    }
}