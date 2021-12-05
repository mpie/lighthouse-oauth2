<?php

namespace Mpie\LighthouseOAuth\GraphQL\Auth;

use Illuminate\Database\Eloquent\Model;

class AuthModelFactory
{
    public function make(array $attributes = []): Model
    {
        $provider = config('auth.guards.'.config('lighthouse-oauth2.guard').'.provider');
        $class = config("auth.providers.$provider.model");

        return new $class($attributes);
    }

    public function create(array $attributes = []): Model
    {
        $model = $this->make($attributes);
        $model->save();

        return $model;
    }
}
