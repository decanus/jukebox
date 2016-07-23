#!/usr/bin/env php
<?php

$template = new \DOMDocument;
$template->loadXML(file_get_contents($argv[1]));

$version = $argv[2];

$xpath = new \DOMXPath($template);
$css = $xpath->query('//*[@href="/css/jukebox.css"]');

$xpath->query('//*[@id="version"]')->item(0)->nodeValue = 'window.__$assetVersion = \'' . $version . '\'';

if ($css->length === 1) {
    $css->item(0)->setAttribute('href', '/css/jukebox-' . $version  . '.css');
}

$js = [
    'jukebox',
    'polyfills',
    'views',
];

foreach ($js as $script) {
    $javascript = $xpath->query('//*[@src="/js/' . $script . '.js"]');
    if ($javascript->length === 1) {
        $javascript->item(0)->setAttribute('src', '/js/' . $script . '-' . $version  . '.js');
    }
}

$template->save($argv[1]);
