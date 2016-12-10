<?php
$userConfig = [
	/*
	 * RoleId that is assigned to every new registered user.
	 * See also 'authenticated_role' in bjyAuhorize config
	 */
	// 'default_role_id' => 'user',
	
	/*
	 * Role entity FQCN
	 * See also 'role_providers' in bjyAuthorize config
	 */
	// 'role_entity' => \XelaxUserEntity\Entity\Role::class,
];

$zfcUserConfig = [
	/** set user entity */
	'user_entity_class' => \XelaxUserEntity\Entity\User::class,
	'enable_default_entities' => false,
	
    /** Enable user state usage */
    'enable_user_state' => true,
    
    /** Default user state upon registration */
    'default_user_state' => 1,
    
    /**
     * Allow login to all users that have their laast bit set to 1
	 * Assuming there are only 5 bits storing user information. Adjust the 
	 * number if necessary
     */
	'allowed_login_states' => range(1, pow(2, 5), 2),
	
	/**
	 * Some other useful settings
	 */
	'enable_display_name' => true,
	'enable_registration' => true,
	'login_after_registration' => false,
];

$bjyConfig = array(
	// Using the authentication identity provider, which basically reads the roles from the auth service's identity
	'identity_provider' => \BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider::class,

	'role_providers'        => [
		// using an object repository (entity repository) to load all roles into our ACL
		\BjyAuthorize\Provider\Role\ObjectRepositoryProvider::class => [
			'object_manager'    => \Doctrine\ORM\EntityManager::class,
			'role_entity_class' => \XelaxUserEntity\Entity\Role::class,
		],
	],
);


/* =============================================== *
 * Do not edit below this line                     *
 * =============================================== */

return [
	'xelax-user-entity' => $userConfig,
	'zfcuser' => $zfcUserConfig,
	'bjyauthorize' => $bjyConfig,
];