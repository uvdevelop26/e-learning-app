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
Ingresa al Sistema utilizando los siguientes usuarios 

 ## Usuario: administrador@gmail.com; Contraseña: password

- En la sección "Todas las Clases", puedes explorar las clases creadas por los profesores:
  - Puedes eliminar una clase.
  - Crear, editar y eliminar anuncios.
  - Dejar comentarios en los anuncios.
- En la sección "Personas":
  - Agregar alumnos ingresando su número de cédula.
  - Eliminar alumnos.
- En la sección "Usuarios":
  - Seleccionar "Alumnos": buscar, crear, editar y eliminar alumnos.
  - Seleccionar "Docentes": buscar, crear, editar y eliminar docentes.
  - Seleccionar "Administradores": buscar, crear, editar y eliminar administradores.
- En la sección "Académicos":
  - Seleccionar "Carreras": buscar, crear, editar y eliminar carreras.
  - Seleccionar "Semestres": buscar, crear y editar semestres.
  - Seleccionar "Materias": buscar, crear, editar y eliminar materias.

 ## Usuario: docente@gmail.com; Contraseña: password
 - En la sección "Todas las Clases", puedes crear, editar y eliminar clases.
    - Al explorar una clase, puedes crear, editar y eliminar anuncios.
    - Dejar comentarios en los anuncios.
    - Hacer clic en "Acumulativos" para ver los detalles de las entregas de tareas de cada unidad.
 - Al explorar una clase, puedes agregar y editar una nueva unidad
 - Hacer clic en la unidad creada para agregar anuncios.
 - En la unidad, puedes agregar y eliminar tareas
   - Hacer clic en la tarea para ver, editar y comentar la tarea.
   - Hacer clic en "Ver entregas" para ver la lista de alumnos que han entregado la tarea.
   - Devolver la tarea agregando puntajes y observaciones.
   - Deshacer la devolución y editar.

 ## Usuario: alumno@gmail.com; Contraseña: password
 - En la sección "Todas las Clases", puedes ver las clases en las que estás inscrito.
  - Al explorar la clase, puedes ver los anuncios y comentar.
- Al explorar la clase, puedes ver las unidades y hacer clic para explorar
  - Publicar un anuncio en la unidad.
  - Hacer clic para explorar las tareas y comentar.
  - Entregar la tarea.





