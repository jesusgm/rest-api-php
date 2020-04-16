## Rest API Framewok

Framework escrito en PHP para crear API Restfull basado en la idea de "no configuración". Sólo hay que configurar la base de datos y empezar a crear controllers y models con el nombre adecuado.

### Conexión con base de datos

Renombrar el fichero config.example.php a config.php y substituir las constantes por los valores
que correspondan.

- _DB_HOST_ -> Nombre del servidor de bases de datos. Ej. "localhost"
- _DB_USER_ -> Usuario con permisos en la base de datos
- _DB_PASS_ -> Contraseña del usuario
- _DB_NAME_ -> Nombre de la base de datos

### Funcionamiento y estructura de directorios

```
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
```

- _Core_: Ficheros del core del framework. Aquí se puede encontrar la clase Controller y Model de las que deben extender los controller y models que se creen nuevos.

- _Controllers_: Carpeta con los controladores del framework

- _Models_: Carpeta con los models para acceder a la bd y devolver datos al controlador

- _index.php_: Dispatcher del framework que redirige las peticiones al controlador adecuado.
  Ej.:

  - La petición **"GET /"** -> intentará ejecutar el método **get** del **IndexController**

  - La petición **"GET /products"** -> ejecutará el método get del ProductsController
  - La petición **"GET /products/1"** -> ejecutará el método **get** del **ProductsController** con el parámetro **1**.

  Es decir, no hace falta configurar ninguna petición, solo crear los controladores y models de cada llamada

- _.htaccess_: Fichero para activar y redirigir todas las llamadas al dispatcher. Es necesario que Apache tenga activado el mod_rewrite

  Contenido del fichero:

  ```
  RewriteEngine On

  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f

  RewriteRule ^(.+)$ index.php/$1 [L]
  ```

### Mejoras

- Añadir sistema de templates (aunque en principio solo lo necesito para retornar objetos JSON)
- Permitir configurar el controlador y método que se ejecuta por defecto
- Añadir NotFoundController para redirigir las llamadas que no tienen el controlador creado
