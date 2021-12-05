<?php

namespace Mpie\LighthouseOAuth\Exceptions;

use Exception;
use Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions;

class ValidationException extends Exception implements RendersErrorsExtensions
{
    public string $errors;

    public function __construct($errors, string $message = '')
    {
        parent::__construct($message);

        $this->errors = $errors;
    }

    public function isClientSafe(): bool
    {
        return true;
    }

    public function getCategory(): string
    {
        return 'validation';
    }

    public function extensionsContent(): array
    {
        return ['errors' => $this->errors];
    }
}
