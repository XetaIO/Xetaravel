
> <p align="center">
>   <img src="art/logo-brand-light-mode.png#gh-light-mode-only" alt="Xetaravel Logo" height="230"/>
>   <img src="art/logo-brand-dark-mode.png#gh-dark-mode-only" alt="Xetaravel Logo" height="230"/>
> </p>
>
>
> |Unit Tests|Coverage|Scrutinizer|Stable Version|Downloads|                                                    Laravel                                                    |License|
> |:------:|:-------:|:------:|:-------:|:------:|:-------------------------------------------------------------------------------------------------------------:|:-------:|
> |[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/XetaIO/Xetaravel/tests.yml?style=flat-square)](https://github.com/XetaIO/Xetaravel/actions/workflows/tests.yml)|[![Coverage Status](https://img.shields.io/codecov/c/github/XetaIO/Xetaravel?style=flat-square)](https://app.codecov.io/gh/XetaIO/Xetaravel)|[![Scrutinizer](https://img.shields.io/scrutinizer/g/XetaIO/Xetaravel.svg?style=flat-square)](https://scrutinizer-ci.com/g/XetaIO/Xetaravel)|[![Latest Stable Version](https://img.shields.io/packagist/v/XetaIO/Xetaravel.svg?style=flat-square)](https://packagist.org/packages/xetaio/xetaravel)|[![Total Downloads](https://img.shields.io/packagist/dt/xetaio/xetaravel.svg?style=flat-square)](https://packagist.org/packages/xetaio/xetaravel)| [![Laravel 12.0](https://img.shields.io/badge/Laravel-12.0-f4645f.svg?style=flat-square)](http://laravel.com) |[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/XetaIO/Xetaravel/blob/master/LICENSE)|
>
> I have developed this site to try Laravel and to do my personal website. And I have decided to release it to help people starting with Laravel, so there is probably some custom configurations/functions that only fit my needs.
>
> ## Demo
> Note : All installed accounts won't work on the demo site, you will need to create a new one.
>
> [xetaravel.com](https://xetaravel.com)
>
> ## Administration Preview
> #### 💡 Turn your GitHub theme to dark/light mode to see the preview in dark/light mode.
> <img width="1890" height="915" alt="dashboard-1-dark-mode" src="./art/dashboard-1-dark-mode.png#gh-dark-mode-only" />
> <img width="1891" height="919" alt="dashboard-2-dark-mode" src="./art/dashboard-2-dark-mode.png#gh-dark-mode-only" />
> <img width="1882" height="919" alt="dashboard-article-edit-dark-mode" src="./art/dashboard-article-edit-dark-mode.png#gh-dark-mode-only" />
> <img width="1887" height="922" alt="dashboard-1-light-mode" src="./art/dashboard-1-light-mode.png#gh-light-mode-only" />
> <img width="1890" height="921" alt="dashboard-2-light-mode" src="./art/dashboard-2-light-mode.png#gh-light-mode-only" />
> <img width="1907" height="922" alt="dashboard-article-edit-light-mode" src="./art/dashboard-article-edit-light-mode.png#gh-light-mode-only" />
>
> # Installation
> ## Requirements
>
> | PHP                                                                         |PHP Extension|DBMS| NodeJS                                                                                | npm                                                                           |Others (optional)
> |-----------------------------------------------------------------------------|---|---|---------------------------------------------------------------------------------------|-------------------------------------------------------------------------------|---|
> | ![PHP](https://img.shields.io/badge/PHP->=8.2-0e7fbf.svg?style=flat-square) |![OpenSSL](https://img.shields.io/badge/PHP%20ext-OpenSSL-44CB12.svg?style=flat-square)<br>![PDO](https://img.shields.io/badge/PHP%20ext-PDO-44CB12.svg?style=flat-square)<br>![CURL](https://img.shields.io/badge/PHP%20ext-CURL-44CB12.svg?style=flat-square)|![MySQL](https://img.shields.io/badge/MySQL->=8.0-44CB12.svg?style=flat-square)| ![NodeJS](https://img.shields.io/badge/NodeJS->=20.19.0-44CB12.svg?style=flat-square) | ![npm](https://img.shields.io/badge/npm->=5.0.0-44CB12.svg?style=flat-square) |![Analytics](https://img.shields.io/badge/Google-Analytics-44CB12.svg?style=flat-square)<br>![Redis](https://img.shields.io/badge/Redis-Server-44CB12.svg?style=flat-square)<br>![Redis](https://img.shields.io/badge/Redis-PHPRedis-44CB12.svg?style=flat-square)
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
> npm install
> npm run build
> ```
>
>
> ### Pre-installed Accounts
> * **Admin**
>   * User : **admin@xetaravel.io**
>   * Password : **admin**
> * **Moderator**
>   * User : **moderator@xetaravel.io**
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
>     * Articles
>         * Media
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
>     * Settings Management
>     * Badges Management
>
> * ###### Others
>     * Experiences system (based on posts, comments etc)
>     * Rubies system (virtual currency) (based on posts, comments etc)
>     * Newsletter
>     * Sessions management (multiple connected device)
>     * Notifications
>     * Badges
>
> # Contribute
> If you want to contribute, please [follow this guide](https://github.com/XetaIO/Xetaravel/blob/master/.github/CONTRIBUTING.md).
