<?php

namespace Magefix\Fixture\Builder\Helper;

use Mage;
use Magefix\Fixture\Builder\Helper;

/**
 * Class EavAttribute
 *
 * @package Magefix\Fixture\Builder\Helper
 * @author  Carlo Tasca <ctasca@sessiondigital.com>
 */
class EavAttribute implements Helper
{
    /**
     * @param $entityType
     * @param $attributeCode
     *
     * @return int|null
     *
     */
    public static function getIdByCode($entityType, $attributeCode)
    {
        return Mage::getModel('eav/entity_attribute')->getIdByCode($entityType, $attributeCode);
    }

    /**
     * @param $entityType
     * @param $attributeCode
     *
     * @return \Mage_Core_Model_Abstract
     *
     */
    public static function getAttributeEntity($entityType, $attributeCode)
    {
        $attributeId = self::getIdByCode($entityType, $attributeCode);

        return Mage::getModel('eav/entity_attribute')->load($attributeId);
    }

    /**
     * @param $entityType
     * @param $attributeCode
     * @param $optionLabel
     *
     * @return mixed
     *
     */
    public static function getOptionValueByLabel($entityType, $attributeCode, $optionLabel)
    {
        $attribute   = self::getAttributeEntity($entityType, $attributeCode);
        $options     = Mage::getModel('eav/entity_attribute_source_table')
            ->setAttribute($attribute)
            ->getAllOptions(false);

        return self::_iterateAllOptions($optionLabel, $options);
    }

    /**
     * @param $optionLabel
     * @param $options
     *
     * @return string
     *
     */
    private static function _iterateAllOptions($optionLabel, $options)
    {
        $optionValue = '';

        foreach ($options as $option) {
            if (isset($option['label']) && $option['label'] != $optionLabel) {
                continue;
            }

            $optionValue = $option['value'];
        }

        return $optionValue;
    }
}
