<?php
namespace Xetaravel\Markdown\Emoji;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;

final class EmojiExtension implements ExtensionInterface
{
    /**
     * The emoji parser.
     *
     * @var \Xetaravel\Markdown\Emoji\EmojiParser
     */
    //protected $parser;

    /**
     * Create a new emoji parser instance.
     *
     * @param \Xetaravel\Markdown\Emoji\EmojiParser $parser
     */
    /*public function __construct(EmojiParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Returns a list of inline parsers to add to the existing list.
     *
     * @return array
     */
   /*public function getInlineParsers()
    {
        return [$this->parser];
    }*/

    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addInlineParser(new EmojiParser);
    }
}
