<?php
namespace Data\Providers;

use Mage;
use Magefix\Fixtures\Data\Provider;

/**
 * Class Oauth Consumer
 *
 * Oauth Consumer fixture data provider
 *
 * @package Data\Providers
 * @author  Carlo Tasca <ctasca.d3@gmail.com>
 */
class OauthConsumer implements Provider
{
    private $_helper;

    public function __construct()
    {
        $this->_helper = Mage::helper('oauth');
    }

    public function getName()
    {
        $random = substr(md5(rand()), 0, 7);

        return 'consumer' . $random;
    }

    public function getKey()
    {
        return $this->_helper->generateConsumerKey();
    }

    public function getSecret()
    {
        return $this->_helper->generateConsumerSecret();
    }
}
