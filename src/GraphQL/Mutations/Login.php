<?php

namespace Mpie\LighthouseOAuth\GraphQL\Mutations;

use Mpie\LighthouseOAuth\GraphQL\Auth\AuthResolver;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Login extends AuthResolver
{
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo): array
    {
        $response = $this->request($args);

        return array_merge($response, ['user' => config('lighthouse-oauth2.fetch_user') ? $this->getUser($args['username']) : null]);
    }

    protected function getUser(string $username): Model
    {
        return $this->makeAuthModelInstance()::query()
            ->where(config('lighthouse-oauth2.match_user_by'), '=', $username)
            ->firstOrFail();
    }
}
