<?php

namespace BBProjectNet\LaravelCasts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class AsStrictArray implements CastsAttributes
{
	/**
	 * @inheritDoc
	 */
	public function get($model, string $key, $value, array $attributes): array
	{
		if ($value === null) {
			return [];
		}

		$value = json_decode($value, true);

		if (! is_array($value)) {
			return [];
		}

		return $value;
	}

	/**
	 * @inheritDoc
	 */
	public function set($model, string $key, $value, array $attributes): array
	{
		if ($value === null) {
			return null;
		}

		if (! is_array($value)) {
			$value = [$value];
		}

		if (count($value) === 0) {
			return null;
		}

		return [$key => json_encode($value)];
	}
}
