<?php
namespace Xetaravel\Models\Presenters;

use Xetaravel\Models\Setting;

trait SettingPresenter
{
    /**
     * Get the actual status of the server.
     *
     * @return int|bool|string
     */
    public function getValueAttribute()
    {
        if (!is_null($this->value_int)) {
            return intval($this->value_int);
        }

        if (!is_null($this->value_bool)) {
            return boolval($this->value_bool);
        }

        if (!is_null($this->value_str)) {
            return $this->value_str;
        }

        return null;
    }
}
