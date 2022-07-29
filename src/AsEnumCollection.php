<?php

namespace BBProjectNet\LaravelCasts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Collection;

class AsEnumCollection implements CastsAttributes
{
	/**
	 * Create new cast class instance
	 *
	 * @param \Illuminate\Contracts\Database\Eloquent\CastsAttributes $asCollection
	 * @param class-string $enum
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
	public function get($model, string $key, $value, array $attributes): ?Collection
	{
		if ($value === null) {
			return null;
		}

		$data = json_decode($value, true);

		if (! is_array($data)) {
			$data = [$value];
		}

		return (new Collection($data))->map(fn ($item) => $this->enum::from($item));
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
