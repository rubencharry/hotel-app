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

## :briefcase: Base de datos
<div align="center">
  <img src="https://github.com/user-attachments/assets/a426d168-f2d7-458e-9369-1d4277d3d11c" alt="img readme" width="350px">
</div>

## :dependabot: Endpoints:

### **Hotels**
#### 1. Obtener todos los hoteles
- **URL:** `GET /api/get-all-hotels`
- **Descripción:** Devuelve una lista de todos los hoteles registrados.
- **Ejemplo de respuesta:**  
  ```json
  [
    {
      "id": 1,
      "name": "Hotel Decameron",
      "address": "Calle 23 58-25",
      "city": "Cartagena",
      "nit": "12345678-9",
      "max_rooms": 42
    }
  ]
  ```

#### 2. Obtener un hotel por ID
- **URL:** `GET /api/get-hotel-by-id/{id}`
- **Descripción:** Devuelve los datos de un hotel específico.
- **Parámetros de ruta:**  
  - `id`: ID del hotel.

#### 3. Crear un hotel
- **URL:** `POST /api/create-hotel`
- **Descripción:** Crea un nuevo hotel.
- **Cuerpo de la solicitud:**  
  ```json
  {
    "name": "Hotel Decameron",
    "address": "Calle 23 58-25",
    "city": "Cartagena",
    "nit": "12345678-9",
    "max_rooms": 42
  }
  ```

#### 4. Actualizar un hotel
- **URL:** `POST /api/update-hotel/{id}`
- **Descripción:** Actualiza la información de un hotel existente.
- **Parámetros de ruta:**  
  - `id`: ID del hotel.
- **Cuerpo de la solicitud:**  
  ```json
  {
    "name": "Hotel Decameron Actualizado",
    "address": "Calle Nueva 45-67"
  }
  ```

#### 5. Eliminar un hotel
- **URL:** `DELETE /api/delete-hotel/{id}`
- **Descripción:** Elimina un hotel específico.
- **Parámetros de ruta:**  
  - `id`: ID del hotel.

---

### **Rooms**
#### 1. Obtener habitaciones de un hotel
- **URL:** `GET /api/get-rooms/{hotel_id}`
- **Descripción:** Devuelve las habitaciones asociadas a un hotel específico.
- **Parámetros de ruta:**  
  - `hotel_id`: ID del hotel.

#### 2. Obtener una habitación por ID
- **URL:** `GET /api/get-room-by-id/{id}`
- **Descripción:** Devuelve los datos de una habitación específica.
- **Parámetros de ruta:**  
  - `id`: ID de la habitación.

#### 3. Crear una habitación
- **URL:** `POST /api/create-room`
- **Descripción:** Crea una nueva habitación.
- **Cuerpo de la solicitud:**  
  ```json
  {
    "hotel_id": 2,
    "room_type_id": 2,
    "accommodation_id": 4,
    "quantity": 1
  }
  ```

#### 4. Actualizar una habitación
- **URL:** `POST /api/update-room/{id}`
- **Descripción:** Actualiza los datos de una habitación específica.
- **Parámetros de ruta:**  
  - `id`: ID de la habitación.
- **Cuerpo de la solicitud:**  
  ```json
  {
    "room_type_id": 3,
    "accommodation_id": 1,
    "quantity": 500
  }
  ```

#### 5. Eliminar una habitación
- **URL:** `DELETE /api/delete-room/{id}`
- **Descripción:** Elimina una habitación específica.
- **Parámetros de ruta:**  
  - `id`: ID de la habitación.

---

### **Accommodations**
#### 1. Obtener tipos de alojamiento por tipo de habitación
- **URL:** `GET /api/get-accommodation-by-room-type`
- **Descripción:** Devuelve una lista de alojamientos relacionados con un tipo de habitación específico.

---

## :open_umbrella: Proceso de despliegue

> **Nota:** Asegúrate de tener php 8.2 o superior y composer para el despliegue del back y nodejs para desplegar el front.

### :back: Backend
- Inicialmente clona el repositorio que incluye solo el back:

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
- Inicialmente clona el repositorio que incluye solo el front:

- Configura las variables de entorno con la url en donde se encuentra desplegada la api del back

  `VITE_API_URL=tu_url_desplegada`

- Ejecuta el siguiente comando para instalar las dependencias de la aplicación: 

  `npm install`

- Compila el proyecto para producción con:

  `npm run build`

 Este comando generará una carpeta llamada dist que contiene los archivos listos para ser desplegados. Allí se encuentra el index.html donde está toda la aplicación lista. 

## :rainbow: Proyecto desplegado 

Tanto front como back fueron desplegados en un servidor EC2 de AWS. Puedes ver el front en la siguiente IP:

http://3.135.204.206/

Y el back para probar los endpoints:

http://18.117.160.225/










