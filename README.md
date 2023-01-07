
> <p align="center">
>   <img src="https://user-images.githubusercontent.com/8210023/166291618-ee2e2cca-3501-4f29-892f-de946e927f0f.png" alt="Xeta Logo" height="230"/>
> </p>
>
>
> |Unit Tests|Coverage|Scrutinizer|Stable Version|Downloads|Laravel|License|
> |:------:|:-------:|:------:|:-------:|:------:|:-------:|:-------:|
> |[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/XetaIO/Xetaravel/tests.yml?style=flat-square)](https://github.com/XetaIO/Xetaravel/actions/workflows/tests.yml)|[![Coverage Status](https://img.shields.io/codecov/c/github/XetaIO/Xetaravel?style=flat-square)](https://app.codecov.io/gh/XetaIO/Xetaravel)|[![Scrutinizer](https://img.shields.io/scrutinizer/g/XetaIO/Xetaravel.svg?style=flat-square)](https://scrutinizer-ci.com/g/XetaIO/Xetaravel)|[![Latest Stable Version](https://img.shields.io/packagist/v/XetaIO/Xetaravel.svg?style=flat-square)](https://packagist.org/packages/xetaio/xetaravel)|[![Total Downloads](https://img.shields.io/packagist/dt/xetaio/xetaravel.svg?style=flat-square)](https://packagist.org/packages/xetaio/xetaravel)|[![Laravel 9.0](https://img.shields.io/badge/Laravel-9.0-f4645f.svg?style=flat-square)](http://laravel.com)|[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/XetaIO/Xetaravel/blob/master/LICENSE)|
>
> Xetaravel is a resource to help people starting with Laravel.
>
> Actually, I have developed this blog to try Laravel, and I have decided to release it to help people starting with Laravel, so there is probably some custom configurations/functions that only fit my needs.
>
> ## Demo
> Note : All installed accounts won't work on the demo site, you will need to create a new one. (Sadly, we can't trust internet people :frowning_face:)
>
> [xetaravel.com](https://xetaravel.com)
>
> ## Administration Preview
> ![Admin](https://cloud.githubusercontent.com/assets/8210023/25923017/d958c432-35db-11e7-8306-92fc3406aed8.png)
>
> ## Discuss Preview
> ![Discuss](https://user-images.githubusercontent.com/8210023/159991685-d2b53d9f-7d55-4cf5-b0c7-6066cee5572a.png)
>
> # Installation
> ## Requirements
>
> |PHP|PHP Extension|DBMS|NodeJS|npm|Others (optional)
> |---|---|---|---|---|---|
> |![PHP](https://img.shields.io/badge/PHP->=8.0.2-0e7fbf.svg?style=flat-square)|![OpenSSL](https://img.shields.io/badge/PHP%20ext-OpenSSL-44CB12.svg?style=flat-square)<br>![PDO](https://img.shields.io/badge/PHP%20ext-PDO-44CB12.svg?style=flat-square)<br>![Mbstring](https://img.shields.io/badge/PHP%20ext-Mbstring-44CB12.svg?style=flat-square)<br>![Tokenizer](https://img.shields.io/badge/PHP%20ext-Tokenizer-44CB12.svg?style=flat-square)<br>![XML](https://img.shields.io/badge/PHP%20ext-XML-44CB12.svg?style=flat-square)<br>![Ctype](https://img.shields.io/badge/PHP%20ext-Ctype-44CB12.svg?style=flat-square)<br>![JSON](https://img.shields.io/badge/PHP%20ext-JSON-44CB12.svg?style=flat-square)<br>![GD](https://img.shields.io/badge/PHP%20ext-GD-44CB12.svg?style=flat-square)<br>![CURL](https://img.shields.io/badge/PHP%20ext-CURL-44CB12.svg?style=flat-square)|![MySQL](https://img.shields.io/badge/MySQL->=8.0-44CB12.svg?style=flat-square)|![NodeJS](https://img.shields.io/badge/NodeJS->=8-44CB12.svg?style=flat-square)|![npm](https://img.shields.io/badge/npm->=5.6-44CB12.svg?style=flat-square)|![Analytics](https://img.shields.io/badge/Google-Analytics-44CB12.svg?style=flat-square)<br>![Redis](https://img.shields.io/badge/Redis-Server-44CB12.svg?style=flat-square)<br>![Redis](https://img.shields.io/badge/Redis-PHPRedis-44CB12.svg?style=flat-square)
>
> ## Install
> While Redis is optional, it is **recommended** to use Redis with this application.
> ```bash
> composer create-project xetaio/xetaravel <application_name>
> ```
> Then you will need to migrate and seed your application:
> ```bash
> php artisan migrate
> php artisan db:seed
> ```
> Finally, you need to install and build the JS, CSS etc :
> ```bash
> php artisan vendor:publish --provider="Xetaio\Editor\EditorServiceProvider"
> npm run install
> npm run production
> ```
>
>
> ### Pre-installed Accounts
> * **Admin**
>   * User : **admin@xetaravel.io**
>   * Password : **admin**
> * **Moderator**
>   * User : **Moderator@xetaravel.io**
>   * Password : **moderator**
> * **Member**
>   * User : **member@xetaravel.io**
>   * Password : **member**
> * **Banished**
>   * User : **banished@xetaravel.io**
>   * Password : **banished**
>   * **Note** : You will need to delete the cookie to logout due to the restriction of the ban system.
>
> # Features
> This project implements many features and will implements more in the future. Here's a list of the features developed in Xetaravel :
>
> * ###### Blog
>     * Categories
>     * Comments
>
> * ###### Discuss
>     * Categories
>     * Replies
>     * Leaderboard
>     * Solved Reply
>     * Actions Logs
>     * Pinned/Locked
>
> * ###### Admin Panel
>     * Google Analytics integrated
>     * Users Management
>     * Blog Management
>         * Categories
>         * Articles
>     * Discuss Management
>         * Categories
>     * Roles Management
>     * Permissions Management
>
> # Contribute
> If you want to contribute, please [follow this guide](https://github.com/XetaIO/Xetaravel/blob/master/.github/CONTRIBUTING.md).
