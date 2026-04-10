<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(public Model $model)
    {
        $this->model = $model;
    }

    public function save(array $data): Model
    {
        $newModel = new ($this->model::class)();
        $newModel->fill($data);
        $newModel->save();
        return $newModel;
    }

    public function update(Model $model, array $data): Model
    {
        $model->fill($data);
        $model->save();
        return $model;
    }

    public function delete(Model $model): void
    {
        $model->delete();
    }
}