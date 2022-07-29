<?php

use BBProjectNet\LaravelCasts\AsEnumCollection;
use PHPUnit\Framework\TestCase;

enum TestEnum: string
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
			'as string' => ['a', collect([TestEnum::A])],
			'as json array' => [json_encode(['a', 'b']), collect([TestEnum::A, TestEnum::B])],
			'as json object' => [json_encode(['foo' => 'a', 'bar' => 'b']), collect(['foo' => TestEnum::A, 'bar' => TestEnum::B])],
		];
	}

	/**
	 * @dataProvider get_provider
	 */
	public function test_get($value, $expected)
	{
		$asEnumCollection = new AsEnumCollection(TestEnum::class);

		$result = $asEnumCollection->get(null, 'data', $value, []);

		$this->assertSame($expected?->all(), $result?->all());
	}

	public function test_get_when_has_unknown_value()
	{
		$asEnumCollection = new AsEnumCollection(TestEnum::class);

		$this->expectException(ValueError::class);

		$asEnumCollection->get(null, 'data', json_encode(['a', 'd', 'c']), []);
	}

	public function set_provider()
	{
		return [
			'no value' => [null, null],
			'empty collection' => [collect(), json_encode([])],
			'as string' => [TestEnum::A, json_encode(['a'])],
			'as json array' => [collect([TestEnum::A, TestEnum::B]), json_encode(['a', 'b'])],
			'as json object' => [collect(['foo' => TestEnum::A, 'bar' => TestEnum::B]), json_encode(['foo' => 'a', 'bar' => 'b'])],
		];
	}

	/**
	 * @dataProvider set_provider
	 */
	public function test_set($value, $expected)
	{
		$asEnumCollection = new AsEnumCollection(TestEnum::class);

		$result = $asEnumCollection->set(null, 'data', $value, []);

		$this->assertSame(['data' => $expected], $result);
	}
}
