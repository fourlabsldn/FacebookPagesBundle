# FacebookPagesBundle

[![Build Status](https://travis-ci.org/fourlabsldn/FacebookPagesBundle.svg?branch=master)](https://travis-ci.org/fourlabsldn/FacebookPagesBundle)
[![StyleCI](https://styleci.io/repos/72763808/shield?branch=master)](https://styleci.io/repos/72763808)
[![Coverage Status](https://coveralls.io/repos/github/fourlabsldn/FacebookPagesBundle/badge.svg?branch=master)](https://coveralls.io/github/fourlabsldn/FacebookPagesBundle?branch=master)

Manage your Facebook Pages in Symfony

## Installation

Composer installation
```bash
    $ composer require fourlabs/facebook-pages-bundle
```

Add to app/config/AppKernel.php
```
<?php
    //...
    $bundles = [
        // ...
        new FL\FacebookPagesBundle\FLFacebookPagesBundle(),
    ];

```

## Configuration

```yaml
# app/config/config.yml
fl_facebook_pages:
    app_id: "%facebook_app_id%"
    app_secret: "%facebook_app_secret%"
    callback_url: "https://example.com/fl_facebook_pages/save-authorization"
    page_manager_class: AppBundle\Entity\FacebookPageManager
    page_class: AppBundle\Entity\FacebookPage
    page_rating_class: AppBundle\Entity\FacebookPageRating
    facebook_user_storage: fl_facebook_pages.storage.doctrine.facebook_user_storage
    page_storage: fl_facebook_pages.storage.doctrine.page_storage
    page_rating_storage: fl_facebook_pages.storage.doctrine.page_rating_storage
    guzzle_service: guzzle.client.facebook_pages
```

```yaml
# app/config/routing.yml
fl_facebook_pages:
    resource: "@FLFacebookPagesBundle/Resources/config/routing.yml"
```

## Tests

To run the test suite, you need [composer](http://getcomposer.org).

```bash
    $ composer install
    $ phpunit
```
## License

FacebookPagesBundle is licensed under the MIT license.

