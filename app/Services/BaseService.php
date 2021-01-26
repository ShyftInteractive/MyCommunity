<?php

namespace App\Services;

use App\Services\BaseQueries;
use Illuminate\Database\Eloquent\Model;

class BaseService
{

    public function __construct(public Model $model)
    {
    }

    public function query()
    {
        return new BaseQueries($this->model);
    }

    public function factory()
    {
        return new BaseFactory($this->model);
    }
}
