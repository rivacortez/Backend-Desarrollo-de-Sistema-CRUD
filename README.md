# 🍽️ Sistema de Gestión de Reservaciones para Restaurantes

[![PHP Version](https://img.shields.io/badge/PHP-8.4-blue.svg?style=flat-square)](https://www.php.net/)
[![Laravel Version](https://img.shields.io/badge/Laravel-12.9.2-red.svg?style=flat-square)](https://laravel.com/)

## 📝 Descripción General

Este proyecto implementa un sistema robusto y eficiente para la gestión de reservaciones en restaurantes. Permite la administración de mesas, registro de comensales y gestión de reservaciones. La aplicación sigue una **arquitectura hexagonal** y emplea el patrón **CQRS** (Command Query Responsibility Segregation).

---

## ✨ Características Principales

- **Gestión de Mesas:** Capacidad, ubicación y estado (disponible/reservada).
- **Gestión de Comensales:** Registro, contacto e historial.
- **Gestión de Reservaciones:** Crear, modificar, cancelar, asignar mesas.
- **API Documentada:** Swagger/OpenAPI.
- **Arquitectura Robusta:** Hexagonal + CQRS + DDD.

---

## 🧰 Tecnologías Utilizadas

| Tecnología     | Logo                                                                                                       |
|----------------|------------------------------------------------------------------------------------------------------------|
| Laravel 10     | <img src="https://laravel.com/img/logotype.min.svg" alt="Laravel" height="70px">                           |
| PHP ≥ 8.1      | <img src="https://www.php.net/images/logos/new-php-logo.svg" alt="PHP" height="150px">                     |
| MySQL          | <img src="https://www.mysql.com/common/logos/logo-mysql-170x115.png" alt="MySQL" height="150px">           |
| Docker         | <img src="https://www.hasselpunk.com/img/blog/ExponiendoFuncionesDeREnLaNube-Parte_2/docker_logo.png" alt="Docker" height="150px"> |
| OpenAPI/Swagger| <img src="https://cdn.worldvectorlogo.com/logos/openapi-1.svg" alt="OpenAPI" height="200px">               |

---

## 🏗️ Arquitectura

### 🔷 Hexagonal

- **Dominio:** Entidades, lógica, servicios, sin dependencias externas.
- **Aplicación:** Orquestación con comandos y consultas.
- **Infraestructura:** Implementación de repositorios y acceso a datos.
- **Interfaces:** Controladores REST, documentación y recursos.

### 🔁 CQRS

- **Write Model (Comandos):** Crear, actualizar, eliminar.
- **Read Model (Consultas):** Solo lectura, sin modificar estado.

---

# ✅ Beneficios del Patrón CQRS y Arquitectura Hexagonal
* Separación de Responsabilidades: Clara distinción entre operaciones de lectura y escritura.
* Escalabilidad: Optimización independiente para operaciones de lectura y escritura.
* Testabilidad: Facilita la creación de pruebas unitarias y de integración.
* Mantenibilidad: Código más organizado y desacoplado.
* Evolución: Facilita cambios en la infraestructura sin afectar la lógica de negocio.


## 🧩 Entidades 

### 🍽️ Mesas (Tables)

- `id`, `numero`, `capacidad`, `ubicacion`, timestamps

### 👤 Comensales (Customers)

- `id`, `nombre`, `correo_electronico`, `telefono`, `direccion`, timestamps

### 📅 Reservaciones (Reservations)

- `id`, `comensal_id`, `mesa_id`, `fecha_hora`, `numero_personas`, `notas`, `estado`, timestamps

---

## 📁 Estructura del Proyecto

```plaintext
ReservationManagement/
├── Tables/
├── Customers/
└── Reservations/
    ├── application/
    │   └── internal/
    │       ├── commandservices/
    │       └── queryservices/
    ├── domain/
    │   ├── exceptions/
    │   ├── model/
    │   │   ├── aggregates/
    │   │   ├── commands/
    │   │   └── queries/
    │   └── services/
    ├── infrastructure/
    │   └── persistence/
    └── interfaces/
        └── rest/
            ├── documentation/
            └── resources/
```
## 📖 Documentación de la API
   La API está documentada usando OpenAPI/Swagger y se puede acceder a través de:

```
/api/documentation – Interfaz interactiva de Swagger UI
```
# 🧪 Pruebas Unitarias

Este proyecto incluye una **suite completa de pruebas unitarias** diseñada para garantizar la **calidad**, **estabilidad** y **correctitud** de cada capa de la aplicación.  
Las pruebas están organizadas conforme a la **Arquitectura Hexagonal** y siguen los principios de **Domain-Driven Design (DDD)**.

---

## 📦 Categorías de Pruebas

### ✅ Pruebas de Dominio
- Verifican las **reglas de negocio**, validaciones y comportamiento de agregados y objetos de valor.
- Ejemplo: Asegurar que no se pueda crear una reservación sin una mesa o cliente válido.

### 🧩 Pruebas de Repositorio
- Validan la correcta **persistencia** y **recuperación** de entidades del dominio mediante interfaces de repositorio.
- Se centran en la interacción con la base de datos usando Eloquent u otros drivers personalizados.

### ⚙️ Pruebas de Servicios de Aplicación
- Evalúan los **comandos** (operaciones de escritura) y **consultas** (operaciones de lectura).
- Verifican la lógica de orquestación y el uso correcto de servicios del dominio.

### 🌐 Pruebas de API (Feature Tests)
- Simulan peticiones HTTP y prueban los endpoints REST.
- Evalúan todo el ciclo de vida de una petición: rutas, validación, controladores y respuestas.

#### 🧪 API de Clientes
- ✅ Obtener todos los clientes
- ✅ Obtener cliente por ID
- ✅ Crear cliente con datos válidos
- ✅ Actualizar cliente existente
- ✅ Eliminar cliente existente
- 🔴 Manejo de ID inexistente (404)
- 🔴 Validación de datos en creación/actualización

#### 🧪 API de Reservaciones
- ✅ Obtener todas las reservaciones
- ✅ Obtener reservación por ID
- ✅ Crear reservación con datos válidos
- ✅ Actualizar reservación existente
- ✅ Eliminar reservación
- 🔴 Manejo de ID inválidos (404)
- 🔴 Validación de campos requeridos y llaves foráneas

#### 🧪 API de Mesas
- ✅ Listar todas las mesas
- ✅ Ver una mesa específica
- ✅ Registrar mesa con datos válidos
- ✅ Actualizar y eliminar mesa
- 🔴 Manejo de mesa inexistente (404)
- 🔴 Validación de datos incompletos

### 🚨 Pruebas de Manejo de Excepciones
- Aseguran que el sistema maneja correctamente:
    - Excepciones de dominio (reservas, clientes, mesas)
    - Errores de validación
    - Recursos no encontrados
    - Errores inesperados del sistema

---

## ▶️ Cómo Ejecutar las Pruebas

Para ejecutar **todas las pruebas**:

```bash
   php artisan test
```

## ⚙️ Instalación y Configuración

### 1. Clonar el repositorio
```
git clone https://github.com/rivacortez/Backend-Desarrollo-de-Sistema-CRUD.git
```
### 2. Instalar dependencias
```
composer install
```
### 3. Configurar variables de entorno
Copiar el archivo .env.example a .env y configurar la conexión a la base de datos.

### 4. Generar clave de aplicación
```
php artisan key:generate
```
### 5. Ejecutar migraciones

```
php artisan migrate
```

### 6. Iniciar servidor
```
php artisan serve
```

