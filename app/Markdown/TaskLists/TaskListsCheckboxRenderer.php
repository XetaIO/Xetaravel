<?php
namespace Xetaravel\Markdown\TaskLists;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use League\CommonMark\Util\Xml;
use Xetaravel\Markdown\TaskLists\TaskListsCheckbox;

class TaskListsCheckboxRenderer implements InlineRendererInterface
{
    /**
     *  Render the checkbox element.
     *
     * @param \League\CommonMark\Inline\Element\AbstractInline $inline
     * @param \League\CommonMark\ElementRendererInterface $htmlRenderer
     *
     * @throws \InvalidArgumentException
     *
     * @return \League\CommonMark\HtmlElement
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof TaskListsCheckbox)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        $attrs = [];
        foreach ($inline->getData('attributes', []) as $key => $value) {
            $attrs[$key] = Xml::escape($value, true);
        }

        $attrs['type'] = 'checkbox';
        $attrs['disabled'] = '';
        $attrs['class'] = 'custom-control-input';

        if ($inline->isChecked()) {
            $attrs['checked'] = 'checked';
        }
        $text = $inline->getData('text', '');

        if (!empty($text)) {
            $text = Xml::escape($text, true);
        }

        return new HtmlElement(
            'label',
            ['class' => 'custom-control custom-checkbox custom-checkbox-disabled'],
            [
                new HtmlElement('input', $attrs),
                new HtmlElement('span', ['class' => 'custom-control-indicator']),
                new HtmlElement('span', ['class' => 'custom-control-description'], $text)
            ]
        );
    }
}
