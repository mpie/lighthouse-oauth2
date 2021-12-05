<?php

namespace Mpie\LighthouseOAuth\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;
use Mpie\LighthouseOAuth\Exceptions\EmailNotSentException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ForgotPassword
{
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo): array
    {
        $response = $this->broker()->sendResetLink(['email' => $args['email']], function () {});

        if ($response !== Password::RESET_LINK_SENT) {
            throw new EmailNotSentException('Email not sent', __($response));
        }

        return ['message' => 'Please implement your own ForgotPassword resolver. The user was found though!'];
    }

    private function broker(): PasswordBroker
    {
        return Password::broker($this->provider());
    }

    private function provider(): string
    {
        return config('auth.guards.'.config('lighthouse-oauth2.guard').'.provider');
    }
}
