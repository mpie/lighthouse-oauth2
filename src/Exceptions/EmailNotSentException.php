<?php

namespace Mpie\LighthouseOAuth\Exceptions;

use Exception;
use Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions;

class EmailNotSentException extends Exception implements RendersErrorsExtensions
{
    private string $reason;

    public function __construct(string $message, string $reason)
    {
        parent::__construct($message);

        $this->reason = $reason;
    }

    public function isClientSafe(): bool
    {
        return true;
    }

    public function getCategory(): string
    {
        return 'notifications';
    }

    public function extensionsContent(): array
    {
        return ['reason' => $this->reason];
    }
}
