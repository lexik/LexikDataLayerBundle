<?php

namespace Lexik\Bundle\DataLayerBundle\Collector;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * UserIdCollector
 */
class UserIdCollector implements CollectorInterface
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(&$data)
    {
        $token = $this->tokenStorage->getToken();

        if ($token->getUser() && $token->getUser() instanceof UserInterface) {
            $data[] = ['user_id' => md5($token->getUser()->getUsername())];
        }
    }
}
