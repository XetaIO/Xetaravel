<?php
namespace Xetaravel\Markdown\Table;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use Webuni\CommonMark\TableExtension\Table;

class TableRenderer implements BlockRendererInterface
{
    /**
     * Render the table element.
     *
     * @param \League\CommonMark\Block\Element\AbstractBlock $block
     * @param \League\CommonMark\ElementRendererInterface $htmlRenderer
     * @param bool $inTightList
     *
     * @return \League\CommonMark\HtmlElement|string
     */
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, $inTightList = false)
    {
        if (!($block instanceof Table)) {
            throw new \InvalidArgumentException('Incompatible block type: '.get_class($block));
        }

        $attrs = [];
        foreach ($block->getData('attributes', []) as $key => $value) {
            $attrs[$key] = $htmlRenderer->escape($value, true);
        }

        $attrs['class'] = 'table';

        $separator = $htmlRenderer->getOption('inner_separator', "\n");

        return new HtmlElement('table', $attrs, $separator.$htmlRenderer->renderBlocks($block->children()).$separator);
    }
}
