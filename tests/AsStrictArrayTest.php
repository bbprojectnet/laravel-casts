<?php

namespace BBProjectNet\LaravelCasts\Tests;

use BBProjectNet\LaravelCasts\AsStrictArray;
use PHPUnit\Framework\TestCase;

class AsStrictArrayTest extends TestCase
{
	public function get_provider()
	{
		return [
			'no value' => [null, []],
			'as string' => ['foo', ['foo']],
			'as int' => [40, [40]],
			'as json' => [json_encode(['foo' => 5]), ['foo' => 5]],
		];
	}

	/**
	 * @dataProvider get_provider
	 */
	public function test_get($value, $expected)
	{
		$asStrictArray = new AsStrictArray();

		$result = $asStrictArray->get(null, 'data', $value, []);

		$this->assertSame($expected, $result);
	}

	public function set_provider()
	{
		return [
			'no value' => [null, null],
			'empty array' => [[], null],
			'as string' => ['foo', json_encode(['foo'])],
			'as int' => [40, json_encode([40])],
			'as array' => [['foo' => 5], json_encode(['foo' => 5])],
		];
	}

	/**
	 * @dataProvider set_provider
	 */
	public function test_set($value, $expected)
	{
		$asStrictArray = new AsStrictArray();

		$result = $asStrictArray->set(null, 'data', $value, []);

		$this->assertSame(['data' => $expected], $result);
	}
}
