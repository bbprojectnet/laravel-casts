<?php

namespace BBProjectNet\LaravelCasts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Collection;

class AsEnumArray implements CastsAttributes
{
	/**
	 * Create new cast class instance
	 *
	 * @param \Illuminate\Contracts\Database\Eloquent\CastsAttributes $asCollection
	 * @param class-string<\BackedEnum> $enum
	 * @return void
	 */
	public function __construct(
		private string $enum,
	)
	{
	}

	/**
	 * @inheritDoc
	 */
	public function get($model, string $key, $value, array $attributes): ?array
	{
		if ($value === null) {
			return null;
		}

		$data = json_decode($value, true);

		if (! is_array($data)) {
			$data = [$value];
		}

		return array_map(fn ($item) => $this->enum::from($item), $data);
	}

	/**
	 * @inheritDoc
	 */
	public function set($model, string $key, $value, array $attributes): ?array
	{
		if ($value === null) {
			return [$key => null];
		}

		if (! is_iterable($value)) {
			$value = [$value];
		}

		return [$key => json_encode($value)];
	}
}
