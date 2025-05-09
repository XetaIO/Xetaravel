<?php

declare(strict_types=1);

namespace Xetaravel\Markdown\GithubCommit;

use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

use function mb_strlen;

final class GithubCommitParser implements InlineParserInterface
{
    // Regex used to match Github commit link.
    public const REGEXP_COMMIT = '\bhttps?:\/\/github\.com\/(?<repo>[\w-]+\/[\w-]+)\/commit\/(?<commit>[0-9a-f]{7,40})';

    public function getMatchDefinition(): InlineParserMatch
    {
        return InlineParserMatch::regex(self::REGEXP_COMMIT);
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $route = $inlineContext->getFullMatch();

        // Push the cursor to the lenght of the full match.
        $inlineContext->getCursor()->advanceBy(mb_strlen($route));

        $commit = mb_substr($inlineContext->getMatches()[3], 0, 7);

        $content = "{$inlineContext->getMatches()[1]}@{$commit}";


        $inlineContext->getContainer()
            ->appendChild(new GithubCommit(
                $content,
                [
                    'attributes' => [
                        'href' => $route,
                        'target' => '_blank',
                        'class' => 'link link-hover link-primary',
                        'title' => $content
                    ]
                ]
            ));

        return true;
    }
}
