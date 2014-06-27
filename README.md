PacoCorsBundle
========================
This bundle allows to integrate [W3C CORS specification](http://www.w3.org/TR/cors/) inside your [Symfony2](http://symfony.com/) project. It comes really handy if you are coding a REST server app and you have browser clients on different domains that would like to connect to your service endpoints. 

This document contains information on how to download, install, and start
using the PacoCorsBundle inside your Symfony project

1) Installing the Bundle
----------------------------------

As Symfony uses [Composer](http://getcomposer.org/) to manage its dependencies, the recommended way to create a new project is to use it.

### Install PacoCorsBundle


If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then, use the `require` command to add the bundle to your project dependencies:

    php composer.phar require papepapes/pacocorsbundle "dev-master"

### Enable the bundle
Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Paco\Bundle\PacoCorsBundle(),
    );
}
```


2) Configuration
-------------------------------------

Before using the bundle, make sure that you add the proper configuration to  your `app/config/config.yml`:

```yaml
paco_cors:
    #The origin to allow, Set to '*' for a public acccess your service endpoints
    allowed_origin: "*"
    # Coma separated list of HTTP allowed methods
    allowed_methods: "*"
    # Coma separated list of HTTP allowed headers
    allowed_headers: "*"
    # Number of seconds used to cache CORS preflighr OPTIONS requests
    max_age: ~
    # Coma separated list of additional custom headers you want the client browser to have access to
    exposed_headers: ~
```

### That was it!

3) Getting to know more about CORS
--------------------------------

CORS (Cross-Origin-Resource Sharing) is a mean to allow a browser access to a domain it would normally restrict due to Same-Origin policy. 

Here are some links to learn more about Cross Origin Resource Sharing:
- [Cross-Domain Requests with CORS](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Same_origin_policy_for_JavaScript)
- [Using CORS for Cross-Domain Ajax Requests](http://techblog.constantcontact.com/software-development/using-cors-for-cross-domain-ajax-requests/)
- [Contrôle d'accès HTTP](https://developer.mozilla.org/fr/docs/HTTP/Access_control_CORS)


