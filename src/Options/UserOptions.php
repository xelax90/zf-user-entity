<?php
namespace XelaxUserEntity\Options;

use Zend\Stdlib\AbstractOptions;
use XelaxUserEntity\Entity\Role;

/**
 * Description of UserOptions
 *
 * @author schurix
 */
class UserOptions extends AbstractOptions{
	
	/**
	 * RoleId of the default user role
	 * @var string
	 */
	protected $defaultRoleId = 'user';
	
	/**
	 * FQCN of the role entity
	 * @var string
	 */
	protected $roleEntity = Role::class;
	
	function getDefaultRoleId() {
		return $this->defaultRoleId;
	}

	function getRoleEntity() {
		return $this->roleEntity;
	}

	function setDefaultRoleId($defaultRoleId) {
		$this->defaultRoleId = $defaultRoleId;
	}

	function setRoleEntity($roleEntity) {
		$this->roleEntity = $roleEntity;
	}
}
