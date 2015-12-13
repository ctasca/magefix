<?php
/**
 * AttributeSet.php
 */

namespace Magefix\Fixture\Builder\Helper;
use Mage;

class AttributeSet
{
    public static function getIdByName($name)
    {
        $id = Mage::getModel('eav/entity_attribute_set')
            ->load($name, 'attribute_set_name')
            ->getAttributeSetId();

        return $id;
    }
}
