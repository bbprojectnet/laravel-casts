<?php

namespace BBProjectNet\LaravelCasts\Tests;

use BBProjectNet\LaravelCasts\AsTimeZone;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

class AsTimeZoneTest extends TestCase
{
	public function get_provider()
	{
		return [
			'no value' => [null, null],
			'as string' => ['Europe/Warsaw', new DateTimeZone('Europe/Warsaw')],
		];
	}

	/**
	 * @dataProvider get_provider
	 */
	public function test_get($value, $expected)
	{
		$asTimeZone = new AsTimeZone();

		$result = $asTimeZone->get(null, 'timezone', $value, []);

		$this->assertSame($expected?->getName(), $result?->getName());
	}

	public function set_provider()
	{
		return [
			'no value' => [null, null],
			'as string' => ['Europe/Warsaw', 'Europe/Warsaw'],
			'as object' => [new DateTimeZone('Europe/Warsaw'), 'Europe/Warsaw'],
		];
	}

	/**
	 * @dataProvider set_provider
	 */
	public function test_set($value, $expected)
	{
		$asTimeZone = new AsTimeZone();

		$result = $asTimeZone->set(null, 'timezone', $value, []);

		$this->assertSame($expected, $result);
	}
}
