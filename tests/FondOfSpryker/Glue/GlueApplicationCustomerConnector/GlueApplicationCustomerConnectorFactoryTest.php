<?php

namespace FondOfSpryker\Glue\GlueApplicationCustomerConnector;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\GlueApplicationCustomerConnector\Dependency\Client\GlueApplicationCustomerConnectorToCustomerClientInterface;
use FondOfSpryker\Glue\GlueApplicationCustomerConnector\Processor\Session\SessionCreator;
use Spryker\Glue\Kernel\Container;

class GlueApplicationCustomerConnectorFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\GlueApplicationCustomerConnector\Dependency\Client\GlueApplicationCustomerConnectorToCustomerClientInterface
     */
    protected $customerClientMock;

    /**
     * @var \FondOfSpryker\Glue\GlueApplicationCustomerConnector\GlueApplicationCustomerConnectorFactory
     */
    protected $glueApplicationCustomerConnectorFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerClientMock = $this->getMockBuilder(GlueApplicationCustomerConnectorToCustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->glueApplicationCustomerConnectorFactory = new GlueApplicationCustomerConnectorFactory();
        $this->glueApplicationCustomerConnectorFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateSessionCreator(): void
    {
        $this->containerMock->expects(self::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(self::atLeastOnce())
            ->method('get')
            ->with(GlueApplicationCustomerConnectorDependencyProvider::CLIENT_CUSTOMER)
            ->willReturn($this->customerClientMock);

        self::assertInstanceOf(SessionCreator::class,
            $this->glueApplicationCustomerConnectorFactory->createSessionCreator()
        );
    }
}
