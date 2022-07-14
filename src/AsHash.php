<?php

namespace BBProjectNet\LaravelCasts;

use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;
use Illuminate\Support\Facades\Hash;

class AsHash implements CastsInboundAttributes
{
	/**
	 * @inheritDoc
	 */
	public function set($model, string $key, $value, array $attributes)
	{
		if (! isset($value)) {
			return null;
		}

		return Hash::make($value);
	}
}
