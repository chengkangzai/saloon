<?php

declare(strict_types=1);

namespace Saloon\Tests\Fixtures\Requests;

use Saloon\Http\Request;

class UserRequest extends Request
{
    /**
     * Define the HTTP method.
     *
     * @var string
     */
    protected string $method = 'GET';

    /**
     * Define the endpoint for the request.
     *
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/user';
    }

    /**
     * @param int|null $userId
     * @param int|null $groupId
     */
    public function __construct(public ?int $userId = null, public ?int $groupId = null)
    {
        //
    }
}
