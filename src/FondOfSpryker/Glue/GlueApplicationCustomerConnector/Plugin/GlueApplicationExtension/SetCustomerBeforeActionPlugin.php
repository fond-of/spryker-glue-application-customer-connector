<?php

namespace FondOfSpryker\Glue\GlueApplicationCustomerConnector\Plugin\GlueApplicationExtension;

use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ControllerBeforeActionPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfSpryker\Glue\GlueApplicationCustomerConnector\GlueApplicationCustomerConnectorFactory getFactory()
 */
class SetCustomerBeforeActionPlugin extends AbstractPlugin implements ControllerBeforeActionPluginInterface
{
    /**
     * @param string $action
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return void
     */
    public function beforeAction(string $action, RestRequestInterface $restRequest): void
    {
        $this->getFactory()
            ->createSessionCreator()
            ->setCustomer($restRequest);
    }
}
