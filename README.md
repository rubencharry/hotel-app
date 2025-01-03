# :hotel: Aplicación de Hoteles

<div align="center">
  <img src="https://github.com/user-attachments/assets/6862463a-e989-4b17-9711-8e0330e59aab" alt="img readme" width="350px">
</div>

## Descripción General del Proyecto

Este proyecto es un sistema de gestión hotelera. Permite:

### :hammer: Funcionalidades 
- Registrar información de hoteles, incluyendo nombre, dirección, ciudad y NIT.
- Configurar el número máximo de habitaciones por hotel.
- Asignar tipos de habitaciones (Estándar, Junior, Suite) con restricciones de acomodación:
  - **Estándar**: Sencilla o Doble.
  - **Junior**: Triple o Cuádruple.
  - **Suite**: Sencilla, Doble o Triple.
- Validar que los datos ingresados no superen el límite de habitaciones, evitando duplicados.

## :white_check_mark: Tecnologías Utilizadas
El proyecto se desarrolló empleando un arquitectura hexagonal, además de encontrarse completamente desacoplado el backend y frontend

### :bricks: Frontend:
- **Vue.js**: Construcción de una interfaz de usuario moderna.
- **Vue Router**: Navegación en una aplicación de una sola página.
- **Axios**: Comunicación entre frontend y backend.
- **NodeJS**: Instalador de dependencias.

### :back: Backend:
- **Laravel**: API RESTful desacoplada, implementada con principios SOLID.
- **PostgreSQL**: Base de datos relacional.
- **Supabase**: Base de datos desplegada en producción.
- **Composer**: Instalador de dependencias.

### :house: Infraestructura:
- **AWS EC2**: Despliegue del sistema en la nube.

## :open_umbrella: Proceso de despliegue

### :back: Backend
- Inicialmente clona el repositorio que incluye solo el back:

   `git clone https://github.com/rubencharry/back-hotel-app` 

- Ejecuta el siguiente comando para instalar las dependencias de la aplicación: 

  `composer install`

- Antes de correr las migraciones debes crear el archivo .env copiando el env.example que viene por defecto y configurar la conexión a tu DB de postgress con los siguientes datos:

  `DB_CONNECTION=pgsql`
  
  `DB_HOST=El host`
  
  `DB_PORT=5432`
  
  `DB_DATABASE= El nombre de la base de datos que vas a utilizar`
  
  `DB_USERNAME= El usuario`
  
  `DB_PASSWORD= La contraseña`
  
- Ejecuta las migraciones para configurar las tablas necesarias:

  `php artisan migrate`

- Corre la semilla para tener datos de prueba:  

  `php artisan db:seed`

- Antes de ejecutar el servidor debes generar la key de tu aplicación con el siguiente comando:
  
  `php artisan key:generate`
  
- Puedes usar el servidor embebido de Laravel para desarrollo local:

  `php artisan serve`

- Para entornos de producción, configura tu servidor web (por ejemplo, Apache o Nginx) para apuntar al directorio public.

  > **Nota:** Asegúrate de contar con las extensiones pdo_pgsql y pgsql en tu archivo php.ini.

### :bricks: Frontend:



