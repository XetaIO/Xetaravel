<?php
namespace Xetaravel\Markdown\Table;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Ext\Table\Table;

final class TableRenderer implements BlockRendererInterface
{
    /**
     * Render the table element.
     *
     * @param \League\CommonMark\Block\Element\AbstractBlock $block
     * @param \League\CommonMark\ElementRendererInterface $htmlRenderer
     * @param bool $inTightList
     *
     * @throws \InvalidArgumentException
     *
     * @return \League\CommonMark\HtmlElement
     */
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!($block instanceof Table)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }
        $attrs = [];

        foreach ($block->getData('attributes', []) as $key => $value) {
            $attrs[$key] = $htmlRenderer->escape($value, true);
        }

        $attrs['class'] = 'table';
        $separator = $htmlRenderer->getOption('inner_separator', "\n");

        return new HtmlElement(
            'table',
            $attrs,
            $separator . $htmlRenderer->renderBlocks($block->children()) . $separator
        );
    }
}
