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
        $this->_quote = $_quote;
        $this->_data = $_data;
        $this->_builder = $_builder;
    }

    public function addToQuote()
    {
        $iterator = new \ArrayIterator($this->_data['fixture']['addresses']);

        while ($iterator->valid()) {
            if ($iterator->key() == 'billing_and_shipping') {
                $this->_setBillingAndShipping();
            } else {
                $this->_setBillingOrShipping($iterator->key());
            }
            $iterator->next();
        }
    }

    protected function _setBillingAndShipping()
    {
        list($address, $billing, $shipping) = $this->_getBillingAndShippingAddressesByType('billing_and_shipping');

        $billing->setData($address);
        $shipping->setData($address);
        $this->_quote->setBillingAddress($billing);
        $this->_quote->setShippingAddress($shipping);
    }

    /**
     * @param string $addressType
     */
    protected function _setBillingOrShipping($addressType)
    {
        list($address, $billing, $shipping) = $this->_getBillingAndShippingAddressesByType($addressType);

        if ($addressType == 'billing') {
            $billing->setData($address);
            $this->_quote->setBillingAddress($billing);
        } elseif ($addressType == 'shipping') {
            $shipping->setData($address);
            $this->_quote->setShippingAddress($shipping);
        }
    }

    /**
     * @param string $addressType
     * @throws UnknownQuoteAddressType
     */
    protected function _throwUnknownQuoteAddressTypeException($addressType)
    {
        if ($addressType !== 'billing_and_shipping' && $addressType !== 'billing' && $addressType !== 'shipping') {
            throw new UnknownQuoteAddressType(
                'Sales Order Fixture: Unknown quote address type. Check fixture yml.'
            );
        }
    }

    /**
     * @param $addressType
     * @return array
     */
    protected function _getBillingAndShippingAddressesByType($addressType)
    {
        $address = $this->_data['fixture']['addresses'][$addressType];
        $billing = Mage::getModel('sales/quote_address');
        $shipping = Mage::getModel('sales/quote_address');
        return array($address, $billing, $shipping);
    }
}
