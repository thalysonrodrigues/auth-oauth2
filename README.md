# auth-oauth2

[![GitHub version](https://badge.fury.io/gh/thalysonrodrigues%2Fauth-oauth2.svg)](https://badge.fury.io/gh/thalysonrodrigues%2Fauth-oauth2)
[![Software License](https://img.shields.io/apm/l/vim-mode.svg)](https://github.com/thalysonrodrigues/login-facebook/blob/master/LICENSE)

> This is a simple application built with the [zend-expressive](https://docs.zendframework.com/zend-expressive/) skeleton for Oauth2.0 integration study with [Facebook](https://github.com/thephpleague/oauth2-facebook) and [Google](https://github.com/thephpleague/oauth2-google) providers. In addition, this template provides user registration and login and some integrated psr-15 middlewares like Https, Content-Lenght, Www, Access-Log, Client-ip, for more details see `app/composer.json`.

## Installation

### Download (zip)

Download this [link]()

### Build

Clone this repository
```
$ git clone https://github.com/thalysonrodrigues/auth-oauth2.git
```

## Development

The infrastructure for the development environment uses [Docker CE](https://docs.docker.com/install/) and [Docker Compose](https://docs.docker.com/compose/), the configuration for each container can be seen in `docker-compose.yaml`. The application executes through the following containers:

### Containers

* PHP7.2.5
* Nginx
* Composer
* MongoDB

<p align="center">
  <a href="https://github.com/thalysonrodrigues/containers.png">
    <img src="./docs/containers.png" alt="Application containers" title="Application containers">
  </a>
</p>

## Credits

* Thalyson Alexandre Rodrigues de Sousa
    - [Github](https://github.com/thalysonrodrigues)
    - Email: *tha.motog@gmail.com*

## Licence

The MIT License (MIT). Please see [License File](https://github.com/thalysonrodrigues/login-facebook/blob/master/LICENSE) for more information.