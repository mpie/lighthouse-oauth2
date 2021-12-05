<?php

namespace Mpie\LighthouseOAuth\GraphQL\Auth;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Eloquent\Model;

class AuthModelFactory
{
    public function make(array $attributes = []): Model
    {
        $class = config('auth.providers.'.config('lighthouse-oauth2.provider').'.model');

        return new $class($attributes);
    }

    public function create(array $attributes = []): Model
    {
        $model = $this->make($attributes);
        $model->save();

        return $model;
    }
}
