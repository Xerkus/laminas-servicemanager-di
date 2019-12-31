<?php
namespace LaminasTest\Mvc\Service;

use Laminas\ServiceManager\Di\DiAbstractServiceFactory;
use Laminas\ServiceManager\Di\DiAbstractServiceFactoryFactory;
use Laminas\ServiceManager\Di\DiFactory;
use Laminas\ServiceManager\ServiceManager;

class DiAbstractServiceFactoryFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testWillInitializeDiAbstractServiceFactory()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('config', ['di' => ['']]);
        $serviceManager->setFactory('Di', new DiFactory());
        $serviceManager->setFactory(DiAbstractServiceFactoryFactory::class, new DiAbstractServiceFactoryFactory());

        $factory = $serviceManager->get(DiAbstractServiceFactoryFactory::class);
        $this->assertInstanceOf(DiAbstractServiceFactory::class, $factory);
    }

    public function testDiAbstractServiceFactoryIsAddedToAbstractFactoriesOfServiceManager()
    {
        $serviceManager = $this->getMockBuilder(ServiceManager::class)
            ->setMethods(['addAbstractFactory'])
            ->getMock();

        $serviceManager->expects($this->once())->method('addAbstractFactory')->with($this->callback(function ($param) {
            return $param instanceof DiAbstractServiceFactory;
        }));

        $serviceManager->setService('config', ['di' => ['']]);
        $serviceManager->setFactory('Di', new DiFactory());
        $serviceManager->setFactory(DiAbstractServiceFactoryFactory::class, new DiAbstractServiceFactoryFactory());

        $serviceManager->get(DiAbstractServiceFactoryFactory::class);
    }
}
