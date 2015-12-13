<?php

namespace Magefix\Fixture\Builder;

use Mage;
use Magefix\Exceptions\UndefinedAttributes;

/**
 * Class Customer
 *
 * @package Magefix\Fixture\Builder
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class Customer extends AbstractBuilder
{
    /**
     * @return int
     * @throws \Exception
     *
     */
    public function build()
    {
        $defaultData = $this->_getMageModelData() ? $this->_getMageModelData() : [];
        $fixtureData = $this->_getFixtureAttributes();
        $mergedData  = array_merge($defaultData, $fixtureData);

        $this->_getMageModel()->setData($mergedData);

        $customerId = $this->_saveFixture();

        if ($customerId && $this->_doesCustomerHaveDefaultAddress()) {
            $this->_saveCustomerAddress($customerId, $this->_getDefaultAddressData());
        }

        return $customerId;
    }

    /**
     * @return bool
     */
    protected function _doesCustomerHaveDefaultAddress()
    {
        $haveAddress = false;

        if (isset($this->_data['fixture']['address']['default'])) {
            $haveAddress = true;
        }

        return $haveAddress;
    }

    /**
     * @param       $customerId
     * @param array $addressData
     *
     * @throws \Exception
     */
    protected function _saveCustomerAddress($customerId, array $addressData)
    {
        $customerAddress = $this->_getAddressModel();
        $addressData     = $this->_processFixtureAttributes($addressData);
        $customerAddress
            ->setData($addressData)
            ->setCustomerId($customerId);
        $customerAddress->save();
    }

    /**
     * @return false|\Mage_Core_Model_Abstract
     * @throws UndefinedAttributes exception
     */
    protected function _getAddressModel()
    {
        if (!isset($this->_data['fixture']['address']['model'])) {
            throw new UndefinedAttributes('Customer fixture address model has not been defined. Check fixture yml file.');
        }

        return Mage::getModel($this->_data['fixture']['address']['model']);
    }

    /**
     * @return array
     */
    protected function _getDefaultAddressData()
    {
        return $this->_data['fixture']['address']['default'];
    }
}
