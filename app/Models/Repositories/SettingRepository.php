<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Str;
use Xetaravel\Models\Setting;

class SettingRepository
{
    /**
     * Create a new setting instance.
     *
     * @param array $data The data used to create the setting.
     *
     * @return \Xetaravel\Models\Setting
     */
    public static function create(array $data): Setting
    {
        return Setting::create([
            'name' => Str::slug($data['name'], '.'),
            'value_int' => $data['type'] ==  'value_int' ? (int) $data['value'] : null,
            'value_str' => $data['type'] ==  'value_str' ? (string) $data['value'] : null,
            'value_bool' => $data['type'] ==  'value_bool' ? (bool) $data['value'] : null,
            'description' => $data['description'],
            'is_deletable' => isset($data['is_deletable']) ? true : false,
        ]);
    }

    /**
     * Update the Setting informations after a valid update request.
     *
     * @param array $data The data used to update the setting.
     * @param \Xetaravel\Models\Setting $setting The setting to update.
     *
     * @return bool
     */
    public static function update(array $data, Setting $setting): bool
    {
        $setting->name = Str::slug($data['name'], '.');
        $setting->value_int = $data['type'] ==  'value_int' ? (int) $data['value'] : null;
        $setting->value_str = $data['type'] ==  'value_str' ? (string) $data['value'] : null;
        $setting->value_bool = $data['type'] ==  'value_bool' ? (bool) $data['value'] : null;
        $setting->description = $data['description'];
        $setting->is_deletable = isset($data['is_deletable']) ? true : false;

        return $setting->save();
    }
}
