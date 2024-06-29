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

php artisan migrate

php artisan db:seed


```
Abrir un nuevo servidor para explorar el sistema
```
    npm run dev
    php artisan serve

```




