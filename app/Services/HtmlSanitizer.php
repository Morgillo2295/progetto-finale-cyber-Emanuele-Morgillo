<?php

namespace App\Services;

class HtmlSanitizer
{
    private const ALLOWED_TAGS = '<p><br><strong><em><u><ol><ul><li><h1><h2><h3><h4><h5><h6><a><img><blockquote><span><div>';

    public function sanitize(?string $html): string
    {
        if ($html === null || $html === '') {
            return '';
        }

        $clean = strip_tags($html, self::ALLOWED_TAGS);
        $clean = preg_replace('/\s*on\w+\s*=\s*("|\').*?\1/i', '', $clean) ?? $clean;
        $clean = preg_replace('/\s*on\w+\s*=\s*[^\s>]+/i', '', $clean) ?? $clean;
        $clean = preg_replace('/javascript\s*:/i', '', $clean) ?? $clean;

        return $clean;
    }
}
