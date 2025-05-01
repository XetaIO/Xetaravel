<?php

declare(strict_types=1);

namespace Xetaravel\Models\Repositories;

use Xetaravel\Models\Setting;
use Xetaravel\Settings\Settings;

class SettingRepository
{
    /**
     * Update settings.
     *
     * @param Settings $settingClass
     * @param array $settings The settings to update.
     *
     * @return bool
     */
    public static function update(Settings $settingClass, array $settings): bool
    {
        if (empty($settings)) {
            return true;
        }

        foreach ($settings as $key => $value) {
            $setting = Setting::where('key', $key)
                ->whereNull('model_type')
                ->whereNull('model_id')
                ->first();

            if (is_null($setting)) {
                continue;
            }

            // Cast the value the same as the old value to not change the type
            if (is_bool($setting->value)) {
                $value = (bool)$value;
            } elseif (is_int($setting->value)) {
                $value = (int)$value;
            } elseif (is_float($setting->value)) {
                $value = (float)$value;
            } else {
                $value = (string)$value;
            }

            // Assign the new value dans save it.
            $setting->value = $value;
            $saved = $setting->save();

            // If the save fails, return directly.
            if ($saved === false) {
                return false;
            }

            // Delete the cache related to the setting
            $settingClass->withoutContext()->remove($key);
        }

        return true;
    }
}
