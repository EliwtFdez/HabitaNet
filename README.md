# HabitaNet - Sistema de Gestión de Residencias

HabitaNet es un sistema web desarrollado para la gestión integral de residencias y condominios. Permite administrar usuarios, casas, cuotas, pagos y comunicación entre residentes.

## Características Principales

- Gestión de usuarios (administradores, residentes, comité)
- Administración de casas y residentes
- Sistema de facturación y pagos
- Panel de control para el comité
- Área de comunicación y foro
- Gestión de mantenimiento
- Reserva de espacios comunes
- Estado de cuenta en tiempo real

## Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web Apache con mod_rewrite habilitado
- Composer (gestor de dependencias PHP)

## Instalación Local

1. Clonar el repositorio:
```bash
git clone [URL_DEL_REPOSITORIO]
cd HabitaNet
```

2. Instalar dependencias con Composer:
```bash
composer install
```

3. Configurar la base de datos:
   - Crear una base de datos MySQL
   - Importar el archivo de esquema de la base de datos ubicado en `api/db/schema.sql`

4. Configurar el archivo de entorno:
   - Copiar `.env.example` a `.env`
   - Configurar las credenciales de la base de datos y otras variables de entorno

5. Configurar el servidor web:
   - Asegurarse de que el DocumentRoot apunte a la carpeta `public`
   - Verificar que el módulo mod_rewrite esté habilitado

6. Configurar permisos:
```bash
chmod -R 755 public
chmod -R 755 api
```

## Despliegue en Servidor

1. Subir los archivos al servidor:
   - Usar FTP, SFTP o el método preferido para transferir archivos
   - Asegurarse de mantener la estructura de directorios

2. Configurar el servidor web:
   - Configurar el VirtualHost para que apunte a la carpeta `public`
   - Habilitar SSL si es necesario
   - Configurar las reglas de rewrite en el archivo `.htaccess`

3. Configurar la base de datos:
   - Crear la base de datos en el servidor
   - Importar el esquema de la base de datos
   - Actualizar las credenciales en el archivo `.env`

4. Configurar permisos:
```bash
chmod -R 755 public
chmod -R 755 api
```

## Estructura del Proyecto

```
HabitaNet/
├── api/
│   ├── Controllers/     # Controladores de la API
│   ├── Services/        # Servicios de negocio
│   ├── Models/          # Modelos de datos
│   ├── Core/            # Componentes core del sistema
│   └── db/              # Scripts de base de datos
├── public/
│   ├── pages/           # Páginas de la aplicación
│   ├── Components/      # Componentes reutilizables
│   ├── assets/          # Recursos estáticos
│   └── includes/        # Archivos incluidos
└── vendor/              # Dependencias de Composer
```

## Seguridad

- Todas las contraseñas se almacenan de forma segura usando hash
- Las rutas de la API requieren autenticación
- Se implementan tokens CSRF para formularios
- Las sesiones tienen un tiempo de expiración configurado

## Soporte

Para reportar problemas o solicitar soporte, por favor crear un issue en el repositorio del proyecto.

## Licencia
Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.
