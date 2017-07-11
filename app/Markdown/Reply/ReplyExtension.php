<?php
namespace Xetaravel\Markdown\Reply;

use League\CommonMark\Extension\Extension;

class ReplyExtension extends Extension
{
    /**
     * Returns a list of block parsers to add to the existing list.
     *
     * @return array
     */
    public function getBlockParsers()
    {
        return [
            new ReplyParser(),
        ];
    }

    /**
     * Returns a list of block renderers to add to the existing list.
     *
     * @return array
     */
    public function getBlockRenderers()
    {
        return [
            Reply::class => new ReplyRenderer(),
        ];
    }
}
