<?php
namespace XelaxUserEntity;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
	'doctrine' => [
		'driver' => [
			__NAMESPACE__ . '_driver' => [
				'class' => AnnotationDriver::class, // use AnnotationDriver
				'cache' => 'array',
				'paths' => [__DIR__ . '/../src/Entity'] // entity path
			],
			'orm_default' => [
				'drivers' => [
					__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
				]
			]
		],
	],
	
	// language options
	'translator' => array(
		'translation_file_patterns' => array(
			array(
				'type'     => 'gettext',
				'base_dir' => __DIR__ . '/../../../zf-commons/zfc-user/src/ZfcUser/language',
				'pattern'  => '%s.mo',
			),
		),
	),
];