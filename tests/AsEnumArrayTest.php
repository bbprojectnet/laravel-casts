<?php

namespace BBProjectNet\LaravelCasts\Tests;

use BBProjectNet\LaravelCasts\AsEnumArray;
use PHPUnit\Framework\TestCase;
use ValueError;

enum __Enum431: string
{
	case A = 'a';
	case B = 'b';
	case C = 'c';
}

class AsEnumArrayTest extends TestCase
{
	public function get_provider()
	{
		return [
			'no value' => [null, null],
			'as string' => ['a', [__Enum431::A]],
			'as json array' => [json_encode(['a', 'b']), [__Enum431::A, __Enum431::B]],
			'as json object' => [json_encode(['foo' => 'a', 'bar' => 'b']), ['foo' => __Enum431::A, 'bar' => __Enum431::B]],
		];
	}

	/**
	 * @dataProvider get_provider
	 */
	public function test_get($value, $expected)
	{
		$asEnumArray = new AsEnumArray(__Enum431::class);

		$result = $asEnumArray->get(null, 'data', $value, []);

		$this->assertSame($expected, $result);
	}

	public function test_get_when_has_unknown_value()
	{
		$asEnumArray = new AsEnumArray(__Enum431::class);

		$this->expectException(ValueError::class);

		$asEnumArray->get(null, 'data', json_encode(['a', 'd', 'c']), []);
	}

	public function set_provider()
	{
		return [
			'no value' => [null, null],
			'empty collection' => [[], json_encode([])],
			'as string' => [__Enum431::A, json_encode(['a'])],
			'as json array' => [[__Enum431::A, __Enum431::B], json_encode(['a', 'b'])],
			'as json object' => [['foo' => __Enum431::A, 'bar' => __Enum431::B], json_encode(['foo' => 'a', 'bar' => 'b'])],
		];
	}

	/**
	 * @dataProvider set_provider
	 */
	public function test_set($value, $expected)
	{
		$asEnumArray = new AsEnumArray(__Enum431::class);

		$result = $asEnumArray->set(null, 'data', $value, []);

		$this->assertSame(['data' => $expected], $result);
	}
}
