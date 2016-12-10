<?php
namespace XelaxUserEntity\Listener\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use XelaxUserEntity\Options\UserOptions;
use Doctrine\ORM\EntityManager;
use XelaxUserEntity\Listener\UserListener;

/**
 * Creates UserListener instance
 *
 * @author schurix
 */
class UserListenerFactory implements FactoryInterface{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
		$userOptions = $container->get(UserOptions::class);
		$em = $container->get(EntityManager::class);
		
		return new UserListener($em, $userOptions);
	}
}
