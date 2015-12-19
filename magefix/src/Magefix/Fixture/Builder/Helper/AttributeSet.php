<?php

namespace Magefix\Fixture\Builder\Helper;
use Mage;
use Magefix\Fixture\Builder\Helper;

class AttributeSet implements Helper
{
    public static function getIdByName($name)
    {
        $id = Mage::getModel('eav/entity_attribute_set')
            ->load($name, 'attribute_set_name')
            ->getAttributeSetId();

        return $id;
    }
}
