<?php

namespace FondOfSpryker\Glue\GlueApplicationCustomerConnector\Dependency\Client;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\Customer\CustomerClientInterface;

class GlueApplicationCustomerConnectorToCustomerClientBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Customer\CustomerClientInterface
     */
    protected $customerClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var \FondOfSpryker\Glue\GlueApplicationCustomerConnector\Dependency\Client\GlueApplicationCustomerConnectorToCustomerClientBridge
     */
    protected $glueApplicationCustomerConnectorToCustomerClientBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerClientMock = $this->getMockBuilder(CustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->glueApplicationCustomerConnectorToCustomerClientBridge = new GlueApplicationCustomerConnectorToCustomerClientBridge(
            $this->customerClientMock
        );
    }

    /**
     * @return void
     */
    public function testGetCustomerById(): void
    {
        $id = 1;

        $this->customerClientMock->expects(self::atLeastOnce())
            ->method('getCustomerById')
            ->with($id)
            ->willReturn($this->customerTransferMock);

        self::assertEquals(
            $this->customerTransferMock,
            $this->glueApplicationCustomerConnectorToCustomerClientBridge->getCustomerById($id)
        );
    }

    /**
     * @return void
     */
    public function testSetCustomerRawData(): void
    {
        $this->customerClientMock->expects(self::atLeastOnce())
            ->method('setCustomerRawData')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        self::assertEquals(
            $this->customerTransferMock,
            $this->glueApplicationCustomerConnectorToCustomerClientBridge->setCustomerRawData($this->customerTransferMock)
        );
    }
}
