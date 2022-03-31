<?php
namespace Xetaravel\Markdown\Reply;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

final class ReplyExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addInlineParser(new ReplyParser())
            ->addRenderer(Reply::class, new ReplyRenderer());
    }
}
