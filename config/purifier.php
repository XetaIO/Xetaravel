<?php

return [
    'encoding' => 'UTF-8',
    'finalize' => true,
    'cachePath' => storage_path('app/purifier'),
    'cacheFileMode' => 0755,
    'settings' => [
        'blog_article' => [
            'URI.Base' => 'http://sf.xeta.io',
            'HTML.Allowed' => 'p, h1, h2, h3, h4, h5, span[style], strong, em, u, img[alt|src|style|title], ol, li, ul, a[href], br, blockquote[class], pre[class]',
            'CSS.AllowedProperties' => 'font-size,height,width',
            'Attr.AllowedClasses' => 'prettyprint, linenums, blockquote',
            'AutoFormat.RemoveEmpty' => true,
        ],
        'blog_article_empty' => [
            'HTML.Allowed' => 'p',
            'AutoFormat.RemoveEmpty' => true,
        ],
        'blog_article_meta' => [
            'HTML.Allowed' => '',
            'AutoFormat.RemoveEmpty' => true,
        ],
    ],

];
