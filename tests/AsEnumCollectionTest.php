<?php

namespace BBProjectNet\LaravelCasts\Tests;

use BBProjectNet\LaravelCasts\AsEnumCollection;
use PHPUnit\Framework\TestCase;
use ValueError;

enum __Enum295: string
{
	case A = 'a';
	case B = 'b';
	case C = 'c';
}

class AsEnumCollectionTest extends TestCase
{
	public function get_provider()
	{
		return [
			'no value' => [null, null],
			'as string' => ['a', collect([__Enum295::A])],
			'as json array' => [json_encode(['a', 'b']), collect([__Enum295::A, __Enum295::B])],
			'as json object' => [json_encode(['foo' => 'a', 'bar' => 'b']), collect(['foo' => __Enum295::A, 'bar' => __Enum295::B])],
		];
	}

	/**
	 * @dataProvider get_provider
	 */
	public function test_get($value, $expected)
	{
		$asEnumCollection = new AsEnumCollection(__Enum295::class);

		$result = $asEnumCollection->get(null, 'data', $value, []);

		$this->assertSame($expected?->all(), $result?->all());
	}

	public function test_get_when_has_unknown_value()
	{
		$asEnumCollection = new AsEnumCollection(__Enum295::class);

		$this->expectException(ValueError::class);

		$asEnumCollection->get(null, 'data', json_encode(['a', 'd', 'c']), []);
	}

	public function set_provider()
	{
		return [
			'no value' => [null, null],
			'empty collection' => [collect(), json_encode([])],
			'as string' => [__Enum295::A, json_encode(['a'])],
			'as json array' => [collect([__Enum295::A, __Enum295::B]), json_encode(['a', 'b'])],
			'as json object' => [collect(['foo' => __Enum295::A, 'bar' => __Enum295::B]), json_encode(['foo' => 'a', 'bar' => 'b'])],
		];
	}

	/**
	 * @dataProvider set_provider
	 */
	public function test_set($value, $expected)
	{
		$asEnumCollection = new AsEnumCollection(__Enum295::class);

		$result = $asEnumCollection->set(null, 'data', $value, []);

		$this->assertSame(['data' => $expected], $result);
	}
}
