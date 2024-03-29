<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Markdown.
 *
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Enable View Integration
    |--------------------------------------------------------------------------
    |
    | This option specifies if the view integration is enabled so you can write
    | markdown views and have them rendered as html. The following extensions
    | are currently supported: ".md", ".md.php", and ".md.blade.php". You may
    | disable this integration if it is conflicting with another package.
    |
    | Default: true
    |
    */

    'views' => false,

    /*
    |--------------------------------------------------------------------------
    | CommonMark Extensions
    |--------------------------------------------------------------------------
    |
    | This option specifies what extensions will be automatically enabled.
    | Simply provide your extension class names here.
    |
    | Default: [
    |              League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension::class,
    |              League\CommonMark\Extension\Table\TableExtension::class,
    |          ]
    |
    */

    'extensions' => [
        League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension::class,
        League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension::class,
        League\CommonMark\Extension\GithubFlavoredMarkdownExtension::class,
        Xetaravel\Markdown\Emoji\EmojiExtension::class,
        Xetaravel\Markdown\GithubCommit\GithubCommitExtension::class,
        Xetaravel\Markdown\GithubPullRequest\GithubPullRequestExtension::class,
        Xetaravel\Markdown\Reply\ReplyExtension::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Renderer Configuration
    |--------------------------------------------------------------------------
    |
    | This option specifies an array of options for rendering HTML.
    |
    | Default: [
    |              'block_separator' => "\n",
    |              'inner_separator' => "\n",
    |              'soft_break'      => "\n",
    |          ]
    |
    */

    'renderer' => [
        'block_separator' => "\n",
        'inner_separator' => "\n",
        'soft_break'      => "\n",
    ],

    /*
    |--------------------------------------------------------------------------
    | Commonmark Configuration
    |--------------------------------------------------------------------------
    |
    | This option specifies an array of options for commonmark.
    |
    | Default: [
    |              'enable_em' => true,
    |              'enable_strong' => true,
    |              'use_asterisk' => true,
    |              'use_underscore' => true,
    |              'unordered_list_markers' => ['-', '+', '*'],
    |          ]
    |
    */

    'commonmark' => [
        'enable_em'              => true,
        'enable_strong'          => true,
        'use_asterisk'           => true,
        'use_underscore'         => true,
        'unordered_list_markers' => ['-', '+', '*'],
    ],

    /*
    |--------------------------------------------------------------------------
    | HTML Input
    |--------------------------------------------------------------------------
    |
    | This option specifies how to handle untrusted HTML input.
    |
    | Default: 'strip'
    |
    */

    'html_input' => 'strip',

    /*
    |--------------------------------------------------------------------------
    | Allow Unsafe Links
    |--------------------------------------------------------------------------
    |
    | This option specifies whether to allow risky image URLs and links.
    |
    | Default: true
    |
    */

    'allow_unsafe_links' => true,

    /*
    |--------------------------------------------------------------------------
    | Maximum Nesting Level
    |--------------------------------------------------------------------------
    |
    | This option specifies the maximum permitted block nesting level.
    |
    | Default: PHP_INT_MAX
    |
    */

    'max_nesting_level' => PHP_INT_MAX,

    /*
    |--------------------------------------------------------------------------
    | Slug Normalizer
    |--------------------------------------------------------------------------
    |
    | This option specifies an array of options for slug normalization.
    |
    | Default: [
    |              'max_length' => 255,
    |              'unique' => 'document',
    |          ]
    |
    */

    'slug_normalizer' => [
        'max_length' => 255,
        'unique'     => 'document',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Attributes
    |--------------------------------------------------------------------------
    |
    | The option allows you to apply default HTML classes and other attributes using configuration options.
    |
    */

    'default_attributes' => [
        League\CommonMark\Extension\Table\Table::class => [
            'class' => 'table',
        ],
        League\CommonMark\Extension\CommonMark\Node\Inline\Link::class => [
            'class' => 'link link-primary link-hover'
        ],
        League\CommonMark\Extension\CommonMark\Node\Inline\Code::class => [
            'class' => 'text-[color:hsl(var(--p))] bg-[color:var(--tw-prose-pre-bg)] rounded-sm'
        ],
        League\CommonMark\Extension\TaskList\TaskListItemMarker::class => [
            'class' => 'checkbox h-4 w-4 m-0'
        ],
        League\CommonMark\Extension\CommonMark\Node\Block\BlockQuote::class => [
            'class' => 'text-xl italic font-semibold'
        ],
        League\CommonMark\Extension\CommonMark\Node\Block\Heading::class => [
            'class' => ''
        ]
    ],

];
