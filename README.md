# Taskwave

Self-hosted SaaS app for project management and customer relationship, built with Laravel & Filament.

<hr>


<p align="center">
    <a href="https://github.com/iluminar/taskwave/blob/dev/LICENSE"><img alt="License" src="https://img.shields.io/badge/license-MIT-brightgreen?style=for-the-badge"></a>
    <a href="https://laravel.com"><img alt="Laravel v11 .x" src="https://img.shields.io/badge/Laravel-v11.x-FF2D20?style=for-the-badge&logo=laravel"></a>
    <a href="https://livewire.laravel.com"><img alt="Livewire v3.x" src="https://img.shields.io/badge/Livewire-v3.x-FB70A9?style=for-the-badge"></a>
    <a href="https://php.net"><img alt="PHP 8.1" src="https://img.shields.io/badge/PHP-8.1-777BB4?style=for-the-badge&logo=php"></a>
</p>

## About Taskwave

Taskwave is a self-hosted SaaS app to manage projects, customers, tasks. It's an attempt to create PerfexCRM clone using
Laravel/Filament. It is build upon Filament and TALL stack.

<hr>
<p align="center">
<b><a href="#installation">Installation</a></b>
|
<b><a href="#screenshots-top">Screenshots</a></b>
|
<b><a href="#contributing-top">Contributing</a></b>
|
<b><a href="#supporting-top">Supporting</a></b>
|
<b><a href="#credits-top">Credits</a></b>
|
<b><a href="#license-top">License</a></b>
</p>

<hr>


## Installation

Clone the repository

```sh
git clone git@github.com:lukacavic/taskwave.git
```

Set env variables

```sh
cp .env.example .env
```

Install composer packages

```sh
composer install
```

Generate key

```sh
php artisan key:generate
```

Migrate and seed

```sh
php artisan migrate --seed
```

Login

```sh
Email: admin@org1.com
Password: org1
```

***Check Demo: (Reset every hour)***

https://slippy-surf-wtnb61jj78.ploi.site/app/login

## Screenshots <small>[↑Top](#about-taskwave)</small>

![](/images/SCR-20241009-qeva.png)

![](/images/SCR-20241010-hnoy.png)

![](/images/SCR-20241010-hdwh.png)

![](/images/SCR-20241010-hgrz.png)

![](/images/SCR-20241010-hjjt.png)

![](/images/SCR-20241010-jcjv.png)

![](/images/SCR-20241011-hqaa.png)

![](/images/Screenshot_49.png)

***Client Portal***

![](/images/SCR-20241011-jwuc.png)

## Supporting <small>[↑Top](#about-taskwave)</small>

### Be a sponsor

Taskwave is an MIT-licensed open source project with its ongoing development.

Support the development of "taskwave" by being a sponsor, reach at <luka.cavic@gmail.com>


### Professional Support

If you need professional support or custom functioanlity please send an e-mail to <luka.cavic@gmail.com>.

## Security Vulnerabilities <small>[↑Top](#about-taskwave)</small>

If you discover a security vulnerability within taskwave, please send an e-mail to <luka.cavic@gmail.com> instead of creating new issue. All security vulnerabilities will be promptly addressed.

## Credits <small>[↑Top](#about-taskwave)</small>

- Author: [Luka Čavić](https://github.com/lukacavic)



## License <small>[↑Top](#about-taskwave)</small>

taskwave is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
