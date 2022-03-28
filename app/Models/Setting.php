<?php
namespace Xetaravel\Models;

use Xetaravel\Models\Presenters\SettingPresenter;

class Setting extends Model
{
    use SettingPresenter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'value_int',
        'value_str',
        'value_bool',
        'value',
        'description',
        'last_updated_user_id',
        'is_deletable'
    ];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'value',
        'type'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Get the type of the value before to save.
        static::updating(function ($model) {
            $model = self::castValue($model->value, $model);

            unset($model->value);
        });
    }

    private static function castValue($value, $model)
    {
        switch (gettype($value)) {
            case 'int':
            case 'integer':
                $model->value_int = $value;
                $model->value_str = null;
                $model->value_bool = null;

                return $model;
                break;

            case 'bool':
            case 'boolean':
                $model->value_int = null;
                $model->value_str = null;
                $model->value_bool = $value;

                return $model;
                break;

            default:
                $model->value_int = null;
                $model->value_str = $value;
                $model->value_bool = null;

                return $model;
        }
    }
}
