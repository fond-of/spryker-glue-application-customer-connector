<?php

namespace FondOfSpryker\Glue\GlueApplicationCustomerConnector\Plugin\GlueApplicationExtension;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\GlueApplicationCustomerConnector\GlueApplicationCustomerConnectorFactory;
use FondOfSpryker\Glue\GlueApplicationCustomerConnector\Processor\Session\SessionCreatorInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class SetCustomerBeforeActionPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\GlueApplicationCustomerConnector\Processor\Session\SessionCreatorInterface
     */
    protected $sessionCreatorMock;


    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\GlueApplicationCustomerConnector\GlueApplicationCustomerConnectorFactory
     */
    protected $glueApplicationCustomerConnectorFactoryMock;

    /**
     * @var \FondOfSpryker\Glue\GlueApplicationCustomerConnector\Plugin\GlueApplicationExtension\SetCustomerBeforeActionPlugin
     */
    protected $setCustomerBeforeActionPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->sessionCreatorMock = $this->getMockBuilder(SessionCreatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->glueApplicationCustomerConnectorFactoryMock = $this->getMockBuilder(GlueApplicationCustomerConnectorFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->setCustomerBeforeActionPlugin = new class (
            $this->glueApplicationCustomerConnectorFactoryMock
        ) extends SetCustomerBeforeActionPlugin {
            /**
             * @var \FondOfSpryker\Glue\GlueApplicationCustomerConnector\GlueApplicationCustomerConnectorFactory
             */
            protected $glueApplicationCustomerConnectorFactory;

            /**
             * @param \FondOfSpryker\Glue\GlueApplicationCustomerConnector\GlueApplicationCustomerConnectorFactory $glueApplicationCustomerConnectorFactory
             */
            public function __construct(GlueApplicationCustomerConnectorFactory $glueApplicationCustomerConnectorFactory)
            {
                $this->glueApplicationCustomerConnectorFactory = $glueApplicationCustomerConnectorFactory;
            }

            /**
             * @return \Spryker\Glue\Kernel\AbstractFactory
             */
            protected function getFactory(): AbstractFactory
            {
                return $this->glueApplicationCustomerConnectorFactory;
            }
        };
    }

    /**
     * @return void
     */
    public function testBeforeAction(): void
    {
        $action = 'action';

        $this->glueApplicationCustomerConnectorFactoryMock->expects(self::atLeastOnce())
            ->method('createSessionCreator')
            ->willReturn($this->sessionCreatorMock);

        $this->sessionCreatorMock->expects(self::atLeastOnce())
            ->method('setCustomer')
            ->with($this->restRequestMock);

        $this->setCustomerBeforeActionPlugin->beforeAction($action, $this->restRequestMock);
    }
}
