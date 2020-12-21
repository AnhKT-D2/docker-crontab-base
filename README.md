<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Setup project
- git clone git@gitlab.com:nguyentranhiep96/cms-elearning.git || git clone https://gitlab.com/nguyentranhiep96/cms-elearning.git
- cp .env.example .env
- config db, mail, aws, queue
- docker-compose up
- connect mysql docker
- docker exec -ti {container_id} sh
- composer install
- php artisan key:generate
- php artisan jwt:secret
- php artisan config:clear
- php artisan cache:clear
- php artisan config:cache
- php artisan migrate --seed
- Run http://localhost:8089

