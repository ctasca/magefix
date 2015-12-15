<?php

namespace Magefix\Fixture\Builder;

use Mage;
use Mage_Customer_Model_Group;
use Magefix\Exceptions\UndefinedAttributes;
use Magefix\Exceptions\UndefinedQuoteAddresses;
use Magefix\Exceptions\UndefinedQuoteProducts;
use Magefix\Exceptions\UnknownQuoteAddressType;
use Magefix\Fixture\Builder\Helper\Checkout;
use Magefix\Fixture\Builder\Helper\QuoteCustomer;
use Magefix\Fixture\Builder\Helper\ShippingAddress;
use Magefix\Fixture\Builder\Helper\ShippingMethod;

/**
 * Class SalesOrder
 *
 * @package Magefix\Fixture\Builder
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class SalesOrder extends AbstractBuilder
{
    /**
     * @var array
     */
    private $_quoteProducts = [];

    /**
     * @throws UndefinedAttributes
     * @throws UnknownQuoteAddressType
     *
     */
    public function build()
    {
        $defaultData = $this->_getMageModelData() ? $this->_getMageModelData() : [];
        $fixtureData = $this->_getFixtureAttributes();
        $mergedData  = array_merge($defaultData, $fixtureData);

        $this->_getMageModel()->setData($mergedData);
        $this->_buildQuoteProductFixtures();
        $this->_addProductsToQuote();
        $this->_addAddressesToQuote();
        $this->_setShippingMethod();
        $this->_setCheckoutMethod();
        $this->_setPaymentMethod();

        return $this->_saveFixture();
    }

    /**
     * @throws UndefinedQuoteProducts
     * @throws \Magefix\Fixture\Factory\UndefinedFixtureModel
     *
     */
    protected function _buildQuoteProductFixtures()
    {
        $this->_throwUndefinedQuoteProductsException();
        $this->_quoteProducts = $this->_buildManySimple('quote_products');
    }


    protected function _addProductsToQuote()
    {
        foreach ($this->_quoteProducts as $product) {
            $this->_getMageModel()->addProduct($product);
        }
    }

    /**
     * @throws UndefinedQuoteAddresses
     * @throws UnknownQuoteAddressType
     *
     */
    protected function _addAddressesToQuote()
    {
        $this->_throwUndefinedQuoteAddressesException();

        $addresses = new ShippingAddress($this, $this->_getMageModel(), $this->_data);
        $addresses->addToQuote();
    }

    protected function _setShippingMethod()
    {
        $this->_validateShippingMethodData();

        $shippingData = $this->_processFixtureAttributes($this->_data['fixture']['shipping_method']);

        $shippingMethod = new ShippingMethod($this->_getMageModel(), $shippingData);
        $shippingMethod->addShippingDataToQuote();
    }

    /**
     * @throws UndefinedAttributes
     *
     */
    protected function _validateShippingMethodData()
    {
        $this->_throwUndefinedAttributesException(
            isset($this->_data['fixture']['shipping_method']['carrier']),
            'Sales Order Fixture: Shipping carrier has not been defined. Check fixture yml.'
        );

        $this->_throwUndefinedAttributesException(
            isset($this->_data['fixture']['shipping_method']['method']),
            'Sales Order Fixture: Shipping method has not been defined. Check fixture yml.'
        );

        $this->_throwUndefinedAttributesException(
            isset($this->_data['fixture']['shipping_method']['free_shipping']),
            'Sales Order Fixture: Free shipping has not been defined. Check fixture yml.'
        );

        $this->_throwUndefinedAttributesException(
            isset($this->_data['fixture']['shipping_method']['collect_totals']),
            'Sales Order Fixture: Collect totals has not been defined. Check fixture yml.'
        );

        $this->_throwUndefinedAttributesException(
            isset($this->_data['fixture']['shipping_method']['collect_shipping_rates']),
            'Sales Order Fixture: Collect shipping rates has not been defined. Check fixture yml.'
        );
    }

    protected function _setCheckoutMethod()
    {
        $this->_validateCheckoutMethod();
        $checkoutMethodData = $this->_processFixtureAttributes($this->_data['fixture']['checkout']);
        $this->_getMageModel()->setCheckoutMethod($checkoutMethodData['method']);
        $this->_setCheckoutMethodGuest($checkoutMethodData);

        if (Checkout::isRegisterCheckout($checkoutMethodData)) {
            $customerData = $this->_processFixtureAttributes($this->_data['fixture']['checkout']['customer']);
            $this->_setCheckoutMethodRegister($customerData);
        }
    }

    /**
     * @param array $checkoutMethodData
     *
     */
    protected function _setCheckoutMethodGuest(array $checkoutMethodData)
    {
        if (Checkout::isGuestCheckout($checkoutMethodData)) {
            $customer = new QuoteCustomer($this, $this->_getMageModel(), $checkoutMethodData);
            $customer->setMethodGuest();
        }
    }

    /**
     * @param array $customerRegisterData
     *
     */
    protected function _setCheckoutMethodRegister(array $customerRegisterData)
    {
        $customer = new QuoteCustomer($this, $this->_getMageModel(), $customerRegisterData);
        $customer->setMethodRegister();
    }

    protected function _setPaymentMethod()
    {
        $this->_validatePaymentMethod();
        $paymentMethodData = $this->_processFixtureAttributes($this->_data['fixture']['payment']);
        $this->_importPaymentData($paymentMethodData);

    }

    protected function _importPaymentData(array $data)
    {
        $this->_getMageModel()->getPayment()->importData(['method' => $data['method']]);
    }

    /**
     * @return mixed
     * @throws Exception
     *
     */
    protected function _saveFixture()
    {
        $this->_getMageModel()->save();
        $order = Checkout::quoteServiceSubmitAll($this->_getMageModel());

        return $order->getId();
    }

    /**
     * @throws UndefinedQuoteProducts
     *
     */
    protected function _validatePaymentMethod()
    {
        if (!isset($this->_data['fixture']['payment']['method'])) {
            throw new UndefinedQuoteProducts(
                'Sales Order Fixture: Payment method has not been defined. Check fixture yml.'
            );
        }
    }

    /**
     * @throws UndefinedAttributes
     *
     */
    protected function _validateCheckoutMethod()
    {
        $this->_throwUndefinedAttributesException(
            isset($this->_data['fixture']['checkout']['method']),
            'Sales Order Fixture: Checkout method has not been defined. Check fixture yml.'
        );
    }

    /**
     * @throws UndefinedBundleProducts
     */
    protected function _throwUndefinedQuoteProductsException()
    {
        if (!isset($this->_data['fixture']['quote_products']['products'])) {
            throw new UndefinedQuoteProducts(
                'Sales Order Fixture: Quote products have not been defined. Check fixture yml.'
            );
        }
    }

    /**
     * @throws UndefinedQuoteAddresses
     *
     */
    protected function _throwUndefinedQuoteAddressesException()
    {
        if (!isset($this->_data['fixture']['addresses'])) {
            throw new UndefinedQuoteAddresses(
                'Sales Order Fixture: Quote addresses have not been defined. Check fixture yml.'
            );
        }
    }
}
