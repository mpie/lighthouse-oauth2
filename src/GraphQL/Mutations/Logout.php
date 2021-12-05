<?php

namespace Mpie\LighthouseOAuth\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Mpie\LighthouseOAuth\Exceptions\AuthenticationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Logout
{
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo): array
    {
        if (! auth(config('lighthouse-oauth2.guard'))->check()) {
            throw new AuthenticationException('Not Authenticated', 'Check if you have set the correct guard');
        }

        auth(config('lighthouse-oauth2.guard'))->user()->token()->revoke();

        return ['message' => 'Successfully logged out'];
    }
}
