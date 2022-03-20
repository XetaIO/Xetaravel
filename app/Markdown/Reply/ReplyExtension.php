<?php
namespace Xetaravel\Markdown\Reply;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;

final class ReplyExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment
            ->addBlockParser(new ReplyParser)
            ->addBlockRenderer(Reply::class, new ReplyRenderer);
    }
}
