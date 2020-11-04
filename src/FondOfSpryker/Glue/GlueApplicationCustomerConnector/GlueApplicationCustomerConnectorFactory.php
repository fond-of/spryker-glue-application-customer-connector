<?php

namespace FondOfSpryker\Glue\GlueApplicationCustomerConnector;

use FondOfSpryker\Glue\GlueApplicationCustomerConnector\Dependency\Client\GlueApplicationCustomerConnectorToCustomerClientInterface;
use FondOfSpryker\Glue\GlueApplicationCustomerConnector\Processor\Session\SessionCreator;
use FondOfSpryker\Glue\GlueApplicationCustomerConnector\Processor\Session\SessionCreatorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class GlueApplicationCustomerConnectorFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Glue\GlueApplicationCustomerConnector\Processor\Session\SessionCreatorInterface
     */
    public function createSessionCreator(): SessionCreatorInterface
    {
        return new SessionCreator(
            $this->getCustomerClient()
        );
    }

    /**
     * @return \FondOfSpryker\Glue\GlueApplicationCustomerConnector\Dependency\Client\GlueApplicationCustomerConnectorToCustomerClientInterface
     */
    protected function getCustomerClient(): GlueApplicationCustomerConnectorToCustomerClientInterface
    {
        return $this->getProvidedDependency(
            GlueApplicationCustomerConnectorDependencyProvider::CLIENT_CUSTOMER
        );
    }
}
