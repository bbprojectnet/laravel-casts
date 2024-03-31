<?php

namespace BBProjectNet\LaravelCasts\Tests;

use BBProjectNet\LaravelCasts\AsHash;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AsHashTest extends TestCase
{

	public static function set_provider(): array
	{
		return [
			'no value' => [null, null],
		];
	}

	#[DataProvider('set_provider')]
	public function test_set(mixed $value, ?string $expected): void
	{
		$asHash = new AsHash();

		$result = $asHash->set(null, 'password', $value, []);

		$this->assertSame($expected, $result);
	}
}
