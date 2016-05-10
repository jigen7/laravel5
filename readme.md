## Laravel PHP Framework 5.1 Custom Jigen 2016-05-10 PMMM

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).
New 5.1 Installation is found here https://laravel.com/docs/5.1/installation

#Custom Features
## Prefilters and Postfilter Installed
 	Location : app/HTTP/Middleware
 	Files : FiltersAfter.php , FiltersBefore.php

## Setup Module Capabilities
	Location : app/Modules
	Files : ModuleServiceProvider.php
	Tutorial : Module Approach https://packagist.org/packages/artem-schander/l5-modular
			   Manual Module Approach http://ziyahanalbeniz.blogspot.com.tr/2015/03/modular-structure-in-laravel-5.html

## Additional Setup Instructions 
Uncompress vendor.zip in parent location 
Install Vendor Files base on composer.json
$composer install / #sudo composer install

Refresh Autoload Config
$composer dump-autoload -o

##Running Localhost with PHP Artisan
$php artisan serve 
 Sample Output **Laravel development server started on http://localhost:8000/
#Exit Artisan Server after server 
MacOS : Command + C 

##More Commands located at http://laravel-recipes.com/categories/

## Sample Command after Setup 
http://localhost:8000/jigen 
http://localhost/laravel2016/public/index.php/jigen

##Homestead Setup for Virtual Setup
https://laravel.com/docs/5.1/homestead

##Tinker Command
$ php artisan tinker
**This command provides a REPL (Read-Eval-Print Loop) for PHP with your application's settings already loaded.
http://laravel-recipes.com/recipes/280/interacting-with-your-application

##Error Fixes
** No supported encrypter found. The cipher and / or key length are invalid.
   Generate Keys By : $php artisan key:generate
