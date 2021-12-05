<?php

namespace Mpie\LighthouseOAuth\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Lcobucci\JWT\Configuration;
use Mpie\LighthouseOAuth\GraphQL\Auth\AuthResolver;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RefreshToken extends AuthResolver
{
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo): array
    {
        $response = $this->request($args);
        $userId = $this->parseToken($response['access_token']);
        $this->makeAuthModelInstance()->findOrFail($userId);

        return $response;
    }

    public function parseToken($accessToken): string
    {
        $config = Configuration::forUnsecuredSigner();
        $token = $config->parser()->parse((string) $accessToken);
        $claims = $token->claims();

        return $claims->get('sub');
    }
}
