# FacebookPagesBundle

[![Build Status](https://travis-ci.org/fourlabsldn/FacebookPagesBundle.svg?branch=master)](https://travis-ci.org/fourlabsldn/FacebookPagesBundle)
[![StyleCI](https://styleci.io/repos/72763808/shield?branch=master)](https://styleci.io/repos/72763808)
[![Coverage Status](https://coveralls.io/repos/github/fourlabsldn/FacebookPagesBundle/badge.svg?branch=master)](https://coveralls.io/github/fourlabsldn/FacebookPagesBundle?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a0c965f0-a214-461a-a8d2-aa3ef3089cb0/mini.png)](https://insight.sensiolabs.com/projects/a0c965f0-a214-461a-a8d2-aa3ef3089cb0)

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
    page_manager_class: AppBundle\Entity\FacebookPageManager
    page_class: AppBundle\Entity\FacebookPage
    page_review_class: AppBundle\Entity\FacebookPageReview

    # the following have sensible defaults and can remain unchanged
    page_manager_storage: fl_facebook_pages.storage.doctrine.facebook_user_storage
    page_storage: fl_facebook_pages.storage.doctrine.page_storage
    page_review_storage: fl_facebook_pages.storage.doctrine.page_review_storage
    guzzle_service: guzzle.client.facebook_pages
```

```yaml
# app/config/routing.yml
fl_facebook_pages:
    resource: "@FLFacebookPagesBundle/Resources/config/routing.yml"
```

## Facebook App Settings

Since March 2018 [Facebook enforces strict callback URL matching](https://developers.facebook.com/blog/post/2017/12/18/strict-uri-matching/).
This means that you will have to add the following URL to _Valid OAuth Redirect URIs_ in your Facebook app settings:
`https://yourdomain.com/fl_facebook_pages/save-auth`.

## Tests

To run the test suite, you need [composer](http://getcomposer.org).

```bash
    $ composer install
    $ phpunit
```
## License

FacebookPagesBundle is licensed under the MIT license.

