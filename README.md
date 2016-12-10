# User module

This module provides configuration and entities for ZfcUser, DoctrineORM and 
BjyAuthorize. The user entity also implements the LocaleUserInterface required
by xelax90/zf2-language-route.

## Installation

Installation of XelaxUserModule uses composer. For composer documentation, please 
refer to [getcomposer.org](http://getcomposer.org/).

```sh
composer require xelax90/zf-user-module
```

Then add `XelaxLanguageRoute` to your `config/application.config.php` and run 
the doctrine schema update to create the database table:

```sh
php vendor/bin/doctrine-module orm:schema-tool:update --force 
```

Now copy the provided 
`vendor/xelax90/zf-user-module/config/xelax-user-module.global.php` into your
`config/autoload` directory. This file provides the basic configuration for 
ZfcUser, DoctrineORM and BjyAuthorize to work with this module. This file does
not contain all ZfcUser configuration options. Please refer to the ZfcUser
[documentation](https://github.com/ZF-Commons/ZfcUser) or 
[configuration](https://github.com/ZF-Commons/ZfcUser/blob/2.x/config/zfcuser.global.php.dist) 
for more details.



## Configuration

You can configure this module in the `config/autoload/xelax-user-module.global.php`
file. All options are described there.

## Custom user entity

If you want to add attributes to the user entity, you can simply follow these
steps:

1. Create your entity in your namespace and subclass `\XelaxUserEntity\Entity\User`. Don't forget the Doctrine annotations
2. Change `user_entity_class` configuration option in `config/autoload/xelax-user-entity.global.php` to your entity class

