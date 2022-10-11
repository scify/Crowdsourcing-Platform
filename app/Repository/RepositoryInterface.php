<?php

namespace App\Repository;

interface RepositoryInterface {
    public function all($columns = ['*']);

    public function paginate($perPage = 15, $columns = ['*']);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id, $columns = ['*']);

    public function findBy($field, $value, $columns = ['*']);

    public function updateOrCreate($criteria, $data);

    public function firstOrCreate($criteria, $data);

    public function allWhere(array $whereArray, $columns = ['*'], $orderColumn = null, $order = null, $withRelationships = []);

    public function where(array $whereArray, array $columns = ['*']);
}
