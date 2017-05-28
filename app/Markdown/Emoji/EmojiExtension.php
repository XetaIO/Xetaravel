<?php
namespace Xetaravel\Markdown\Emoji;

use League\CommonMark\Extension\Extension;

class EmojiExtension extends Extension
{
    /**
     * The emoji parser.
     *
     * @var \Xetaravel\Markdown\Emoji\EmojiParser
     */
    protected $parser;

    /**
     * Create a new emoji parser instance.
     *
     * @param \Xetaravel\Markdown\Emoji\EmojiParser $parser
     */
    public function __construct(EmojiParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Returns a list of inline parsers to add to the existing list.
     *
     * @return \League\CommonMark\Inline\Parser\InlineParserInterface
     */
    public function getInlineParsers()
    {
        return [$this->parser];
    }
}
