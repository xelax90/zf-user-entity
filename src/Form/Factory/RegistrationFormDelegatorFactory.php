<?php
namespace XelaxUserEntity\Form\Factory;

use Zend\ServiceManager\Factory\DelegatorFactoryInterface;
use Interop\Container\ContainerInterface;

/**
 * Description of RegistrationFormDelegatorFactory
 *
 * @author schurix
 */
class RegistrationFormDelegatorFactory implements DelegatorFactoryInterface{
	public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null) {
		/* @var $form \ZfcUser\Form\Register */
		$form = $callback();
		
		
		
		return $form;
	}
}
