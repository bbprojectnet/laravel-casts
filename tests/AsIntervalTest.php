<?php

namespace BBProjectNet\LaravelCasts\Tests;

use BBProjectNet\LaravelCasts\AsInterval;
use Carbon\CarbonInterval;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AsIntervalTest extends TestCase
{
	public static function get_provider(): array
	{
		return [
			'no value' => [null, null],
			'as int' => [20, 20],
			'as string' => ['40', 40],
		];
	}

	#[DataProvider('get_provider')]
	public function test_get(mixed $value, ?int $expected): void
	{
		$asInterval = new AsInterval();

		$result = $asInterval->get(null, 'interval', $value, []);

		if ($expected !== null) {
			$this->assertInstanceOf(CarbonInterval::class, $result);
		}
		$this->assertEquals($expected, $result?->totalSeconds);
	}

	public static function set_provider(): array
	{
		return [
			'no value' => [null, null],
			'as int' => [20, 20],
			'as string' => ['40', 40],
			'as carbon interval' => [CarbonInterval::minutes(3), 180],
		];
	}

	#[DataProvider('set_provider')]
	public function test_set(mixed $value, ?int $expected): void
	{
		$asInterval = new AsInterval();

		$result = $asInterval->set(null, 'interval', $value, []);

		if ($expected !== null) {
			$this->assertIsInt($result);
		}
		$this->assertSame($expected, $result);
	}
}
