<?php

namespace Lexik\Bundle\DataLayerBundle\Tests\Twig\Extension;

use Lexik\Bundle\DataLayerBundle\Manager\DataLayerManager;
use Lexik\Bundle\DataLayerBundle\Twig\Extension\DataLayerExtension;
use PHPUnit\Framework\TestCase;

/**
 * DataLayerExtensionTest
 */
class DataLayerExtensionTest extends TestCase
{
    /**
     * test main twig function
     */
    public function testGetDataLayer()
    {
        $extension = new DataLayerExtension($this->getManagerMock());
        $this->assertEquals(json_encode([]), $extension->getDataLayer());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|DataLayerManager
     */
    private function getManagerMock()
    {
        $managerMock = $this
            ->getMockBuilder('Lexik\Bundle\DataLayerBundle\Manager\DataLayerManager')
            ->disableOriginalConstructor()
            ->getMock();

        $managerMock
            ->expects($this->once())
            ->method('all')
            ->will($this->returnValue([]));

        return $managerMock;
    }
}
