## Rest API Framewok

Framework escrito en PHP para crear API Restfull al estilo FlightPHP o SlimPHP

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

- _Core_: Ficheros del core del framework. Aquí se puede encontrar las siguientes clases:

  - Controller: Clase base para extender los demás controller que se creen
  - Model: Clase base para extender todos los demás models que se creen
  - Request: Clase que representa una petición
  - Response: Clase que representa una respuesta
  - Route: Clase que representa una ruta y permite matchear si coincide con la petición

- _Controllers_: Carpeta con los controladores de la app

- _Models_: Carpeta con los models para acceder a la bd y devolver datos al controlador

- _index.php_: Punto de entrada que importa la app, añade las rutas e inicializa la app

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
- Añadir NotFoundController para redirigir las llamadas que no tienen el controlador creado
