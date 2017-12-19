<?php

namespace Lexik\Bundle\DataLayerBundle\Tests\Collector;

use Lexik\Bundle\DataLayerBundle\Collector\UserIdCollector;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * UserIdCollectorTest
 */
class UserIdCollectorTest extends TestCase
{
    /**
     * test handle method works
     */
    public function testImplementation()
    {
        $data = [];

        $collector = new UserIdCollector($this->getTokenStorageMock());
        $collector->handle($data);

        $this->assertInternalType('array', $data[0]);
        $this->assertArrayHasKey('user_id', $data[0]);
        $this->assertEquals(md5('user'), $data[0]['user_id']);
    }

    /**
     * @return TokenStorageInterface
     */
    private function getTokenStorageMock()
    {
        $userMock = $this
            ->getMockBuilder('Symfony\Component\Security\Core\User\UserInterface')
            ->getMock();

        $userMock
            ->expects($this->any())
            ->method('getUsername')
            ->will($this->returnValue('user'));

        $tokenMock = $this
            ->getMockBuilder('Symfony\Component\Security\Core\Authentication\Token\TokenInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $tokenMock
            ->expects($this->any())
            ->method('getUser')
            ->will($this->returnValue($userMock));

        $tokenStorageMock = $this
            ->getMockBuilder('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage')
            ->disableOriginalConstructor()
            ->getMock();

        $tokenStorageMock
            ->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue($tokenMock));

        return $tokenStorageMock;
    }
}
