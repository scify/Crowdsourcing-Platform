<?php

namespace App\Repository;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use JsonSchema\Exception\ResourceNotFoundException;

abstract class Repository implements RepositoryInterface {

    /**
     * @var App
     */
    private $app;

    /**
     * Query builder for this model
     * @var
     */
    protected $modelInstance;

    /**
     * @param App $app
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
    abstract function getModelClassName();


    public function all($columns = array('*'), $orderColumn = null, $order = null) {
        $query = $this->modelInstance;

        if($orderColumn)
            $query->orderBy($orderColumn, $order ? $order : 'asc');

        return $query->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')) {
        return $this->modelInstance->orderBy('updated_at', 'desc')->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {
        return $this->modelInstance->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute="id") {
        return $this->modelInstance->where($attribute, '=', $id)->update($this->onlyFillable($data));
    }

    protected function onlyFillable(array $items) {
        $qualified = array();

        foreach($items as $key => $val) {
            if(in_array($key, $this->modelInstance->getFillable()))
                $qualified[$key] = $val;
        }

        return $qualified;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->modelInstance->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')) {
        $model = $this->modelInstance->find($id, $columns);
        if(!$model)
            throw new ModelNotFoundException("Model of type " . $this->getModelClassName() . " with id " . $id . " not found");
        return $model;
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*')) {
        $model = $this->modelInstance->where($attribute, '=', $value)->first($columns);
        if(!$model)
            throw new ModelNotFoundException("Model of type " . $this->getModelClassName() .
                " with attribute "  . $attribute . " equal to " . $value . " not found");
        return $model;
    }

    public function where($whereArray, $columns = array('*')) {
        return $this->modelInstance->where($whereArray)->first($columns);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    private function makeModelInstance() {
        $tryToCreateModel = $this->app->make($this->getModelClassName());

        if (!$tryToCreateModel instanceof Model)
            throw new RepositoryException("Class {$this->getModelClassName()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->modelInstance = $tryToCreateModel;
    }



    public function getModelInstance() {
        return $this->app->make($this->getModelClassName());
    }
}
