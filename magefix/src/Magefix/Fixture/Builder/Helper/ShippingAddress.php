<?php

namespace Magefix\Fixture\Builder\Helper;


use Mage_Sales_Model_Quote;
use Magefix\Exceptions\UnknownQuoteAddressType;
use Magefix\Fixture\Builder\AbstractBuilder;

class ShippingAddress
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
        $address = $this->_builder->processFixtureAttributes($this->_data['fixture']['addresses'][$addressType]);

        if ($sameAsBilling === true) {
            $this->_quote->getBillingAddress()->addData($address);
            $this->_quote->getShippingAddress()->addData($address);
        }

        if ($addressType == 'billing' && $sameAsBilling === false) {
            $this->_quote->getBillingAddress()->addData($address);
        } elseif ($addressType == 'shipping' && $sameAsBilling === false) {
            $this->_quote->getShippingAddress()->addData($address);
        }
    }
}
