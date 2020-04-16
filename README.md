## Rest API Framewok

Framework escrito en PHP para crear API Restfull basado en la idea de "no configuración"


### Conexión con base de datos

Renombrar el fichero config.example.php a config.php y substituir las constantes por los valores 
que correspondan.

* DB_HOST -> Nombre del servidor de bases de datos. Ej. "localhost"
* DB_USER -> Usuario con permisos en la base de datos
* DB_PASS -> Contraseña del usuario
* DB_NAME -> Nombre de la base de datos

### Funcionamiento y estructura de directorios

 root
  |
   - Core
  |
   - Controllers
  |
   - Models
  |
   - index.php
   - .htaccess


* Core: Ficheros del core del framework. Aquí se puede encontrar la clase Controller y Model 
	de las que se deben extender los controller y models que se creen nuevos.

* Controllers: Carpeta con los controladores del framework

* Models: Carpeta con los models para acceder a la bd y devolver datos al controlador

* index.php: Dispatcher del framework que redirige las peticiones al controlador adecuado.
	Ej.: 
		* La petición GET / -> intentará ejecutar el método get del IndexController
		* La petición GET /products -> ejecutará el método get del ProductsController
		* La petición GET /products/1 -> ejecutará el método get del ProductsController con el parámetro 1
	Es decir, no hace falta configurar ninguna petición, solo crear los controladores y models de cada llamada
  
* .htaccess: Fichero para activar y redirigir todas las llamadas al dispatcher. Es necesario que Apache tenga activado el mod_rewrite

	Contenido del fichero:
```
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f

RewriteRule ^(.+)$ index.php/$1 [L]
```
