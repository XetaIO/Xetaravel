<?php
namespace Xetaravel\Markdown\Reply;

use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Util\Xml;
use League\CommonMark\Xml\XmlNodeRendererInterface;

final class ReplyRenderer implements NodeRendererInterface, XmlNodeRendererInterface
{
    /**
     * @param Reply $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        Reply::assertInstanceOf($node);

        $attrs = $node->data->get('attributes');

        return new HtmlElement('a', $attrs, '<i class="fa fa-reply"></i> ' . Xml::escape($node->getLiteral()) . '<br>');
    }

    public function getXmlTagName(Node $node): string
    {
        return 'a';
    }

    /**
     * {@inheritDoc}
     */
    public function getXmlAttributes(Node $node): array
    {
        return [];
    }
}
