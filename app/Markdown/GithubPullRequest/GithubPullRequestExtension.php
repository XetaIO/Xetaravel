<?php

namespace Xetaravel\Markdown\GithubPullRequest;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

final class GithubPullRequestExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addInlineParser(new GithubPullRequestParser())
            ->addRenderer(GithubPullRequest::class, new GithubPullRequestRenderer());
    }
}
