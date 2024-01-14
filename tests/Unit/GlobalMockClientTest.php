<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Faking\GlobalMockClient;
use Saloon\Tests\Fixtures\Requests\UserRequest;
use Saloon\Tests\Fixtures\Connectors\TestConnector;

test('can create a global mock client', function () {
    $mockClient = GlobalMockClient::make([
        MockResponse::make(['name' => 'Sam']),
    ]);

    expect($mockClient)->toBeInstanceOf(GlobalMockClient::class);
    expect(GlobalMockClient::resolve())->toBe($mockClient);

    $connector = new TestConnector;
    $response = $connector->send(new UserRequest);

    expect($response->isMocked())->toBeTrue();
    expect($response->json())->toEqual(['name' => 'Sam']);

    $mockClient->assertSent(UserRequest::class);
});

test('the mock client can be destroyed', function () {
    GlobalMockClient::destroy();

    expect(GlobalMockClient::resolve())->toBeNull();
});

test('a local mock client is given priority over the global mock client', function () {
    GlobalMockClient::make([
        MockResponse::make(['name' => 'Sam']),
    ]);

    $localMockClient = new MockClient([
        MockResponse::make(['name' => 'Taylor']),
    ]);

    $connector = new TestConnector;
    $connector->withMockClient($localMockClient);
    
    $response = $connector->send(new UserRequest);

    expect($response->isMocked())->toBeTrue();
    expect($response->json())->toEqual(['name' => 'Taylor']);

    $localMockClient->assertSentCount(1);
    GlobalMockClient::resolve()->assertNothingSent();
});
