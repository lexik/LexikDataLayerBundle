<?php

namespace Lexik\Bundle\DataLayerBundle\Tests\Twig\Extension;

use Lexik\Bundle\DataLayerBundle\Manager\DataLayerManager;
use Lexik\Bundle\DataLayerBundle\Twig\Extension\DataLayerExtension;

/**
 * DataLayerExtensionTest
 */
class DataLayerExtensionTest extends \PHPUnit_Framework_TestCase
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
     * @return DataLayerManager
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
