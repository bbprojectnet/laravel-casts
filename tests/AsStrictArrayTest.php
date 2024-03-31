<?php

namespace BBProjectNet\LaravelCasts\Tests;

use BBProjectNet\LaravelCasts\AsStrictArray;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AsStrictArrayTest extends TestCase
{
	public static function get_provider(): array
	{
		return [
			'no value' => [null, []],
			'as string' => ['foo', ['foo']],
			'as int' => [40, [40]],
			'as json' => [json_encode(['foo' => 5]), ['foo' => 5]],
		];
	}

	#[DataProvider('get_provider')]
	public function test_get(mixed $value, array $expected): void
	{
		$asStrictArray = new AsStrictArray();

		$result = $asStrictArray->get(null, 'data', $value, []);

		$this->assertSame($expected, $result);
	}

	public static function set_provider(): array
	{
		return [
			'no value' => [null, null],
			'empty array' => [[], null],
			'as string' => ['foo', json_encode(['foo'])],
			'as int' => [40, json_encode([40])],
			'as array' => [['foo' => 5], json_encode(['foo' => 5])],
		];
	}

	#[DataProvider('set_provider')]
	public function test_set(mixed $value, ?string $expected): void
	{
		$asStrictArray = new AsStrictArray();

		$result = $asStrictArray->set(null, 'data', $value, []);

		$this->assertSame(['data' => $expected], $result);
	}
}
