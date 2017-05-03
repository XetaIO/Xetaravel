<?php
namespace Xetaravel\Models\Presenters;

trait UserPresenter
{
    /**
     * Get the account first name.
     *
     * @return string
     */
    public function getFirstNameAttribute(): string
    {
        return $this->parse($this->account->first_name);
    }

    /**
     * Get the account last name.
     *
     * @return string
     */
    public function getLastNameAttribute(): string
    {
        return $this->parse($this->account->last_name);
    }

    /**
     * Get the account full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->parse($this->account->first_name) . ' ' . $this->parse($this->account->last_name);
    }

    /**
     * Get the account facebook.
     *
     * @return string
     */
    public function getFacebookAttribute(): string
    {
        return $this->parse($this->account->facebook);
    }

    /**
     * Get the account twitter.
     *
     * @return string
     */
    public function getTwitterAttribute(): string
    {
        return $this->parse($this->account->twitter);
    }

    /**
     * Get the account biography.
     *
     * @return string
     */
    public function getBiographyAttribute(): string
    {
        return $this->parse($this->account->biography);
    }

    /**
     * Get the account signature.
     *
     * @return string
     */
    public function getSignatureAttribute(): string
    {
        return $this->parse($this->account->signature);
    }

    /**
     * Parse an attribute and return its value or empty if null.
     *
     * @param string|null $attribute The attribute to parse.
     *
     * @return string
     */
    protected function parse($attribute): string
    {
        if ($attribute === null) {
            return '';
        }
        
        return $attribute;
    }
}
