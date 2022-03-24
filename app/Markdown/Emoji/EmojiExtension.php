<?php
namespace Xetaravel\Markdown\Emoji;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;

final class EmojiExtension implements ExtensionInterface
{

    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addInlineParser(new EmojiParser);
    }
}
