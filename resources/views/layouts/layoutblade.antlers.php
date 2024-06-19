<!DOCTYPE html>

<html lang="{{ site:short_locale }}" class="antialiased">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="alternate" type="application/rss+xml" title="News Feed" href="{{ config:app:url }}/feed/news" />
    {{ vite src="resources/css/tailwind.css|resources/js/site.js" }}
    {{ partial:statamic-peak-seo::snippets/seo }}
    {{ partial:statamic-peak-browser-appearance::snippets/browser_appearance }}
    {{ partial:statamic-peak-tools::snippets/live_preview }}

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    {{ if {cookie_tag} === '2' || {cookie_tag} === 'true' }}
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{google:google_gtag}}"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{google:google_gtag}}');
        </script>
    {{ /if }}

    <style>
        :root {
        --primary-color: {{ colors:primary_color }};
        --primary-color-600: {{ colors:primary_color_600 }};
        --primary-color-700: {{ colors:primary_color_700 }};
        --primary-color-800: {{ colors:primary_color_800 }};
        --primary-color-900: {{ colors:primary_color_900 }};

        --secondary-color: {{ colors:secondary_color }};
        --secondary-color-600: {{ colors:secondary_color_600 }};
        --secondary-color-700: {{ colors:secondary_color_700 }};
        --secondary-color-800: {{ colors:secondary_color_800 }};
        --secondary-color-900: {{ colors:secondary_color_900 }};
        }
    </style>
    <link rel="stylesheet" type="text/css" href="/vendor/cookie-consent/css/cookie-consent.css">
    {{ livewire:styles }}
</head>

<body   class="min-h-screen font-sans leading-normal text-gray-800"
        x-data="{ mobileNav: false, openImgSlideShow: false, modalOpen: false, showNavigation: true }"
        :class="{
            'overflow-hidden': mobileNav || openImgSlideShow || modalOpen
        }"
    >


        {{ if current_url | contains("/immobilien/details") }}
            <link rel="canonical" href="{{ current_url }}" />
        {{ /if }}
        {{ if current_full_url | contains("/immobilien?filter") }}
            <link rel="canonical" href="/immobilien" />
        {{ /if }}

        {{ partial:statamic-peak-tools::snippets/noscript }}
        {{ partial:statamic-peak-tools::navigation/skip_to_content }}
        {{# TODO: produces -- NOCACHE_PLACEHOLDER---  #}}
            {{# {{ partial:statamic-peak-tools::components/toolbar }} #}}
                {{ yield:seo_body }}

                {{ partial:layout/header }}
                {{ partial:bladecontent }}
                {{ template_content }}
                {{ partial:layout/footer }}
                {{ yield:modal }}

    {{ livewire:scripts }}
</body>

</html>
