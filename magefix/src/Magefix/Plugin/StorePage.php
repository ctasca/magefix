<?php
namespace Magefix\Plugin;

/**
 * Class StorePage
 * @package Magefix\Plugin
 * @author  Carlo Tasca <ctasca@inviqa.com>
 */
trait StorePage
{
    /**
     * @param array $urlParameters
     * @return mixed
     */
    public abstract function open(array $urlParameters = array());

    /**
     * @param string $toBeReplaced
     * @param string $replace
     * @param array $urlParameters
     */
    public function openStorePage($toBeReplaced = '', $replace = '', array $urlParameters = [])
    {
        $this->setPageObjectPath($toBeReplaced, $replace);
        $this->open($urlParameters);
    }

    /**
     * @param string $toBeReplaced
     * @param string $replace
     */
    public function setPageObjectPath($toBeReplaced, $replace)
    {
        if (!empty($toBeReplaced) && !empty($replace)) {
            $this->path = str_replace($toBeReplaced, $replace, $this->path);
        }
    }
}
