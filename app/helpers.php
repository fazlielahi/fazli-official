<?php

if (!function_exists('getTextDirection')) {
    function getTextDirection($text)
    {
        // Detect Arabic, Urdu, Persian, Hebrew characters
        if (preg_match('/[\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{0590}-\x{05FF}]/u', $text)) {
            return 'right';
        }
        return 'left';
    }
}
