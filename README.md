# html-tag-browser

A fun web app that allows you to browse all of the tags on an HTML web page.

## Technology

html-tag-browser has been built using the following projects:

* [Composer](https://getcomposer.org/)
* [Slim PHP Framework](http://www.slimframework.com/)
* [Twig](http://twig.sensiolabs.org/)
* [Guzzle](http://docs.guzzlephp.org/en/latest/)
* [jQuery](http://jquery.com/)
* [Bootstrap](http://getbootstrap.com/)

## Installation

Simply run the following commands from your console to install html-tag-browser:

    git clone https://github.com/madmx5/html-tag-browser.git
    cd html-tag-browser/
    composer install

## Running the App

You can use the built in PHP web server (not suitable for production) to try out the html-tag-browser on your computer by running:

    php -S 0.0.0.0:8888 -t public public/index.php

Then point your favorite web browser to [http://localhost:8888/](http://localhost:8888/)

## Future Enhancements

html-tag-browser is a work in progress, I would like to add the following features:

* Caching and rate limiting for PHP backend to prevent Denial of Service attacks
* Full HTML source syntax highlighting including tag elements
* Implement tag highlighting using webworkers to offload browser load when displaying larger HTML sources
* Add HTML source tidy service
