# Arc Touch Drupal Challenge

This project was built with [Drupal Composer](https://github.com/drupal-composer/drupal-project).

## Usage
First, make sure you have the following tools locally instaled:

[Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx),
[GNU Make](https://www.gnu.org/software/make/) and [NPM](https://www.npmjs.com/get-npm)

> Note: set up your server as you wish. I'm running this project on Ubuntu 18.04, with Apache and Mysql.

Once you have cloned the project and finished the server configuration, go to `arc_touch_rspv/web/sites/default/settings.php` and paste the following code:

> Note: remember to put the right credentials based on your local setup.

```php
$databases['default']['default'] = array (
  'database' => 'your_database',
  'username' => 'your_user',
  'password' => 'your_pass',
  'prefix' => '',
  'host' => 'localhost',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);
```
After that, on the root directory, run the following commands:

```
make drupal && make-theme
```

If everything goes right, you'll be able to access the homepage on your configured url.

The `Makefile` updates the password for the user "admin", so you can easily access the administration area.

## Project structure



### Live demo:
You can access a live demo [here](http://arctouch-drupal.ericvinicius.com.br)
