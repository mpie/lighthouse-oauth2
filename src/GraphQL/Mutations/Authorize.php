<?php

namespace Mpie\LighthouseOAuth\GraphQL\Mutations;

use Mpie\LighthouseOAuth\GraphQL\Auth\AuthResolver;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Authorize extends AuthResolver
{
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo): array
    {
        return $this->request($args);
    }
}
