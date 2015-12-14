<?php
/**
 * SalesOrder
 */

namespace Magefix\Fixture\Builder;

use Mage;
use Mage_Checkout_Model_Type_Onepage;
use Mage_Customer_Model_Group;
use Magefix\Exceptions\UndefinedAttributes;
use Magefix\Exceptions\UndefinedQuoteAddresses;
use Magefix\Exceptions\UndefinedQuoteProducts;
use Magefix\Exceptions\UnknownQuoteAddressType;

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
        $address = $this->_processFixtureAttributes($this->_data['fixture']['addresses'][$addressType]);

        if ($sameAsBilling === true) {
            $this->_getMageModel()->getBillingAddress()->addData($address);
            $this->_getMageModel()->getShippingAddress()->addData($address);
        }

        if ($addressType == 'billing' && $sameAsBilling === false) {
            $this->_getMageModel()->getBillingAddress()->addData($address);
        } elseif ($addressType == 'shipping' && $sameAsBilling === false) {
            $this->_getMageModel()->getShippingAddress()->addData($address);
        }
    }

    protected function _setShippingMethod()
    {
        $this->_validateShippingMethodData();

        $shippingData = $this->_processFixtureAttributes($this->_data['fixture']['shipping_method']);
        $this->_setShippingData($shippingData);
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

    /**
     * @param $shippingData
     *
     */
    protected function _setShippingData($shippingData)
    {
        $shippingAddress = $this->_getMageModel()->getShippingAddress();
        $shippingAddress->setShippingMethod($shippingData['method']);
        $shippingAddress->setShippingDescription($shippingData['description']);

        if ($shippingData['collect_shipping_rates']) {
            $shippingAddress->setCollectShippingRates(true);
            $shippingAddress->collectShippingRates();
        }

        if ($shippingData['collect_totals']) {
            $this->_getMageModel()->collectTotals();
        }

        if ($shippingData['free_shipping']) {
            $this->_getMageModel()->setFreeShipping(true);
        }
    }

    /**
     *
     */
    protected function _setCheckoutMethod()
    {
        $this->_validateCheckoutMethod();
        $checkoutMethodData = $this->_processFixtureAttributes($this->_data['fixture']['checkout']);
        $this->_getMageModel()->setCheckoutMethod($checkoutMethodData['method']);
        $this->_setCheckoutMethodGuest($checkoutMethodData);

        if ($this->_isRegisterCheckout($checkoutMethodData)) {
            $customerData = $this->_processFixtureAttributes($this->_data['fixture']['checkout']['customer']);
            $this->_setCheckoutMethodRegister($customerData);
        }
    }

    /**
     * @param $method
     * @param $checkoutMethodData
     *
     * @return bool
     */
    protected function _isCheckoutMethod($method, $checkoutMethodData)
    {
        $isGuestCheckout = false;

        if ($checkoutMethodData['method'] == $method) {
            $isGuestCheckout = true;
        }

        return $isGuestCheckout;
    }

    /**
     * @param array $checkoutMethodData
     *
     * @return bool
     *
     */
    protected function _isGuestCheckout(array $checkoutMethodData)
    {
        return $this->_isCheckoutMethod(Mage_Checkout_Model_Type_Onepage::METHOD_GUEST, $checkoutMethodData);
    }

    /**
     * @param array $checkoutMethodData
     *
     * @return bool
     *
     */
    protected function _isRegisterCheckout(array $checkoutMethodData)
    {
        return $this->_isCheckoutMethod(Mage_Checkout_Model_Type_Onepage::METHOD_REGISTER, $checkoutMethodData);
    }

    /**
     * @param array $checkoutMethodData
     *
     * @return bool
     *
     */
    protected function _isCustomerCheckout(array $checkoutMethodData)
    {
        return $this->_isCheckoutMethod(Mage_Checkout_Model_Type_Onepage::METHOD_CUSTOMER, $checkoutMethodData);
    }


    /**
     * @param array $checkoutMethodData
     *
     */
    protected function _setCheckoutMethodGuest(array $checkoutMethodData)
    {
        if ($this->_isGuestCheckout($checkoutMethodData)) {
            $this->_getMageModel()->setCustomerId(null)
                ->setCustomerEmail($this->_getMageModel()->getBillingAddress()->getEmail())
                ->setCustomerIsGuest(true)
                ->setCustomerGroupId(Mage_Customer_Model_Group::NOT_LOGGED_IN_ID);
        }
    }

    /**
     * @param array $customerRegisterData
     *
     */
    protected function _setCheckoutMethodRegister(array $customerRegisterData)
    {
        $dob = $this->_setCustomerRegistrationOptionalData($customerRegisterData);

        $customer = Mage::getModel($customerRegisterData['model']);
        $this->_getMageModel()->setPasswordHash($customer->encryptPassword($customerRegisterData['password']));
        $customer->setData($customerRegisterData);

        if (isset($customerRegisterData['dob'])) {
            $customer->setDob($dob);
        }

        $this->_validateRegistrationCustomer($customerRegisterData, $customer);
    }

    /**
     * @param array $customerRegisterData
     *
     * @return date|bool
     *
     */
    protected function _setCustomerRegistrationOptionalData(array $customerRegisterData)
    {
        $dob = false;
        if (isset($customerRegisterData['dob'])) {
            $dob = Mage::app()->getLocale()->date($customerRegisterData['dob'], null, null, false)->toString(
                'yyyy-MM-dd'
            );

            $this->_getMageModel()->setCustomerDob($dob);
        }

        if (isset($customerRegisterData['taxvat'])) {
            $this->_getMageModel()->setCustomerTaxvat($customerRegisterData['taxvat']);
        }

        if (isset($customerRegisterData['gender'])) {
            $this->_getMageModel()->setCustomerGender($customerRegisterData['gender']);
        }

        return $dob;
    }

    /**
     * @param array $customerRegisterData
     * @param       $customer
     *
     */
    protected function _validateRegistrationCustomer(array $customerRegisterData, $customer)
    {
        $validationResult = $customer->validate();

        if ($validationResult === true) {
            $this->_getMageModel()->getBillingAddress()->setEmail($customerRegisterData['email']);
            Mage::helper('core')->copyFieldset('customer_account', 'to_quote', $customer, $this->_getMageModel());
        }
    }

    protected function _setPaymentMethod()
    {
        $this->_validatePaymentMethod();
        $paymentMethodData = $this->_processFixtureAttributes($this->_data['fixture']['payment']);
        $this->_importPaymentData($paymentMethodData);

    }

    protected function _validatePaymentMethod()
    {
        if (!isset($this->_data['fixture']['payment']['method'])) {
            throw new UndefinedQuoteProducts(
                'Sales Order Fixture: Payment method has not been defined. Check fixture yml.'
            );
        }
    }

    protected function _importPaymentData(array $data)
    {
        $this->_getMageModel()->getPayment()->importData(['method' => $data['method']]);
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

    protected function _saveFixture()
    {
        $this->_getMageModel()->save();

        $service = Mage::getModel('sales/service_quote', $this->_getMageModel());
        $service->submitAll();

        $order = $service->getOrder();

        return $order->getId();

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
