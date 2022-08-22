# DOGFRIENDLIST
 
Proyecto final del CFGS de Desarrollo de Aplicaciones Web.

## Autor

Sergio Fernández Fernández.
 
## Introducción
 
Todos aquellos que compartimos nuestras vidas con un perro sabemos que son un miembro más de la familia. Por lo tanto, unas vacaciones familiares no estarían completas sin ellos correteando de aquí para allá. Pero viajar con perros a veces puede volverse innecesariamente complicado, especialmente cuando el destino es un lugar desconocido. ¿Habrá suficientes zonas verdes para pasearlo? ¿Habrá alojamientos en la zona que admitan animales? ¿Tendremos que dejarlo fuera cada vez que queramos tomar un café o comer en un restaurante? Estas son algunas de las dudas más comunes que pueden surgirnos, y responderlas suele requerir de varias horas de búsqueda de información, en ocasiones desactualizada o poco fiable. Dogfriendlist trata de solucionar este problema mediante un mapa colaborativo donde los propios usuarios pueden señalar aquellos puntos de interés que conozcan. Esto permite a otros usuarios descubrir nuevos espacios, tanto en su propia ciudad como en otras, y organizar sus viajes de una forma sencilla con la información proporcionada de primera mano por gente local que frecuenta habitualmente estos lugares o servicios. 
 
## Vistas
  
![Home](https://user-images.githubusercontent.com/63967914/185973384-b4134122-3f08-4233-9b80-8654e6b8ee27.png)
 
![Nuevo Spot](https://user-images.githubusercontent.com/63967914/185973431-c94849e5-f39a-45e8-afee-f8ee2b6d5a3b.png)

![Spots Favoritos](https://user-images.githubusercontent.com/63967914/185973814-124a20e3-c272-43ef-a2f9-05b35b218530.png)

![Registro](https://user-images.githubusercontent.com/63967914/185973915-3140cbf8-505e-4a44-9071-699958232602.png)

![Login](https://user-images.githubusercontent.com/63967914/185973978-0705d43b-08b7-4128-97c6-dd7e93d98cb8.png)

## Objetivos propuestos (generales y específicos)

El objetivo general de nuestro proyecto es la creación de un mapa colaborativo sobre la API de Google Maps. La aplicación deberá tener un sistema de login y de registro y deberá ser capaz de almacenar los distintos puntos de interés (a los que llamaremos “spots” de ahora en adelante), creados por los usuarios y mostrar aquellos spots marcados como favoritos. Además, la interface de nuestra aplicación deberá adaptarse correctamente a cualquier dispositivo, por lo que deberemos implementar un diseño responsive. Inicialmente se había planteado la posibilidad de permitir a nuestros usuarios comentar y votar los distintos spots, pero por cuestiones de tiempo no se pudieron implementar estas funcionalidades.

A nivel personal, he establecido una serie de objetivos que trataré de ir cumpliendo a lo largo de todo el proyecto. A saber:

- Afianzar las competencias adquiridas durante todo el ciclo formativo, reforzando los conocimientos en las tecnologías y lenguajes vistos a lo largo del curso.

- Aprovechar este proyecto para ampliar mi stack tecnológico, aprendiendo a usar nuevas tecnologías con las que nunca había trabajado anteriormente en una aplicación real. 
  - Docker.
  - Google Maps API.
  - PhpUnit.
  - Composer.
  - PHP en su versión 8.

- Intentar escribir un código modular mediante la aplicación de buenas prácticas y patrones de diseño.

- Crear una interfaz intuitiva y sencilla.

# ANÁLISIS DEL PROYECTO

## Requisitos funcionales

- **Usuarios:**
Nuestra aplicación tendrá dos tipos de usuario, el usuario registrado, que tendrá acceso a toda la aplicación y el usuario no registrado, que podrá buscar spots, pero no crearlos ni guardarlos como favoritos.

- **Página principal:**
La página principal utilizará la geolocalización del navegador de nuestro usuario, si éste la permite, para posicionar en un mapa los spots cercanos. Además, contendrá un buscador que permitirá buscar los spots cercanos a una dirección concreta y filtrarlos por categoría.

- **Página de creación de spots:**
La página de creación de spots nos permitirá agregar nuevos spots a la base de datos de nuestra aplicación. Constará de un formulario donde se recogerá el título, la categoría y la descripción de nuestro spot. Además, dispondremos de un mapa interactivo donde señalaremos la posición de nuestro spot y de un buscador, para posicionar el mapa en la dirección deseada.

- **Página de favoritos:**
En página se mostrará un mapa con todos los spots que el usuario haya añadido a favoritos. Además, dispondrá de un buscador para buscar los spots cercanos a una dirección concreta y un filtro por categoría.

- **Página de registro:**
Constará de un formulario sencillo que enviará un link de activación al correo de nuestro usuario. Una vez activado el link, el usuario deberá identificarse en la página de login para finalizar el proceso de registro.

- **Página de login:**
Constará de un formulario simple que permitirá al usuario acceder a todas las funcionalidades de nuestra aplicación.

## Requisitos no funcionales:

- **Modularidad:**
Nuestra aplicación no estará completa cuando terminemos este proyecto. Por lo tanto, es indispensable que el código que escribamos permita poder añadir funcionalidades de la manera más sencilla posible, con los mínimos cambios en el código ya existente. Para ello, se prestará especial atención a la modularidad de nuestro programa durante toda la fase de programación. Se intentarán aplicar los principios SOLID, se usarán patrones de diseño y se trabajará con una arquitectura que segregue los distintos componentes en base a su funcionalidad.

- **Usabilidad:**
Trataremos de crear una interfaz intuitiva y visualmente limpia, evitando cualquier elemento que pueda distraer o confundir al usuario y haciendo que la experiencia de uso sea sencilla y clara.

## Diagrama Entidad-Relacion

![Diagrama E-R](https://user-images.githubusercontent.com/63967914/185976170-1f65bede-ba42-4df8-a0fb-8cbe192cb336.jpg)

## Diagrama Relacional

![Diagrama Relacional](https://user-images.githubusercontent.com/63967914/185976411-3dfb3fb5-649d-4201-bf45-2e0a67a69d28.jpg)

## Diagrama de Clases

![Diagrama de Clases](https://user-images.githubusercontent.com/63967914/185976683-cb586113-3daf-497e-bf01-60eabbbd54fd.jpg)

# Tecnologías y herramientas utilizadas 

- **Lenguajes de programación:**
  - PHP
  - Javascript
  - SQL
  
- **Bibliotecas externas:**
  - JQuery
  - SimplePHPRouter
  - PHPMailer
  - PHPDotenv

- **Testing:**
  - PHPUnit
  
- **Servidor y Base de datos:**
  - Apache HTTP Server
  - MariaDB
  
- **Gestor de dependencias:**
  - Composer
  
- **Virtualización y despliegue:**
  - Docker
  - Docker Compose
  
# Requisitos técnicos

- PHP ^8.0.1
- Composer ^1.10.15
- Docker
- Docker Compose ^3.8

# Instalación


Clonar el repositorio: `git clone https://github.com/Sergio-Fernandez-Dev/dogfriendlist`

Montar el proyecto: `docker-compose build`

Instalar dependencias: `composer install`


## Iniciar app

`docker-compose up`

## Lanzar Tests

`vendor/bin/phpunit`
  
# VÍAS FUTURAS

Gracias a la modularidad que se ha tratado de implementar a lo largo de toda nuestra fase de programación, sería bastante fácil ampliar nuestra aplicación, sin necesidad de realizar grandes cambios en el código ya existente. 

Algunas de las posibles mejoras a implementar son las siguientes: 

- Crear una página desde donde poder modificar el perfil de usuario. Por suerte, ya hemos implementado la lógica que crea una nueva carpeta de almacenamiento con la id de usuario, cada vez que se produce un nuevo registro. De esta forma, el usuario podría fácilmente subir archivos a nuestra aplicación, como por ejemplo una foto de perfil.

- Crear una lista de miniaturas bajo el mapa principal con los spots que aparecen en el mapa y acceder desde ellas a una página con toda la información del spot.

- Permitir crear un álbum de fotos al crear un nuevo spot o cargarlas directamente de Google en caso de que el creador del spot decidiera no aportar imágenes.

- Implementar un sistema de comentarios en la página de cada spot.

- Añadir un sistema de votación que permita a los usuarios puntuar aquellos spots que conocen.

- Implementar un sistema de preguntas y respuestas que permitan a los usuarios intercambiar información sobre un spot determinado.

- Crear una nueva sección desde donde cada usuario pueda consultar, editar o eliminar, los spots creados por él.

