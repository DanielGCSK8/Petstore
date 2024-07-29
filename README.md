<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Requerimientos

Composer

php 8.2 +

MySQL

### Instalación

- Usar git para clonar este repositorio. Ejecute este comando: git clone https://github.com/DanielGCSK8/Petstore.git
- Una vez clonado el repositorio, ejecutar el siguiente comando: composer install


## Ajustes y ejecución

- Ejecutar en la consola el siguiente comando: cp .env.example .env
Esto generará el archivo .env en base al .env.example.
- crear una base de datos en MySQL con el nombre que desee.
- en el archivo .env, ajustar los datos de conexión a la base de datos. Por ejemplo:
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nombreDB
   DB_USERNAME=root
   DB_PASSWORD=
- generar el app key de la aplicación con el siguiente comando: php artisan key:generate
- ejecutar el siguiente comando: php artisan migrate --seed para generar las migraciones y ejecutar los seeders.
- Para ejecutar el proyecto, ejecutar el siguiente comando: php artisan serve

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
