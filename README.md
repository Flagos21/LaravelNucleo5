# NT5 — Formularios y Validaciones en Laravel

Aplicación educativa interactiva para la asignatura **Electivo Profesional I — Desarrollo Web con Laravel**.
Universidad Adventista de Chile · 2025.

## Requisitos

- XAMPP (PHP 8.2+, MySQL 5.7+)
- Composer 2.x
- Navegador moderno

## Instrucciones de instalación

### 1. Iniciar XAMPP

Abre el panel de control de XAMPP y activa:
- **Apache** (necesario para phpMyAdmin)
- **MySQL**

### 2. Crear la base de datos

1. Abre **phpMyAdmin** en `http://localhost/phpmyadmin`
2. Haz clic en **Nueva** (en el panel izquierdo)
3. Escribe el nombre: `laravel_nt5`
4. Collation: `utf8mb4_unicode_ci`
5. Clic en **Crear**

### 3. Configurar el archivo .env

El archivo `.env` ya está configurado para XAMPP con los valores correctos:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_nt5
DB_USERNAME=root
DB_PASSWORD=
```

> Si tu MySQL tiene contraseña, agrégala en `DB_PASSWORD=`.

### 4. Instalar dependencias PHP

Abre una terminal en la carpeta del proyecto y ejecuta:

```bash
composer install
```

### 5. Generar la clave de aplicación

```bash
php artisan key:generate
```

> Si ya existe una clave en `.env`, puedes omitir este paso.

### 6. Crear las tablas y cargar datos de prueba

```bash
php artisan migrate:fresh --seed
```

Este comando:
- Elimina todas las tablas existentes
- Recrea las tablas con la estructura correcta
- Inserta 3 registros de ejemplo en cada tabla

### 7. Iniciar el servidor de desarrollo

```bash
php artisan serve
```

Luego abre tu navegador en: **http://localhost:8000**

---

## Estructura de la aplicación

```
laravel_nt5/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ModuloController.php       # Módulos 1, 2, 3 y dashboard
│   │   │   └── FormRequestController.php  # Módulo 4
│   │   └── Requests/
│   │       └── SoporteRequest.php         # Form Request del módulo 4
│   └── Models/
│       ├── Ficha.php
│       ├── Producto.php
│       ├── Contacto.php
│       └── SolicitudSoporte.php
├── database/
│   ├── migrations/
│   │   ├── ..._create_fichas_table.php
│   │   ├── ..._create_productos_table.php
│   │   ├── ..._create_contactos_table.php
│   │   └── ..._create_solicitudes_soporte_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/views/
│   ├── layouts/app.blade.php              # Layout con sidebar
│   ├── dashboard/index.blade.php          # Módulo 5 — Dashboard
│   └── modulos/
│       ├── formularios.blade.php          # Módulo 1
│       ├── validacion.blade.php           # Módulo 2
│       ├── errores.blade.php              # Módulo 3
│       └── form-request.blade.php         # Módulo 4
└── routes/web.php                         # Todas las rutas GET y POST
```

## Módulos disponibles

| Módulo | URL | Contenido |
|--------|-----|-----------|
| Dashboard | `/` | Vista general, contadores, mapa de flujo SVG |
| M1 — Formularios | `/modulo/formularios` | @csrf, old(), POST, Ficha de Estudiante |
| M2 — Validación | `/modulo/validacion` | validate(), reglas pipe/array, Registro de Producto |
| M3 — Errores | `/modulo/errores` | @error, mensajes personalizados, Contacto Universitario |
| M4 — Form Request | `/modulo/form-request` | SoporteRequest, authorize(), rules(), Soporte TI |

## Notas pedagógicas

- Cada módulo muestra el **código real del proyecto** (no pseudocódigo) junto al formulario funcional.
- El panel de reglas del Módulo 2 se activa al enfocar cada campo.
- El log de errores del Módulo 3 muestra qué campos fallaron y por qué.
- Todos los mensajes de validación están en **español**.
- La app funciona offline (XAMPP); solo los CDN de Tailwind y highlight.js requieren internet.

## Stack técnico

- **Laravel 12** (PHP 8.2)
- **MySQL** vía XAMPP
- **TailwindCSS** vía CDN
- **highlight.js** vía CDN (tema atom-one-dark)
- Sin Node.js / Vite
