<?php
namespace Xetaravel\Markdown\GithubPullRequest;

use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

final class GithubPullRequestParser implements InlineParserInterface
{
    // Regex used to match Github pull request link.
    const REGEXP_PURLLREQUEST = '\bhttps?:\/\/github\.com\/(?<repo>[\w-]+\/[\w-]+)\/'.
        '(?<type>issues|pull)\/(?<issue>\d+)';

    public function getMatchDefinition(): InlineParserMatch
    {
        return InlineParserMatch::regex(self::REGEXP_PURLLREQUEST);
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $route = $inlineContext->getFullMatch();

        // Push the cursor to the lenght of the full match.
        $inlineContext->getCursor()->advanceBy(\strlen($route));

        $content = "{$inlineContext->getMatches()[1]}#{$inlineContext->getMatches()[5]}";


        $inlineContext->getContainer()
            ->appendChild(new GithubPullRequest(
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
