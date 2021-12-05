<?php

namespace Mpie\LighthouseOAuth\GraphQL\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Mpie\LighthouseOAuth\Exceptions\AuthenticationException;

class AuthResolver
{
    public function request(array $args, string $grantType = null, string $scope = null): array
    {
        $parameters = $this->makeParameters($args, $grantType, $scope);

        $uri = $parameters->get('grant_type') === 'password'
            ? config('lighthouse-oauth2.domain').'/oauth/token'
            : config('lighthouse-oauth2.domain').'/oauth/authorize';

        $request = Request::create(
            uri: $uri,
            method: 'POST',
            parameters: $parameters->toArray(),
            server: ['HTTP_ACCEPT' => 'application/json']
        );

        $response = app()->handle($request);
        $decodedResponse = json_decode($response->getContent(), true);

        if ($response->getStatusCode() != 200) {
            throw new AuthenticationException($decodedResponse['error'] ?? '', $decodedResponse['message']);
        }

        return $decodedResponse;
    }

    private function makeParameters(array $args, $grantType = null, $scope = null): Collection
    {
        $grantType ??= config('lighthouse-oauth2.grant_type');
        $scope ??= config('lighthouse-oauth2.scope');

        return collect($args)
            ->except('directive')
            ->put('client_id', config('lighthouse-oauth2.client_id'))
            ->put('client_secret', config('lighthouse-oauth2.client_secret'))
            ->put('grant_type', $grantType)
            ->put('scope', $scope);
    }

    protected function getAuthModelFactory(): AuthModelFactory
    {
        return app(AuthModelFactory::class);
    }

    protected function makeAuthModelInstance(): Model
    {
        return $this->getAuthModelFactory()->make();
    }

    protected function getAuthModelClass(): string
    {
        return $this->getAuthModelFactory()->getClass();
    }
}
