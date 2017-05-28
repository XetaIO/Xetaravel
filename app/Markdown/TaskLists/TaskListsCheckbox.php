<?php
namespace Xetaravel\Markdown\TaskLists;

use League\CommonMark\Inline\Element\AbstractInline;

class TaskListsCheckbox extends AbstractInline
{
    const CHECKED     = true;
    const NOT_CHECKED = false;

    /**
     * Used for storage of arbitrary data
     *
     * @var array
     */
    public $data = [];

    /**
     * The checkbox status
     *
     * @var bool
     */
    protected $checked;

    /**
     * @param bool|false $checked
     * @param $attributes
     */
    public function __construct($checked = self::NOT_CHECKED, array $attributes = [])
    {
        $this->checked = $checked;
        $this->data = $attributes;
    }

    /**
     * Check if the checkbox is checked.
     *
     * @return bool
     */
    public function isChecked()
    {
        return $this->checked;
    }
}
