<?php

namespace Magefix\Fixture\Builder\Helper;


use Mage;
use Mage_Sales_Model_Quote;
use Magefix\Exceptions\UnknownQuoteAddressType;
use Magefix\Fixture\Builder\AbstractBuilder;
use Magefix\Fixture\Builder\Helper;

class ShippingAddress implements Helper
{
    /**
     * @var Mage_Sales_Model_Quote
     */
    private $_quote;
    /**
     * @var array
     */
    private $_data;
    /**
     * @var AbstractBuilder
     */
    private $_builder;

    public function __construct(AbstractBuilder $_builder, Mage_Sales_Model_Quote $_quote, array $_data)
    {
        $this->_quote   = $_quote;
        $this->_data    = $_data;
        $this->_builder = $_builder;
    }

    public function addToQuote()
    {
        foreach ($this->_data['fixture']['addresses'] as $addressType => $address) {
            switch ($addressType) {
                case 'billing_and_shipping':
                    $this->_setQuoteAddress($addressType, true);
                    break;
                case ('billing' || 'shipping'):
                    $this->_setQuoteAddress($addressType, false);
                    break;
                default:
                    throw new UnknownQuoteAddressType(
                        'Sales Order Fixture: Unknown quote address type. Check fixture yml.'
                    );
            }
        }
    }

    /**
     * @param $addressType
     *
     * @param $sameAsBilling
     *
     * @return array
     */
    protected function _setQuoteAddress($addressType, $sameAsBilling)
    {
        $address = $this->_data['fixture']['addresses'][$addressType];
        $billing = Mage::getModel('sales/quote_address');
        $shipping = Mage::getModel('sales/quote_address');
        if ($sameAsBilling === true) {
            $billing->setData($address);
            $shipping->setData($address);
            $this->_quote->setBillingAddress($billing);
            $this->_quote->setShippingAddress($shipping);
        }

        if ($addressType == 'billing' && $sameAsBilling === false) {
            $billing->setData($address);
            $this->_quote->setBillingAddress($billing);
        } elseif ($addressType == 'shipping' && $sameAsBilling === false) {
            $shipping->setData($address);
            $this->_quote->setShippingAddress($shipping);
        }
    }
}
