<?php

namespace BBProjectNet\LaravelCasts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class AsArray implements CastsAttributes
{
	/**
	 * @inheritDoc
	 */
	public function get($model, string $key, $value, array $attributes): array
	{
		if (! isset($value)) {
			return [];
		}

		$data = json_decode($value, true);

		return is_array($data) ? $data : [];
	}

	/**
	 * @inheritDoc
	 */
	public function set($model, string $key, $value, array $attributes): array
	{
		if (! is_array($value)) {
			return null;
		}

		return [
			$key => (bool)$value ? json_encode($value) : null,
		];
	}
}
