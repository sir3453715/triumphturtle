<?php

namespace App\Repositories;

use App\TranslatableModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param  Model $model
     * @return void
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * 取得Model的class name
     *
     * @return string
     */
    public function getModelClass()
    {
        return get_class($this->model);
    }

    /**
     * 新建一個Model的instance
     *
     * @return Model
     */
    public function createModel()
    {
        return app($this->getModelClass());
    }

    /**
     * 查詢所有
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function queryAll()
    {
        $modelClass = $this->getModelClass();
        return $modelClass::all();
    }

    /**
     * 查詢特定ID
     *
     * @param $id
     * @return Model|null
     */
    public function findModel($id)
    {
        return $this->getModel()->find($id);
    }

    /**
     * 刪除特定id
     *
     * @param $id
     * @return bool|null
     * @throws \Exception
     */
    public function deleteModel($id)
    {
        return $this->findModel($id)->delete();
    }

    /**
     * @param $id
     * @return bool
     */
    public function hasModel($id)
    {
        return $this->getModel()->where('id', $id)->exists();
    }
}
