<?php

namespace BBProjectNet\LaravelCasts\Tests;

use BBProjectNet\LaravelCasts\AsTimeZone;
use DateTimeZone;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AsTimeZoneTest extends TestCase
{
	public static function get_provider(): array
	{
		return [
			'no value' => [null, null],
			'as string' => ['Europe/Warsaw', new DateTimeZone('Europe/Warsaw')],
		];
	}

	#[DataProvider('get_provider')]
	public function test_get(mixed $value, ?DateTimeZone $expected)
	{
		$asTimeZone = new AsTimeZone();

		$result = $asTimeZone->get(null, 'timezone', $value, []);

		$this->assertSame($expected?->getName(), $result?->getName());
	}

	public static function set_provider(): array
	{
		return [
			'no value' => [null, null],
			'as string' => ['Europe/Warsaw', 'Europe/Warsaw'],
			'as object' => [new DateTimeZone('Europe/Warsaw'), 'Europe/Warsaw'],
		];
	}

	#[DataProvider('set_provider')]
	public function test_set(mixed $value, ?string $expected): void
	{
		$asTimeZone = new AsTimeZone();

		$result = $asTimeZone->set(null, 'timezone', $value, []);

		$this->assertSame($expected, $result);
	}
}
