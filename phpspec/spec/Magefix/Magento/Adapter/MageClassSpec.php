<?php

namespace spec\Magefix\Magento\Adapter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MageClassSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Magefix\Magento\Adapter\MageClass');
    }

    public function it_returns_the_installed_magento_version()
    {
        $this->getVersion()->shouldBeString();
    }

    public function it_returns_the_magento_version_info_array()
    {
        $dummyInfo = array(
            'major'     => '1',
            'minor'     => '14',
            'revision'  => '2',
            'patch'     => '2',
            'stability' => '',
            'number'    => '',
        );

        $this->getVersionInfo()->shouldBeLike($dummyInfo);
    }

    public function it_returns_the_magento_edition()
    {
        $this->getEdition()->shouldMatch("/Enterprise|Community/");
    }

    public function it_returns_the_catalog_product_model()
    {
        $this->getModel("catalog/product")->shouldHaveType("Mage_Catalog_Model_Product");
    }

    public function it_returns_the_magento_core_helper_object()
    {
        $this->helper("core")->shouldHaveType("Mage_Core_Helper_Data");
    }

    public function it_adds_a_value_to_the_magento_registry()
    {
        $this->register("phpspec_registry_test", 1);
    }

    public function it_retrieves_a_magento_registry_value()
    {
        $this->registry('phpspec_registry_test')->shouldReturn(1);
    }

    public function it_unregister_a_magento_registry_value()
    {
        $this->unregister('phpspec_registry_test');
    }

    public function it_verifies_a_magento_registry_value_was_unregistered()
    {
        $this->registry('phpspec_registry_test')->shouldBeNull();
    }

    public function it_returns_the_magento_installation_base_directory()
    {
        $this->getBaseDir()->shouldMatch("/public/");
    }

    public function it_returns_a_module_directory_given_a_type()
    {
        $this->getModuleDir('etc', 'Mage_Core')->shouldMatch("#app/code/core/Mage/Core/etc#");
    }

    public function it_returns_a_store_configuration_value_given_its_path()
    {
        $this->getStoreConfig('web/general/unsecure_base_url')->shouldReturn("abc");
    }
}
