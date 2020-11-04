<?php

namespace FondOfSpryker\Glue\GlueApplicationCustomerConnector\Processor\Session;

use FondOfSpryker\Glue\GlueApplicationCustomerConnector\Dependency\Client\GlueApplicationCustomerConnectorToCustomerClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class SessionCreator implements SessionCreatorInterface
{
    /**
     * @var \FondOfSpryker\Glue\GlueApplicationCustomerConnector\Dependency\Client\GlueApplicationCustomerConnectorToCustomerClientInterface
     */
    protected $customerClient;

    /**
     * @param \FondOfSpryker\Glue\GlueApplicationCustomerConnector\Dependency\Client\GlueApplicationCustomerConnectorToCustomerClientInterface $customerClient
     */
    public function __construct(GlueApplicationCustomerConnectorToCustomerClientInterface $customerClient)
    {
        $this->customerClient = $customerClient;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return void
     */
    public function setCustomer(RestRequestInterface $restRequest): void
    {
        $restUserTransfer = $restRequest->getRestUser();

        if ($restUserTransfer === null) {
            return;
        }

        $customerTransfer = (new CustomerTransfer())
            ->setIdCustomer($restUserTransfer->getSurrogateIdentifier() ? (int)$restUserTransfer->getSurrogateIdentifier() : null)
            ->setCustomerReference($restUserTransfer->getNaturalIdentifier());

        if ($customerTransfer->getIdCustomer() !== null) {
            $customerTransfer = $this->customerClient->getCustomerById($customerTransfer->getIdCustomer());
        }

        $customerTransfer->setIsDirty(false);

        $this->customerClient
            ->setCustomerRawData($customerTransfer);
    }
}
