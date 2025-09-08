
{{-- Basic Tags --}}
<meta name="author" content="{{ $author }}">
<meta name="copyright" content="{{ $copyright }}">
<meta name="description" content="{{ $description }}">

{{-- Canonical & Robots --}}
<link rel="canonical" href="{{ $url }}">
<meta name="robots" content="{{ $robots ?? 'index,follow' }}">

{{-- Facebook / Open Graph --}}
<meta property="og:site_name" content="{{ config('app.name')  }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image:width" content="{{ $imageWidth ?? 870 }}">
<meta property="og:image:height" content="{{ $imageHeight ?? 350 }}">
<meta property="og:type" content="{{ $type ?? 'website' }}">

@if(($type ?? null) === 'article')
    <meta property="article:published_time" content="{{ $publishedTime ?? '' }}">
    <meta property="article:modified_time" content="{{ $modifiedTime ?? '' }}">
    @if(!empty($articleAuthorUrl))
        <meta property="article:author" content="{{ $articleAuthorUrl }}">
    @endif
    @if(!empty($articleSection))
        <meta property="article:section" content="{{ $articleSection }}">
    @endif
    @foreach(($articleTags ?? []) as $tag)
        <meta property="article:tag" content="{{ $tag }}">
    @endforeach
@endif



{{-- Twitter --}}
<meta property="twitter:card" content="{{ $twitterCard ?? 'summary_large_image' }}">
<meta property="twitter:site" content="{{ config('app.name')  }}">
<meta property="twitter:title" content="{{ $title }}">
<meta property="twitter:url" content="{{ $url }}">
<meta property="twitter:image" content="{{ $image }}">
<meta property="twitter:description" content="{{ $description }}">
