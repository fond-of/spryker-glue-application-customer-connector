<?php

namespace FondOfSpryker\Glue\GlueApplicationCustomerConnector\Processor\Session;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\GlueApplicationCustomerConnector\Dependency\Client\GlueApplicationCustomerConnectorToCustomerClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestUserTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class SessionCreatorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\GlueApplicationCustomerConnector\Dependency\Client\GlueApplicationCustomerConnectorToCustomerClientInterface
     */
    protected $customerClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestUserTransfer
     */
    protected $restUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var \FondOfSpryker\Glue\GlueApplicationCustomerConnector\Processor\Session\SessionCreator
     */
    protected $sessionCreator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerClientMock = $this->getMockBuilder(GlueApplicationCustomerConnectorToCustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restUserTransferMock = $this->getMockBuilder(RestUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->sessionCreator = new SessionCreator($this->customerClientMock);
    }

    /**
     * @return void
     */
    public function testSetCustomer(): void
    {
        $idCustomer = '1';
        $customerReference = 'PS-1';

        $this->restRequestMock->expects(self::atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects(self::atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn('1');

        $this->restUserTransferMock->expects(self::atLeastOnce())
            ->method('getNaturalIdentifier')
            ->willReturn($customerReference);

        $this->customerClientMock->expects(self::atLeastOnce())
            ->method('getCustomerById')
            ->with($idCustomer)
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(self::atLeastOnce())
            ->method('setIsDirty')
            ->with(false)
            ->willReturn($this->customerTransferMock);

        $this->customerClientMock->expects(self::atLeastOnce())
            ->method('setCustomerRawData')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->sessionCreator->setCustomer($this->restRequestMock);
    }

    /**
     * @return void
     */
    public function testSetCustomerWithoutId(): void
    {
        $customerReference = 'PS-1';

        $this->restRequestMock->expects(self::atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects(self::atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn(null);

        $this->restUserTransferMock->expects(self::atLeastOnce())
            ->method('getNaturalIdentifier')
            ->willReturn($customerReference);

        $this->customerClientMock->expects(self::never())
            ->method('getCustomerById');

        $this->customerClientMock->expects(self::atLeastOnce())
            ->method('setCustomerRawData')
            ->with(
                $this->callback(
                    static function (CustomerTransfer $customerTransfer) use ($customerReference) {
                        return $customerTransfer->getCustomerReference() === $customerReference
                            && !$customerTransfer->getIsDirty()
                            && $customerTransfer->getIdCustomer() === null;
                    }
                )
            )->willReturn($this->customerTransferMock);

        $this->sessionCreator->setCustomer($this->restRequestMock);
    }

    /**
     * @return void
     */
    public function testSetCustomerWithoutRestUserTransfer(): void
    {
        $this->restRequestMock->expects(self::atLeastOnce())
            ->method('getRestUser')
            ->willReturn(null);

        $this->restUserTransferMock->expects(self::never())
            ->method('getSurrogateIdentifier');

        $this->restUserTransferMock->expects(self::never())
            ->method('getNaturalIdentifier');

        $this->customerClientMock->expects(self::never())
            ->method('getCustomerById');

        $this->customerTransferMock->expects(self::never())
            ->method('setIsDirty');

        $this->customerClientMock->expects(self::never())
            ->method('setCustomerRawData');

        $this->sessionCreator->setCustomer($this->restRequestMock);
    }
}
