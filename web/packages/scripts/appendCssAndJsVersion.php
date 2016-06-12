#!/usr/bin/env php
<?php

$template = new \DOMDocument;
$template->loadXML(file_get_contents($argv[1]));

$xpath = new \DOMXPath($template);
$css = $xpath->query('//*[@href="/css/jukebox.css"]');

if ($css->length === 1) {
    $css->item(0)->setAttribute('href', '/css/jukebox-' . $argv[2]  . '.css');
}

$js = [
    'jukebox',
    'polyfills',
    'views',
];

foreach ($js as $script) {
    $javascript = $xpath->query('//*[@src="/js/' . $script . '.js"]');
    if ($javascript->length === 1) {
        $javascript->item(0)->setAttribute('src', '/js/' . $script . '-' . $argv[2]  . '.js');
    }
}

$template->save($argv[1]);
