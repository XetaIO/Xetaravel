<?php

namespace Xetaravel\Markdown\GithubCommit;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

final class GithubCommitExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addInlineParser(new GithubCommitParser())
            ->addRenderer(GithubCommit::class, new GithubCommitRenderer());
    }
}
