<?php

use BBProjectNet\LaravelCasts\AsInterval;
use Carbon\CarbonInterval;
use PHPUnit\Framework\TestCase;

class AsIntervalTest extends TestCase
{
	public function get_provider()
	{
		return [
			'no value' => [null, null],
			'as int' => [20, 20],
			'as string' => ['40', 40],
		];
	}

	/**
	 * @dataProvider get_provider
	 */
	public function test_get($value, $expected)
	{
		$asInterval = new AsInterval();

		$result = $asInterval->get(null, 'interval', $value, []);

		if ($expected !== null) {
			$this->assertInstanceOf(CarbonInterval::class, $result);
		}
		$this->assertSame($expected, $result?->totalSeconds);
	}

	public function set_provider()
	{
		return [
			'no value' => [null, null],
			'as int' => [20, 20],
			'as string' => ['40', 40],
			'as carbon interval' => [CarbonInterval::minutes(3), 180],
		];
	}

	/**
	 * @dataProvider set_provider
	 */
	public function test_set($value, $expected)
	{
		$asInterval = new AsInterval();

		$result = $asInterval->set(null, 'interval', $value, []);

		if ($expected !== null) {
			$this->assertIsInt($result);
		}
		$this->assertSame($expected, $result);
	}
}
