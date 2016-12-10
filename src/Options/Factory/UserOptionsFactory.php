<?php
namespace XelaxUserEntity\Options\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use XelaxUserEntity\Options\UserOptions;

/**
 * Factory for UserOptions
 * @author schurix
 */
class UserOptionsFactory implements FactoryInterface{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
		$config = $container->get('Config');
		$userConfig = [];
		if(!empty($config['xelax-user-entity'])){
			$userConfig = $config['xelax-user-entity'];
		}
		return new UserOptions($userConfig);
	}
}
