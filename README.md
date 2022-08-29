# Sistema de Información Sistematizada del Plan de Acción - SISPA

## Introducción
El objetivo del Sistema de Información Sistematizada del Plan de Acción (SISPA) es colaborar en el monitoreo y seguimiento al Plan de Acción de la Estrategia Contra el Tráfico Ilícito de Sustancias Controladas y Control de la Expansión de Cultivos de Coca 2021-2025.

## Funcionalidades
El SISPA contempla las siguientes funcionalidades
- Inicio de sesión
- Gestión de usuarios
- Gestión el Plan de Acción
- Gestión de metas
- Registro de avances
- Reporte de avances

## Requerimientos
- PHP 7.0 o superior
- MySQL 8.0, MariaDB 10.0 o superior

## Configuración
- Configurar conexión a base de datos en archivo `Connections\conexion.php`
- Configurar servidor de correo electrónico en archivo `mail\mail.php`
- Ejecutar query inicial de BD, que contiene registro de componentes, programas, acciones y metas (opcional) `scripts\script1-bd.sql`