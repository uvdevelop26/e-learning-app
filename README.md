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

 ## user: administrador@gmail.com; contraseña: password

  - En la sección "Todas las Clases" explora las clases creadas por los profesores.
    - Puedes Eliminar una clase
    - Crea un anuncio, puedes editar y eliminar anuncios.
    - Puedes dejar comentario en el anuncio.
    - En la sección "Personas" puedes agregar alumnos ingresando, también puedes eliminar alumnos.
  - En la Sección Usuarios
    - Selecciona "Alumnos", puedes buscar alumnos, crear, editar y eliminar alumno.
    - Selecciona "Docentes", puedes buscar docentes, crear, editar y eliminar docente.
    - Selecciona "Administradores", puedes buscar administradores, crear editar y eliminar administrador.
  - En la Sección Académicos
    - Selecciona "Carreras", puedes buscar carreras, crear, editar y eliminar carrera.
    - Selecciona "Semestres", puedes buscar semestres, crear y editar semestre.
    - Selecciona "Materias", puedes buscar materias, crear editar y eliminar materia.

 ## user: docente@gmail.com; contraseña: password
 - En la sección "Todas las Clases" puedes crear, editar y eliminar clases.
    - Al explorar una clase, puedes crear, editar y eliminar anuncios.
    - Puedes dejar comentarios en los anuncios
    - Puedes hacer click en "Acumulativos" y ver los detalles de entregas de las tareas de cada unidad.
 - Al explorar una clase, puedes Agregar y editar una nueva unidad.
 - Puedes hacer click en la unidad creada y agregar anuncios.
 - En la unidad puedes agregar, y eliminar tareas.
   - Puedes hacer click en la tarea para ver, editar y comentar la tarea.
   - Puedes hacer click en "Ver entregas" con la lista de alumnos que han entregado la tarea
   - Puedes devolver la tarea agregando puntajes y observaciones.
   - Puedes deshacer la devolución y editar.

 ## user: alumno@gmail.com; contraseña: password
 - En la sección "Todas las Clases" puedes ver las clases en las que estás inscripto.
  - Al explorar la clase puedes ver los anuncios y comentar.
- Al explorar la clase puedes ver las unidades y hacer click para explorar
  - Puedes publicar un anuncio en la unidad
  - Puedes hacer click para explorar las tareas y comentar.
  - Puedes Entregar la tarea.





