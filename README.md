> <h1 align="center">Xetaravel</h1>
> <p align="center">
>   <img src="https://cloud.githubusercontent.com/assets/8210023/25557958/0e505c62-2d1d-11e7-8d19-86b569ee9874.png" alt="Xeta Logo" height="80"/>
> </p>
>
> |Travis|Coverage|Scrutinizer|Stable Version|Downloads|Laravel|License|
> |:------:|:-------:|:------:|:-------:|:------:|:-------:|:-------:|
> |[![Build Status](https://img.shields.io/travis/XetaIO/Xetaravel.svg?style=flat-square)](https://travis-ci.org/XetaIO/Xetaravel)|[![Coverage Status](https://img.shields.io/coveralls/XetaIO/Xetaravel/master.svg?style=flat-square)](https://coveralls.io/r/XetaIO/Xetaravel)|[![Scrutinizer](https://img.shields.io/scrutinizer/g/XetaIO/Xetaravel.svg?style=flat-square)](https://scrutinizer-ci.com/g/XetaIO/Xetaravel)|[![Latest Stable Version](https://img.shields.io/packagist/v/XetaIO/Xetaravel.svg?style=flat-square)](https://packagist.org/packages/xetaio/xetaravel)|[![Total Downloads](https://img.shields.io/packagist/dt/xetaio/xetaravel.svg?style=flat-square)](https://packagist.org/packages/xetaio/xetaravel)|[![Laravel 5.4](https://img.shields.io/badge/Laravel-5.4-f4645f.svg?style=flat-square)](http://laravel.com)|[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/XetaIO/Xetaravel/blob/master/LICENSE)|
>
> This is a light version of the [Xeta](https://github.com/XetaIO/Xeta) website made with Laravel.Actually, I have developed this blog to try Laravel, and I have decided to release it to help people starting with Laravel, so there is probably some custom configurations/functions that only fit my needs.
>
> ## Demo
> [xetaravel.xeta.io](https://xetaravel.xeta.io)
>
> ## Administration Preview
> ![Admin](https://cloud.githubusercontent.com/assets/8210023/25923017/d958c432-35db-11e7-8306-92fc3406aed8.png)
>
> # Installation
> ## Requirements
>
> |PHP|PHP Extension|DBMS|NodeJS|npm|Others (optional)
> |---|---|---|---|---|---|
> |![PHP](https://img.shields.io/badge/PHP->=7.0-0e7fbf.svg?style=flat-square)|![CURL](https://img.shields.io/badge/PHP%20ext-CURL-44CB12.svg?style=flat-square)<br>![OpenSSL](https://img.shields.io/badge/PHP%20ext-OpenSSL-44CB12.svg?style=flat-square)<br>![PDO](https://img.shields.io/badge/PHP%20ext-PDO-44CB12.svg?style=flat-square)<br>![Mbstring](https://img.shields.io/badge/PHP%20ext-Mbstring-44CB12.svg?style=flat-square)<br>![Tokenizer](https://img.shields.io/badge/PHP%20ext-Tokenizer-44CB12.svg?style=flat-square)<br>![XML](https://img.shields.io/badge/PHP%20ext-XML-44CB12.svg?style=flat-square)<br>![GD](https://img.shields.io/badge/PHP%20ext-GD-44CB12.svg?style=flat-square)|![MySQL](https://img.shields.io/badge/MySQL->=5.5-44CB12.svg?style=flat-square)|![NodeJS](https://img.shields.io/badge/NodeJS->=4-44CB12.svg?style=flat-square)|![npm](https://img.shields.io/badge/npm-*-44CB12.svg?style=flat-square)|![Analytics](https://img.shields.io/badge/Google-Analytics-44CB12.svg?style=flat-square)<br>![Redis](https://img.shields.io/badge/Redis-Server-44CB12.svg?style=flat-square)<br>![Redis](https://img.shields.io/badge/Redis-PHPRedis-44CB12.svg?style=flat-square)
>
> ## Install
> While Redis is optional, it is recommended to use Redis with this application.
> ```bash
> composer create-project xetaio/xetaravel <application_name>
> ```
> Then you will need to migrate and seed your application:
> ```bash
> php artisan migrate
> php artisan db:seed
> ```
>
> ### Pre-installed Accounts
> * **Admin**
>   * User : **admin@xeta.io**
>   * Password : **admin**
> * **Editor**
>   * User : **editor@xeta.io**
>   * Password : **editor**
> * **Member**
>   * User : **member@xeta.io**
>   * Password : **member**
> * **Banished**
>   * User : **banished@xeta.io**
>   * Password : **banished**
>   * **Note** : You will need to delete the cookie to logout due to the restriction of the ban system.
>
> # Contribute
> If you want to contribute, please [follow this guide](https://github.com/XetaIO/Xetaravel/blob/master/.github/CONTRIBUTING.md).
