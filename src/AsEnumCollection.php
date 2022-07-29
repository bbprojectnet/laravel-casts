<?php

namespace BBProjectNet\LaravelCasts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Support\Collection;

class AsEnumCollection implements CastsAttributes
{
	/**
	 * As collection castable
	 *
	 * @var \Illuminate\Contracts\Database\Eloquent\CastsAttributes
	 */
	private CastsAttributes $asCollection;

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
		$this->asCollection = AsCollection::castUsing([$enum]);
	}

	/**
	 * @inheritDoc
	 */
	public function get($model, string $key, $value, array $attributes): ?Collection
	{
		$value = $this->asCollection->get($model, $key, $value, $attributes);

		if ($value === null) {
			return null;
		}

		return $value
			->map(fn ($item) => $this->enum::from($item))
			->filter()
			->values();
	}

	/**
	 * @inheritDoc
	 */
	public function set($model, string $key, $value, array $attributes): ?array
	{
		return $this->asCollection->set($model, $key, $value, $attributes);
	}
}
