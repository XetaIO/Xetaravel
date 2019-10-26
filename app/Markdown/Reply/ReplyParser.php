<?php
namespace Xetaravel\Markdown\Reply;

use League\CommonMark\Block\Parser\BlockParserInterface;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;
use League\CommonMark\Util\RegexHelper;

class ReplyParser implements BlockParserInterface
{

    const REGEXP_REPLY = '/\@(?<user>[\w]{4,20})\#(?<post>[0-9]{1,16})/';

    /**
     * Parse a line and determine if it contains an emoji. If it does,
     * then we do the necessary.
     *
     * @param \League\CommonMark\ContextInterface $context
     * @param \League\CommonMark\Cursor $cursor
     *
     * @return bool
     */
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        $matches = RegexHelper::matchAll(self::REGEXP_REPLY, $cursor->getLine());

        if (null === $matches) {
            return false;
        }
        $route = route('discuss.post.show', ['id' => $matches['post']]);

        $reply = new Reply($route, $matches['user']);

        $cursor->advanceBy(strlen($matches[0]));
        $context->addBlock($reply);

        return true;
    }
}
