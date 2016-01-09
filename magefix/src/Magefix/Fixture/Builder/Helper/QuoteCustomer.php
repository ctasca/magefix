<?php

namespace Magefix\Fixture\Builder\Helper;

use Mage;
use Mage_Customer_Model_Group;
use Mage_Sales_Model_Quote;
use Magefix\Fixture\Builder;
use Magefix\Fixture\Builder\Helper;

/**
 * Class QuoteCustomer
 *
 * @package Magefix\Fixture\Builder\Helper
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class QuoteCustomer implements Helper
{
    /**
     * @var Builder
     */
    private $_builder;
    /**
     * @var Mage_Sales_Model_Quote
     */
    private $_quote;
    /**
     * @var array
     */
    private $_data;

    public function __construct(Builder $_builder, Mage_Sales_Model_Quote $_quote, array $_data)
    {

        $this->_builder = $_builder;
        $this->_quote = $_quote;
        $this->_data = $_data;
    }

    public function setupMethodGuest()
    {
        $this->_quote->setCustomerId(null)
            ->setCustomerEmail($this->_quote->getBillingAddress()->getEmail())
            ->setCustomerIsGuest(true)
            ->setCustomerGroupId(Mage_Customer_Model_Group::NOT_LOGGED_IN_ID);
    }

    public function setupMethodRegister()
    {
        $this->_setupCustomerOptionalData();
        $this->_setupCustomerDataAndValidate();
    }

    /**
     *
     * @return date|bool
     *
     */
    private function _setupCustomerOptionalData()
    {
        $dob = false;
        if (isset($this->_data['dob'])) {
            $dob = Mage::app()->getLocale()->date($this->_data['dob'], null, null, false)->toString(
                'yyyy-MM-dd'
            );

            $this->_quote->setCustomerDob($dob);
        }

        if (isset($this->_data['taxvat'])) {
            $this->_quote->setCustomerTaxvat($this->_data['taxvat']);
        }

        if (isset($this->_data['gender'])) {
            $this->_quote->setCustomerGender($this->_data['gender']);
        }

        return $dob;
    }

    private function _setupCustomerDataAndValidate()
    {
        $customer = Mage::getModel($this->_data['model']);
        $this->_quote->setPasswordHash($customer->encryptPassword($this->_data['password']));
        $customer->setData($this->_data);
        $dob = $this->_quote->getCustomerDob();

        if ($dob) {
            $customer->setDob($dob);
        }

        $validationResult = $customer->validate();

        if ($validationResult === true) {
            $this->_quote->getBillingAddress()->setEmail($this->_data['email']);
            Mage::helper('core')->copyFieldset('customer_account', 'to_quote', $customer, $this->_quote);
        }
    }
}
