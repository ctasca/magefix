<?php

namespace Magefix\Plugin;

/**
 * Class Spinner
 *
 * Provide "waiting" functionality to contexts
 *
 * @package Magefix\Plugin
 * @author  Carlo Tasca <ctasca@inviqa.com>
 */
trait Spinner
{
    /**
     * @param $lambda
     * @param int $wait
     * @return bool
     * @throws \Exception
     */
    public function spin($lambda, $wait = 60)
    {
        for ($i = 0; $i < $wait; $i++) {
            try {
                if ($lambda($this)) {
                    return true;
                }
            } catch (\Exception $e) {
                // do nothing
            }

            sleep(1);
        }

        $this->_throwBacktraceException();
    }

    /**
     * Spin until element is visible. Default timeout is 60 seconds.
     *
     * @param string|Object $element
     * @param int $wait
     */
    public function spinUntilVisible($element, $wait = 60)
    {
        $this->spin(function ($context) use ($element) {
            return $this->_spinnerAction($context, $element, 'isVisible', true);
        }, $wait);
    }

    /**
     * Spin until element is not visible. Default timeout is 60 seconds.
     *
     * @param string|Object $element
     * @param int $wait
     */
    public function spinUntilInvisible($element, $wait = 60)
    {
        $this->spin(function ($context) use ($element) {
            return $this->_spinnerAction($context, $element, 'isVisible', false);
        }, $wait);
    }

    /**
     * Spin and click element. Default timeout is 60 seconds.
     *
     * @param string|Object $element
     * @param int $wait
     */
    public function spinAndClick($element, $wait = 60)
    {
        $this->spin(function ($context) use ($element) {
            return $this->_spinnerAction($context, $element, 'click');
        }, $wait);
    }

    /**
     * Spin and press element. Default timeout is 60 seconds.
     *
     * @param string|Object $element
     * @param int $wait
     */
    public function spinAndPress($element, $wait = 60)
    {
        $this->spin(function ($context) use ($element) {
            return $this->_spinnerAction($context, $element, 'press');
        }, $wait);
    }

    /**
     * @throws \Exception
     */
    protected function _throwBacktraceException()
    {
        $backtrace = debug_backtrace();

        throw new \Exception(
            "Timeout thrown by " . $backtrace[1]['class'] . "::" . $backtrace[1]['function'] . "()\n" .
            $backtrace[1]['file'] . ", line " . $backtrace[1]['line']
        );
    }

    /**
     * @param $context
     * @param $element
     * @param $action
     * @param null $condition
     * @return bool
     */
    private function _spinnerAction($context, $element, $action, $condition = null)
    {
        if (is_object($element)) {
            if (!is_null($condition)) {
                return $element->$action() === $condition;
            }
            $element->$action();
        } else {
            if (!is_null($condition)) {
                return  $context->getElement($element)->$action() === $condition;
            }
            $context->getElement($element)->$action();
        }

        return true;
    }
}
