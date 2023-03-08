<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use App\Traits\LogTrait;

abstract class BaseRepository implements RepositoryInterface
{
    use LogTrait;

    protected $model;

    /**
     * Create a new BaseRepository instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model to set
     */
    abstract public function model();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->model()
        );
    }

    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function getAll($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    /**
     * Get data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function getByField($field, $value = null, $columns = ['*'])
    {
        return $this->model->where($field, $value)->get($columns);
    }

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByField($field, $value = null, $columns = ['*'])
    {
        return $this->model->where($field, $value)->first($columns);
    }

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     *
     */
    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    /**
     * Update a entity in repository by id
     *
     * @param       $id
     * @param array $attributes
     *
     * @return mixed
     *
     */
    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }
        return null;
    }

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return boolean
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();
            return true;
        }
        return false;
    }

    //updateOrCreate($conditions = [], $attributesValues = []);
}
