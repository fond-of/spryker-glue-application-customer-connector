<?php

namespace FondOfSpryker\Glue\GlueApplicationCustomerConnector\Dependency\Client;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\Customer\CustomerClientInterface;

class GlueApplicationCustomerConnectorToCustomerClientBridge implements GlueApplicationCustomerConnectorToCustomerClientInterface
{
    /**
     * @var \Spryker\Client\Customer\CustomerClientInterface
     */
    protected $customerClient;

    /**
     * @param \Spryker\Client\Customer\CustomerClientInterface $customerClient
     */
    public function __construct(CustomerClientInterface $customerClient)
    {
        $this->customerClient = $customerClient;
    }

    /**
     * @param int $idCustomer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomerById(int $idCustomer): CustomerTransfer
    {
        return $this->customerClient->getCustomerById($idCustomer);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function setCustomerRawData(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        return $this->customerClient->setCustomerRawData($customerTransfer);
    }
}
