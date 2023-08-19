<?php

namespace BBProjectNet\LaravelCasts;

use Carbon\CarbonInterval;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class AsInterval implements CastsAttributes
{
	/**
	 * @inheritDoc
	 */
	public function get($model, string $key, $value, array $attributes): ?CarbonInterval
	{
		if ($value === null) {
			return null;
		}

		return CarbonInterval::seconds($value)->cascade();
	}

	/**
	 * @inheritDoc
	 */
	public function set($model, string $key, $value, array $attributes): ?int
	{
		if ($value === null) {
			return null;
		}

		if ($value instanceof CarbonInterval) {
			return (int)$value->totalSeconds;
		}

		return intval($value);
	}
}
