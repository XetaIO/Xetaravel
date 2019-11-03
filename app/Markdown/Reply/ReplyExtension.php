<?php
namespace Xetaravel\Markdown\Reply;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;

final class ReplyExtension implements ExtensionInterface
{
    /**
     * Returns a list of block parsers to add to the existing list.
     *
     * @return array
     */
    /*public function getBlockParsers()
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
    /*public function getBlockRenderers()
    {
        return [
            Reply::class => new ReplyRenderer(),
        ];
    }*/

    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment
            ->addBlockParser(new ReplyParser)
            ->addBlockRenderer(Reply::class, new ReplyRenderer);
    }
}
