<?php

namespace FondOfSpryker\Glue\GlueApplicationCustomerConnector;

use FondOfSpryker\Glue\GlueApplicationCustomerConnector\Dependency\Client\GlueApplicationCustomerConnectorToCustomerClientBridge;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class GlueApplicationCustomerConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addCustomerClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCustomerClient(Container $container): Container
    {
        $container[static::CLIENT_CUSTOMER] = static function(Container $container) {
            return new GlueApplicationCustomerConnectorToCustomerClientBridge(
                $container->getLocator()->customer()->client()
            );
        };

        return $container;
    }
}
