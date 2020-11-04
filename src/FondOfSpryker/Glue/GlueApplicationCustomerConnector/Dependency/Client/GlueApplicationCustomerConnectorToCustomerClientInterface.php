<?php

namespace FondOfSpryker\Glue\GlueApplicationCustomerConnector\Dependency\Client;

use Generated\Shared\Transfer\CustomerTransfer;

interface GlueApplicationCustomerConnectorToCustomerClientInterface
{
    /**
     * @param int $idCustomer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomerById(int $idCustomer): CustomerTransfer;

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function setCustomerRawData(CustomerTransfer $customerTransfer): CustomerTransfer;
}
