<?php
namespace XelaxUserEntity\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\Event;

use Doctrine\Common\Persistence\ObjectManager;

use ZfcUser\Service\User as ZfcUserServce;

use XelaxUserEntity\Options\UserOptions;

/**
 * Description of UserListener
 *
 * @author schurix
 */
class UserListener extends AbstractListenerAggregate {
	
	/** @var ObjectManager */
	protected $objectManager;
	
	/** @var UserOptions */
	protected $userOptions;
	
	function __construct(ObjectManager $objectManager, UserOptions $userOptions) {
		$this->objectManager = $objectManager;
		$this->userOptions = $userOptions;
	}

	public function attach(EventManagerInterface $events, $priority = 1) {
		$sharedManager = $events->getSharedManager();
		$this->listeners[] = $sharedManager->attach(ZfcUserServce::class,         'register',          [$this, 'onRegister'],     $priority);
	}
	
	/**
	 * Adds default user role when registered
	 * @param Event $e
	 */
	public function onRegister(Event $e){
		/* @var $user \XelaxUserEntity\Entity\User */
		$user = $e->getParam('user');
		
		$defaultRoleId = $this->userOptions->getDefaultRoleId();
		$roleEntity = $this->userOptions->getRoleEntity();
		$criteria = ['roleId' => $defaultRoleId];
		
		$defaultRole = $this->objectManager->getRepository($roleEntity)->findOneBy($criteria);
		
		if($defaultRole !== null){
			$user->addRole($defaultRole);
		}
	}
	
}
