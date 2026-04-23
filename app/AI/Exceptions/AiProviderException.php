<?php

namespace App\AI\Exceptions;

use RuntimeException;

class AiProviderException extends RuntimeException
{
    /**
     * @param  array<string, mixed>  $context
     */
    public function __construct(
        string $message,
        public readonly ?int $statusCode = null,
        public readonly array $context = [],
    ) {
        parent::__construct($message);
    }
}
