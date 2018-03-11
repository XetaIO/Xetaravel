<?php
namespace Xetaravel\Markdown\Reply;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

class ReplyRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, $inTightList = false)
    {
        return new HtmlElement(
            'a',
            ['class' => 'discuss-conversation-user-reply', 'href' => $block->getRoute()],
            '<i class="fa fa-reply"></i> ' . $block->getUser()
        );
    }
}
