<?php
namespace XelaxUserEntity;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\EventManager\EventInterface;

class Module implements ConfigProviderInterface, ServiceProviderInterface, BootstrapListenerInterface
{
	public function onBootstrap(EventInterface $e) {
		if(!$e instanceof MvcEvent){
			return;
		}
		
		$app = $e->getApplication();
		$eventManager = $app->getEventManager();
		$container = $app->getServiceManager();
		
		/* @var $userListener Listener\UserListener */
		$userListener = $container->get(Listener\UserListener::class);
		$userListener->attach($eventManager);
	}

	public function getConfig() {
		return include __DIR__ . '/../config/module.config.php';
	}

	public function getServiceConfig() {
		return [
			'factories' => [
				Options\UserOptions::class => Options\Factory\UserOptionsFactory::class,
				Listener\UserListener::class => Listener\Factory\UserListenerFactory::class,
			],
			'delegators' => [
			],
		];
	}

}