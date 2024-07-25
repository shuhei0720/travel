<?php

if (!function_exists('convertLinks')) {
    function convertLinks($text)
    {
        $pattern = '/(http:\/\/|https:\/\/|www\.)[^\s]+/i';
        $replacement = '<a href="$0" target="_blank" class="text-blue-500 underline">$0</a>';
        return preg_replace($pattern, $replacement, e($text));
    }
}