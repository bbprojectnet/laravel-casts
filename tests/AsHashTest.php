<?php

namespace BBProjectNet\LaravelCasts\Tests;

use BBProjectNet\LaravelCasts\AsHash;
use PHPUnit\Framework\TestCase;

class AsHashTest extends TestCase
{
	public function set_provider()
	{
		return [
			'no value' => [null, null],
		];
	}

	/**
	 * @dataProvider set_provider
	 */
	public function test_set($value, $expected)
	{
		$asHash = new AsHash();

		$result = $asHash->set(null, 'password', $value, []);

		$this->assertSame($expected, $result);
	}
}
