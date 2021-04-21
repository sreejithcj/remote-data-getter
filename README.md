# Remote Data Getter

* Plugin Name: Remote Data Getter
* Version:     1.0.0
* Author:      Ruslan Ismailov
* License:     MIT

## Table Of Contents

* [About](#about)
* [Installation](#installation)
* [Usage](#usage)
* [Notes](#notes)
* [License](#license)

## About

This plugin retrieves data from external API and displays it to public and admin. Caches the retrieved data for 12 hours and admin user can purge the cache data.

## Installation

How to install Job Task plugin:

* Copy the folder to `/wp-content/plugins/` directory.
* Run `composer install`
* Activate the plugin 'Remote Data Getter' through the 'Plugins' menu in WordPress.

## Usage

* Add the shortcode [remote-data] to page to view the data received from https://dummy.restapiexample.com/api/v1/employees/. 

* Access the 'Manage Remote Data' page by clicking 'Manage Remote Data' menu item present under Tools menu from Admin panel to: 
    * To view the data received from remote endpoint.
    * Purge the cached data.

## Notes

* Plugin is tested on WordPress version 5.5.1 and PHP version 7.4.5.
* There are no production level dependencies.
* API response data are cached in WordPress using Transients. API is invoked only if the data is not available in the cache.
* Page styling is not done.
* External API returns status code 429 intermittently.
* For ajax calls, I am using REST API endpoint as it is faster than admin-ajax. 
* I have used wp-util template for generating the html for the public facing page.
* In REST API, I have implemented Basic authorization.
* As per the requirement, I have not used ajax in admin page.
* I have not implemented data loader animation and pagination.

## License

Copyright (c) 2020 Ruslan Ismailov

This plugin is free for everyone! Since it's released under the [MIT License](LICENSE) you can use it free of charge on your personal or commercial website.