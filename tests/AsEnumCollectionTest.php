<?php

namespace BBProjectNet\LaravelCasts\Tests;

use BBProjectNet\LaravelCasts\AsEnumCollection;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\DataProvider;
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
	public static function get_provider(): array
	{
		return [
			'no value' => [null, null],
			'as string' => ['a', collect([__Enum295::A])],
			'as json array' => [json_encode(['a', 'b']), collect([__Enum295::A, __Enum295::B])],
			'as json object' => [json_encode(['foo' => 'a', 'bar' => 'b']), collect(['foo' => __Enum295::A, 'bar' => __Enum295::B])],
		];
	}

	#[DataProvider('get_provider')]
	public function test_get(mixed $value, ?Collection $expected): void
	{
		$asEnumCollection = new AsEnumCollection(__Enum295::class);

		$result = $asEnumCollection->get(null, 'data', $value, []);

		$this->assertSame($expected?->all(), $result?->all());
	}

	public function test_get_when_has_unknown_value(): void
	{
		$asEnumCollection = new AsEnumCollection(__Enum295::class);

		$this->expectException(ValueError::class);

		$asEnumCollection->get(null, 'data', json_encode(['a', 'd', 'c']), []);
	}

	public static function set_provider(): array
	{
		return [
			'no value' => [null, null],
			'empty collection' => [collect(), json_encode([])],
			'as string' => [__Enum295::A, json_encode(['a'])],
			'as json array' => [collect([__Enum295::A, __Enum295::B]), json_encode(['a', 'b'])],
			'as json object' => [collect(['foo' => __Enum295::A, 'bar' => __Enum295::B]), json_encode(['foo' => 'a', 'bar' => 'b'])],
		];
	}

	#[DataProvider('set_provider')]
	public function test_set(mixed $value, ?string $expected): void
	{
		$asEnumCollection = new AsEnumCollection(__Enum295::class);

		$result = $asEnumCollection->set(null, 'data', $value, []);

		$this->assertSame(['data' => $expected], $result);
	}
}
