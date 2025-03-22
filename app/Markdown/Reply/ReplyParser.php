<?php

declare(strict_types=1);

namespace Xetaravel\Markdown\Reply;

use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

use function mb_strlen;

final class ReplyParser implements InlineParserInterface
{
    // Regex used to match Replies
    public const REGEXP_REPLY = '\@(?<user>[\w]{4,20})\#(?<post>[0-9]{1,16})';

    public function getMatchDefinition(): InlineParserMatch
    {
        return InlineParserMatch::regex(self::REGEXP_REPLY);
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $reply = $inlineContext->getFullMatch();
        $route = route('discuss.post.show', ['id' => $inlineContext->getMatches()[3]]);

        // Push the cursor to the lenght of the full match.
        $inlineContext->getCursor()->advanceBy(mb_strlen($reply));

        $inlineContext->getContainer()
            ->appendChild(new Reply(
                $inlineContext->getMatches()[0],
                [
                    'attributes' => [
                        'href' => $route,
                        'class' => 'link link-hover link-primary',
                        'title' => 'View the answer of ' . $inlineContext->getMatches()[2]
                    ]
                ]
            ));

        return true;
    }
}
