<?php
declare(strict_types = 1);

namespace OrangeShadow\PastebinApi;

class ResponseChecking
{
    /**
     * Check content for bad request message
     *
     * @param $content
     * @return bool
     */
    public function isBadRequest($content): bool
    {
        return preg_match('/^Bad API request,/i', $content) || preg_match('/^Post limit,/', $content);
    }

    /**
     * Check content for Not Found
     *
     * @param $content
     * @return bool
     */
    public function isNotFound($content): bool
    {
        return (bool)preg_match('/^No pastes found\.$/i', $content);
    }

    /**
     * Check message on success delete
     *
     * @param $content
     * @return bool
     */
    public function isPasteRemove($content): bool
    {
        return (bool)preg_match('/^Paste Removed$/i', $content);
    }
}