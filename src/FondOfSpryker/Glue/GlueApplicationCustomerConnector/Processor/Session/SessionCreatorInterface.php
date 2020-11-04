<?php

namespace FondOfSpryker\Glue\GlueApplicationCustomerConnector\Processor\Session;

use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface SessionCreatorInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return void
     */
    public function setCustomer(RestRequestInterface $restRequest): void;
}
