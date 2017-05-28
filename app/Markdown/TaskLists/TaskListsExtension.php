<?php
namespace Xetaravel\Markdown\TaskLists;

use League\CommonMark\Extension\Extension;
use Xetaravel\Markdown\TaskLists\TaskListsCheckbox;
use Xetaravel\Markdown\TaskLists\TaskListsCheckboxRenderer;
use Xetaravel\Markdown\TaskLists\TaskListsParser;

class TaskListsExtension extends Extension
{
    /**
     * The emoji parser.
     *
     * @var \Xetaravel\Markdown\TaskLists\TaskListsParser
     */
    protected $parser;

    /**
     * The emoji parser.
     *
     * @var \Xetaravel\Markdown\TaskLists\TaskListsCheckboxRenderer
     */
    protected $renderer;

    /**
     * Create a new emoji parser instance.
     *
     * @param \Xetaravel\Markdown\TaskLists\TaskListsParser $parser
     * @param \Xetaravel\Markdown\TaskLists\TaskListsCheckboxRenderer $renderer
     */
    public function __construct(TaskListsParser $parser, TaskListsCheckboxRenderer $renderer)
    {
        $this->parser = $parser;
        $this->renderer = $renderer;
    }

    /**
     * Returns a list of inline parsers to add to the existing list.
     *
     * @return array
     */
    public function getInlineParsers()
    {
        return [$this->parser];
    }

    /**
     * Returns a list of inline renderers to add to the existing list.
     *
     * @return array
     */
    public function getInlineRenderers()
    {
        return [
            TaskListsCheckbox::class => $this->renderer
        ];
    }
}
