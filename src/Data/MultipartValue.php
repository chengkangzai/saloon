<?php

declare(strict_types=1);

namespace Saloon\Data;

use InvalidArgumentException;
use Saloon\Contracts\Arrayable;
use Psr\Http\Message\StreamInterface;

class MultipartValue
{
    /**
     * Constructor
     *
     * @param string $name
     * @param \Psr\Http\Message\StreamInterface|resource|string|int $value
     * @param string|null $filename
     * @param array<string, mixed> $headers
     */
    public function __construct(
        public string  $name,
        public mixed   $value,
        public ?string $filename = null,
        public array   $headers = []
    ) {
        if (! $this->value instanceof StreamInterface && ! is_resource($value) && ! is_string($value) && ! is_numeric($value)) {
            throw new InvalidArgumentException(sprintf('The value property must be either a %s, resource, string or numeric.', StreamInterface::class));
        }
    }
}
