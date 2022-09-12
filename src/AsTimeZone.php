<?php

namespace BBProjectNet\LaravelCasts;

use DateTimeZone;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class AsTimeZone implements CastsAttributes
{
	/**
	 * @inheritDoc
	 */
	public function get($model, string $key, $value, array $attributes): ?DateTimeZone
	{
		if ($value === null) {
			return null;
		}

		return new DateTimeZone($value);
	}

	/**
	 * @inheritDoc
	 */
	public function set($model, string $key, $value, array $attributes): ?string
	{
		if ($value === null) {
			return null;
		}

		if (! $value instanceof DateTimeZone) {
			$value = new DateTimeZone($value);
		}

		/** @var \DateTimeZone $value */
		return $value->getName();
	}
}
