<?php
namespace Xetaravel\Models\Presenters;

trait SettingPresenter
{
    /**
     * Attribute the value regardless to the type.
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

    /**
     * Get the type of the value.
     *
     * @return int|bool|string
     */
    public function getTypeAttribute()
    {
        if (!is_null($this->value_int)) {
            return $this->type = "value_int";
        }

        if (!is_null($this->value_bool)) {
            return $this->type = "value_bool";
        }

        if (!is_null($this->value_str)) {
            return $this->type = "value_str";
        }

        return null;
    }
}
