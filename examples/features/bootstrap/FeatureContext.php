<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\SnippetAcceptingContext;
use MageTest\MagentoExtension\Context\MagentoContext;
use Behat\Behat\Context\Context;
use Magefix\Fixtures\Registry as FixturesRegistry;
use Magefix\Fixture\Factory\Builder as FixtureBuilder;
use Magefix\Fixture\Builder\Helper\Checkout as MagentoCheckoutHelper;
use Magefix\Fixture\Builder\Helper\ShippingMethod as MagentoShippingHelper;
use Magento\Page\Homepage;
/**
 * Default features context.
 */
class FeatureContext extends MagentoContext implements Context, SnippetAcceptingContext
{
    use FixturesRegistry;

    private $_homepage;

    /**
     * @BeforeFeature
     */
    public static function setup()
    {
        MagentoCheckoutHelper::enablePaymentMethod('checkmo');
        MagentoShippingHelper::enable('freeshipping');
    }
    
    public function __construct(Homepage $homepage)
    {
        $this->_homepage = $homepage;
    }

    /**
     * @Given I setup a product fixture
     */
    public function iSetupAProductFixture()
    {
        $this->_buildProductFixture();
    }


    /**
     * @Given I setup a customer fixture
     */
    public function iSetupACustomerFixture()
    {
        $this->_buildCustomerFixture();
    }


    /**
     * @Given I setup a customer fixture with address
     */
    public function iSetupACustomerWithAddress()
    {
        $this->_buildCustomerWithAddressFixture();
    }

    /**
     * @Given I setup a product fixture with media
     */
    public function iSetupAProductWithMedia()
    {
        $this->_buildProductWithMediaFixture();
    }

    /**
     * @Given I setup a category fixture
     */
    public function iSetupACategoryFixture()
    {
        $this->_buildCategoryFixture();
    }


    /**
     * @Given I setup a configurable product fixture
     */
    public function iSetupAConfigurableProductFixture()
    {
        $this->_buildConfigurableProductFixture();
    }

    /**
     * @Given I setup a bundle product fixture
     */
    public function iSetupABundleProductFixture()
    {
        $this->_buildBundleProductFixture();
    }


    /**
     * @Given I setup a guest sales order fixture
     */
    public function iSetupAGuestSalesOrderFixture()
    {
        $this->_buildGuestSalesOrderFixture();
    }

    public function beforeScenario()
    {
        $this->_buildRegisterSalesOrderFixture();
    }

    /**
     * @Given I setup a register sales order fixture
     */
    public function iSetupARegisterSalesOrderFixture()
    {
        $this->_buildRegisterSalesOrderFixture();
    }

    /**
     * @Given I setup a customer sales order fixture
     */
    public function iSetupACustomerSalesOrderFixture()
    {
        $this->_buildCustomerSalesOrderFixture();
    }

    /**
     * @Given I setup an api user fixture
     */
    public function iSetupAnApiUserFixture()
    {
        $this->_buildApiUserFixture();
    }

    /**
     * @Given I setup a grouped product fixture
     */
    public function iSetupAGroupedProductFixture()
    {
        $this->_buildGroupedProductFixture();
    }

    /**
     * @Given I setup an admin fixture
     */
    public function iSetupAnAdminFixture()
    {
        $this->_buildAdminFixture();
    }

    /**
     * @Given I setup an oauth consumer fixture
     */
    public function iSetupAnOauthConsumerFixture()
    {
         $this->_buildOauthConsumerFixture();
    }


    /**
     * @Given I setup an admin fixture with role ids
     */
    public function iSetupAnAdminFixtureWithRoleIds()
    {
        $this->_buildAdminWithRoleIdsFixture();
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildProductFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::SIMPLE_PRODUCT_FIXTURE_TYPE, new FixturesLocator(), 'simple-product.yml', '@AfterFeature'
        );
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildProductWithMediaFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::SIMPLE_PRODUCT_FIXTURE_TYPE, new FixturesLocator(), 'simple-product-with-media.yml',
            '@AfterScenario'
        );
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildProductStepFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::SIMPLE_PRODUCT_FIXTURE_TYPE, new FixturesLocator(), new SimpleProduct(),
            'simple-product.yml',
            '@AfterStep'
        );
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildCustomerFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::CUSTOMER_FIXTURE_TYPE, new FixturesLocator(), 'customer.yml', '@AfterFeature'
        );
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildCustomerWithAddressFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::CUSTOMER_FIXTURE_TYPE, new FixturesLocator(), 'customer-with-address.yml', '@AfterFeature'
        );
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildCategoryFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::CATEGORY_FIXTURE_TYPE, new FixturesLocator(), 'category.yml', '@AfterFeature'
        );
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildConfigurableProductFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::CONFIGURABLE_PRODUCT_FIXTURE_TYPE, new FixturesLocator(), 'configurable-product.yml',
            '@AfterFeature'
        );
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildBundleProductFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::BUNDLE_PRODUCT_FIXTURE_TYPE, new FixturesLocator(), 'bundle-product.yml', '@AfterFeature'
        );
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildGuestSalesOrderFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::SALES_ORDER_FIXTURE_TYPE, new FixturesLocator(), 'sales-order-guest.yml', '@AfterFeature'
        );
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildRegisterSalesOrderFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::SALES_ORDER_FIXTURE_TYPE, new FixturesLocator(), 'sales-order-register.yml',
            '@AfterScenario'
        );
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildCustomerSalesOrderFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::SALES_ORDER_FIXTURE_TYPE, new FixturesLocator(), 'sales-order-customer.yml', '@AfterSuite'
        );
    }


    /**
     *
     * @throws Exception
     */
    protected function _buildApiUserFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::API_USER_FIXTURE_TYPE, new FixturesLocator(), 'api-user.yml', '@AfterSuite'
        );
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildGroupedProductFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::GROUPED_PRODUCT_FIXTURE_TYPE, new FixturesLocator(), 'grouped-product.yml', '@AfterScenario'
        );
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildAdminFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::ADMIN_FIXTURE_TYPE, new FixturesLocator(), 'admin.yml', '@AfterScenario'
        );
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildAdminWithRoleIdsFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::ADMIN_FIXTURE_TYPE, new FixturesLocator(), 'admin-with-role-ids.yml', '@AfterSuite'
        );
    }

    /**
     *
     * @throws Exception
     */
    protected function _buildOauthConsumerFixture()
    {
        FixtureBuilder::build(
            FixtureBuilder::OAUTH_CONSUMER_FIXTURE_TYPE, new FixturesLocator(), 'oauth-consumer.yml', '@AfterSuite'
        );
    }
}
