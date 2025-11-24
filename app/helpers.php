<?php

if (!function_exists('make_links_clickable')) {
    /**
     * Convert URLs in text to clickable links
     *
     * @param string $text
     * @return string
     */
    function make_links_clickable($text)
    {
        // If the text already contains HTML links, don't process it
        if (strpos($text, '<a href=') !== false) {
            return $text;
        }

        // Pattern to match URLs that are not already in HTML tags
        $pattern = '/\b(?:https?:\/\/|www\.|ftp:\/\/|ftps:\/\/)[^\s<>"\'{}|\\^`[\]]+(?:\([^\s<>"\'{}|\\^`[\]]*\))?[^\s<>"\'{}|\\^`[\]]*(?:\([^\s<>"\'{}|\\^`[\]]*\))?[^\s<>"\'{}|\\^`[\]]*(?:\([^\s<>"\'{}|\\^`[\]]*\))?/i';

        // Replace URLs with clickable links
        $text = preg_replace_callback($pattern, function ($matches) {
            $url = $matches[0];

            // Add http:// if URL doesn't start with a protocol
            if (!preg_match('/^(https?:\/\/|ftp:\/\/|ftps:\/\/)/i', $url)) {
                $url = 'http://' . $url;
            }

            // Return clickable link
            return '<a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800 underline">' . htmlspecialchars($matches[0]) . '</a>';
        }, $text);

        return $text;
    }
}
