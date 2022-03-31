<?php
namespace Xetaravel\Markdown\Emoji;

use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\InlineParserContext;
use League\CommonMark\Parser\Inline\InlineParserMatch;

class EmojiParser implements InlineParserInterface
{
    /**
     * The emoji mappings.
     *
     * @var array
     */
    protected $map;

    /**
     * The emoji extension.
     *
     * @var string
     */
    protected $ext = '.png';

    /**
     * The emoji path directory.
     *
     * @var string
     */
    protected $path;

    /**
     * Create a new emoji parser instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->map = include __DIR__ . "/EmojiSheet.php";
        $this->path = config('app.url') . '/images/emojis/';
    }

    /**
     * Get the characters that must be matched.
     *
     * @return array
     */
    public function getMatchDefinition(): InlineParserMatch
    {
        return InlineParserMatch::string(':');
    }

    /**
     * Parse a line and determine if it contains an emoji. If it does,
     * then we do the necessary.
     *
     * @param \League\CommonMark\InlineParserContext $inlineContext
     *
     * @return bool
     */
    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();

        $previous = $cursor->peek(-1);
        if ($previous !== null && $previous !== ' ') {
            return false;
        }

        $saved = $cursor->saveState();

        $cursor->advance();

        $handle = $cursor->match('/^[a-z0-9\+\-_]+:/');

        if (!$handle) {
            $cursor->restoreState($saved);

            return false;
        }

        $next = $cursor->peek(0);

        if ($next !== null && $next !== ' ') {
            $cursor->restoreState($saved);

            return false;
        }

        $key = substr($handle, 0, -1);

        if (!in_array($key, $this->map)) {
            $cursor->restoreState($saved);

            return false;
        }

        $fileName = $this->path . $key . $this->ext;

        $inline = new Image($fileName, $key);
        $inline->data['attributes'] = [
            'class' => 'emoji',
            'data-emoji' => $key,
            'width' => '24',
            'height' => '24',
            'title' => ':' . $key . ':'
        ];
        $inlineContext->getContainer()->appendChild($inline);

        return true;
    }
}
