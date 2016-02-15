LexikDataLayerBundle
====================

[![Build Status](https://travis-ci.org/lexik/LexikDataLayerBundle.svg?branch=master)](https://travis-ci.org/lexik/LexikDataLayerBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lexik/LexikDataLayerBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lexik/LexikDataLayerBundle/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/4d91d8a5-3a7f-423b-9c6f-5c161246a891/mini.png)](https://insight.sensiolabs.com/projects/4d91d8a5-3a7f-423b-9c6f-5c161246a891)

Manipulate the Google Tag Manager Data Layer from your Symfony application. This bundle is compatible Symfony 2.7+ to 3.0+ and PHP 5.4+ to 7.0+.

Installation
------------

Add [`lexik/data-layer-bundle`](https://packagist.org/packages/lexik/data-layer-bundle)
to your `composer.json` file:

    composer require "lexik/data-layer-bundle"

Register the bundle in `app/AppKernel.php`:

``` php
public function registerBundles()
{
    return array(
        // ...
        new Lexik\Bundle\DataLayerBundle\LexikDataLayerBundle(),
    );
}
```

Adding informations to the Data Layer
-------------------------------------

To pass informations to the Data Layer use the `add()` method of the `lexik_data_layer.manager.data_layer_manager` service.

#### Event / Session Data

##### Use case

Notify an application event that could be used as goal or conversion like a user registration.

##### Usage

Simply get the service `lexik_data_layer.manager` and pass an associative array to it's add method, it will be stored in session
until it is passed to a page... Much like a Flash Message. Using sessions as storage allows you to notify of an event even after a redirect for example.

Example usage from an EventListener to notify a user registration :

```php
<?php

namespace AppBundle\Listener;

use Lexik\Bundle\DataLayerBundle\Manager\DataLayerManager;

/**
 * UserEventListener
 */
class UserEventListener
{
    /**
     * @var DataLayerManager
     */
    protected $manager;

    /**
     * @param DataLayerManager $manager
     */
    public function __construct(DataLayerManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * onUserRegistration
     */
    public function onUserRegistration()
    {
        $this->manager->add(['registration' => true]);
    }
}
```

```xml
<service id="app.listener.user_event_listener" class="AppBundle\Listener\UserEventListener">
    <argument type="service" id="lexik_data_layer.manager.data_layer_manager" />
    <tag name="kernel.event_listener" event="fos_user.registration.completed" method="onUserRegistration" />
</service>
```

#### Default Data

##### Use case

Set the user id on every page for example.

##### Usage example

Simply create a service implementing the `Lexik\Bundle\DataLayerBundle\Collector\CollectorInterface` and tag it using the `lexik_data_layer.collector` tag.
It's `handle` method will be passed the current Data Layer array, which you can modify by adding or modifying its values.

```php
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
```

```xml
<service id="lexik_data_layer.collector.user_id" class="Lexik\Bundle\DataLayerBundle\Collector\UserIdCollector">
    <argument type="service" id="security.token_storage" />
    <tag name="lexik_data_layer.collector" />
</service>
```

## Adding / Writing Data Layer variables to the page

Use the provided `lexik_data_layer()` twig function to write the Data Layer variables to a page template. 
This will automatically reset the Data Layer informations stored in session. 
Don't forget to use it BEFORE you insert the Tag Manager tag.

```twig
<body>
  <script>
    var dataLayer = {{ lexik_data_layer() }};
  </script>
  <!-- Google Tag Manager -->
  ...
  <!-- End Google Tag Manager -->
```

Testing
-------

Setup the test suite using [Composer](http://getcomposer.org/):

    $ composer install

Run it using PHPUnit:

    $ vendor/bin/phpunit

Contributing
------------

See [CONTRIBUTING](CONTRIBUTING.md) file.

Credits
-------

* Nicolas Cabot <n.cabot@lexik.fr>
* Lexik <dev@lexik.fr>
* [All contributors](https://github.com/lexik/LexikDataLayerBundle/graphs/contributors)

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE
