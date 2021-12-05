<?php

namespace Mpie\LighthouseOAuth\GraphQL\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Mpie\LighthouseOAuth\Exceptions\AuthenticationException;

class AuthResolver
{
    public function request(array $args, string $scope = null): array
    {
        $parameters = $this->buildParameters($args, $scope);

        $request = app('request')->create(
            uri: config('lighthouse-oauth2.domain').'/oauth/token',
            method: 'POST',
            parameters: $parameters->toArray(),
            server: ['HTTP_ACCEPT' => 'application/json']
        );

        $response = app('router')->prepareResponse($request, app()->handle($request));
        $decodedResponse = json_decode($response->getContent(), true);

        if ($response->getStatusCode() != 200) {
            throw new AuthenticationException($decodedResponse['hint'] ?? '', $decodedResponse['message']);
        }

        return $decodedResponse;
    }

    private function buildParameters(array $args, $scope = null): Collection
    {
        $scope ??= config('lighthouse-oauth2.scope');
        $authCode = $args['code'] ?? null;

        $parameters = collect($args)
            ->except('directive')
            ->put('client_id', config('lighthouse-oauth2.client_id'))
            ->put('client_secret', config('lighthouse-oauth2.client_secret'))
            ->put('grant_type', $authCode ? 'authorization_code' : config('lighthouse-oauth2.grant_type'))
            ->put('scope', $scope)
            ->put('code', $authCode)
            ->filter();

        $parameters->when(isset($args['refresh_token']), function ($collection) {
            return $collection->put('grant_type', 'refresh_token');
        });

        return $parameters;
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
