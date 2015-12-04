### A Microblogging Platform

### Requirements

- PHP 5.3+
- [Yii's Requiremnts](https://github.com/yiisoft/yii/blob/master/requirements/index.php)
- A Webserver
- MySQL 5.5+
- A Valid Domain Name (domain.tld)
- A Public Facing IP Address (Preferably a Server)
- A SendGrid Account

### Installation

1. Have a web capable server (Apache, Nginx). See [here](http://www.yiiframework.com/doc/guide/1.1/en/quickstart.installation) and [here](http://www.yiiframework.com/doc/guide/1.1/en/quickstart.apache-nginx-config) for how to do that.

[DigitalOcean](https://www.digitalocean.com/community/articles/how-to-install-and-setup-yii-php-framework) has a pretty comprehensive guide for setting up things if you aren't familiar with the process.

2. Download/Clone this project to your web directory, and setup your server so that it can be accessed.

3. Open up a Terminal window to the current working directory.

4. Make sure the following directories are writable by your webserver process

	- protected/runtime
	- assets/

5. Install the database

```
php protected/yiic.php migrate up
```

6. Update protected/config/params.php ```params``` section with your SendGrid credentials

7. Install Composer 

```
curl -sS https://getcomposer.org/installer | php
```

8. Install Composer Dependencies

```
php composer.phar install
```
