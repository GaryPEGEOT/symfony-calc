<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

/**
 * @group e2e
 */
class HomepageTest extends PantherTestCase
{
    /**
     * @dataProvider provideOperations
     */
    public function testHomepageLoadsReactApp(float | string $expected, string $operation): void
    {
        $client = static::createPantherClient();

        $client->request('GET', '/');
        $this->assertSelectorTextContains('h1', 'My awesome calculator');

        $client->submitForm('Calculate', compact('operation'));

        $client->waitFor('#operation-result');
        $this->assertSelectorTextContains('#operation-result', "The result is $expected");
    }

    public function testBadInput(): void
    {
        $client = static::createPantherClient();

        $client->request('GET', '/');
        $this->assertSelectorTextContains('h1', 'My awesome calculator');

        $client->submitForm('Calculate', ['operation' => 'COucou !']);

        $this->assertSelectorTextContains('.invalid-feedback', 'Invalid format');
    }

    public function provideOperations(): \Generator
    {
        yield 'Simple addition' => [2, '1 + 1'];
        yield 'Multiplication & addition' => [120, '100 * (1 + 0.2)'];
        yield 'Division' => [0.25, '1 / 4'];
        yield 'Subtraction' => [42, '43 - 1'];
    }
}
