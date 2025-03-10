<?php
namespace Xetaravel\Models\Presenters;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait SettingPresenter
{
    /**
     * Accessor and mutator of the value.
     *
     * @return Attribute
     */
    public function value(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => unserialize($value),
            set: fn (mixed $value) => serialize($value),
        );
    }
}
