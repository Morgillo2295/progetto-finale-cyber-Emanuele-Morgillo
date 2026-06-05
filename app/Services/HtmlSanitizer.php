<?php

namespace App\Services;

class HtmlSanitizer
{
    /**
     * Solo tag di formattazione testo. Niente script, img, link, attributi.
     */
    private const ALLOWED_TAGS = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u',
        'ol', 'ul', 'li', 'h1', 'h2', 'h3', 'h4', 'blockquote',
    ];

    public function sanitize(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $html = $this->removeDangerousBlocks($html);
        $html = strip_tags($html, '<'.implode('><', self::ALLOWED_TAGS).'>');

        return $this->stripAllAttributes($html);
    }

    public function containsDangerousMarkup(string $html): bool
    {
        $decoded = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $sanitized = $this->sanitize($html);

        if ($this->removeDangerousBlocks($decoded) !== $decoded) {
            return true;
        }

        return preg_match(
            '/<script|javascript\s*:|on\w+\s*=|<iframe|<object|<embed|<svg|<img|<link|<meta|<base|<form/i',
            $decoded
        ) === 1;
    }

    private function removeDangerousBlocks(string $html): string
    {
        $patterns = [
            '/<script\b[^>]*>.*?<\/script>/is',
            '/<style\b[^>]*>.*?<\/style>/is',
            '/<iframe\b[^>]*>.*?<\/iframe>/is',
            '/<object\b[^>]*>.*?<\/object>/is',
            '/<embed\b[^>]*\/?>/is',
            '/<svg\b[^>]*>.*?<\/svg>/is',
            '/<script\b[^>]*>/is',
        ];

        foreach ($patterns as $pattern) {
            $html = preg_replace($pattern, '', $html) ?? $html;
        }

        return $html;
    }

    private function stripAllAttributes(string $html): string
    {
        return preg_replace_callback(
            '/<(\/?)([a-zA-Z0-9]+)(\s[^>]*)?\/?>/',
            function (array $matches): string {
                $tag = strtolower($matches[2]);

                if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                    return '';
                }

                if ($matches[1] === '/') {
                    return $tag === 'br' ? '' : "</{$tag}>";
                }

                return $tag === 'br' ? '<br>' : "<{$tag}>";
            },
            $html
        ) ?? $html;
    }
}
