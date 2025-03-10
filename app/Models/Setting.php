<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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
        'site_id',
        'key',
        'value',
        'model_type',
        'model_id',
        'text',
        'label',
        'label_info',
        'last_updated_user_id'
    ];

    /**
     * Generate the generals request for the settings.
     *
     * @param Builder $query
     *
     * @return void
     */
    public function scopeGenerals(Builder $query): void
    {
        $query->whereNull('site_id')
            ->whereNull('model_type')
            ->whereNull('model_id');
    }

    /**
     * Generate the sites request for the settings.
     *
     * @param Builder $query
     *
     * @return void
     */
    public function scopeSites(Builder $query): void
    {
        $query->where('site_id', session('current_site_id'))
            ->whereNull('model_type')
            ->whereNull('model_id');
    }
}
