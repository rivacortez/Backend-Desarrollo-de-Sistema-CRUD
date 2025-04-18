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

## 🧩 Entidades Principales

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

# ✅ Beneficios del Patrón CQRS y Arquitectura Hexagonal
* Separación de Responsabilidades: Clara distinción entre operaciones de lectura y escritura.
* Escalabilidad: Optimización independiente para operaciones de lectura y escritura.
* Testabilidad: Facilita la creación de pruebas unitarias y de integración.
* Mantenibilidad: Código más organizado y desacoplado.
* Evolución: Facilita cambios en la infraestructura sin afectar la lógica de negocio.
