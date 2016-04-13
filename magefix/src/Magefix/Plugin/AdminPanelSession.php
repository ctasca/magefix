<?php

namespace Magefix\Plugin;

/**
 * Class AdminPanelSession
 *
 *
 * @package Magefix\Plugin
 * @author  Carlo Tasca <ctasca@inviqa.com>
 */
trait AdminPanelSession
{
    abstract public function getCurrentUrl();
    abstract public function getContent();

    /**
     * @return string
     */
    public function getCurrentUrlKey()
    {
        return $this->_findKeyForUrl($this->getCurrentUrl());
    }

    /**
     * @param $url
     * @return mixed|string
     */
    public function getSessionKeyForUrl($url)
    {
        $content = $this->getContent();
        $matches = [];
        $url = rtrim($url, DS);
        preg_match("#{$url}/key/([a-z0-9]{1,})#", $content, $matches);

        return isset($matches[1]) ? $matches[1] : '';
    }

    /**
     * @param $url
     * @return string
     */
    private function _findKeyForUrl($url)
    {
        $key = '';

        $matches = [];
        preg_match('#key/[a-z0-9]{1,}#', $url, $matches);

        if (isset($matches[0])) {
            $key = str_replace('key/', '', $matches[0]);
        }

        return $key;
    }
}
