<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Tecnologías

- Xampp
- Visual Studio Code


## Pasos a Seguir
En la carpeta "Htdoc" de Xampp abrir la terminal de comandos y ejecutar

```git
    git pull https://github.com/uvdevelop26/e-learning-app.git

```
Abrir el proyecto en VS code
```
    cd elearning-app
    code .
```
Instalar dependencias
```
    composer install
    npm install
```
Configurar base de datos

- Crear una nueva base de datos.
- Configurar el archivo ".env" con los datos de la base de datos

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elearningdb
DB_USERNAME=root
DB_PASSWORD=

```
Ejutar en la terminal el comando de migración con los seeders

```

 php artisan migrate:fresh --seed

```
Abrir un nuevo servidor para explorar el sistema
```
    npm run dev
    php artisan serve

```



## Learning Laravel

