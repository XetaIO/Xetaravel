<?php
namespace Xetaravel\Models\Presenters;

trait DiscussThreadPresenter
{
    /**
     * Get the thread url.
     *
     * @return string
     */
    public function getThreadUrlAttribute(): string
    {
        if (!isset($this->slug)) {
            return '';
        }

        return route('discuss.thread.show', ['slug' => $this->slug, 'id' => $this->getKey()]);
    }
}
