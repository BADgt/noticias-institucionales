# Chipi News 치피 📰
### Sistema de Gestión de Noticias - Portal UNSL

Chipi News es una plataforma web desarrollada para la gestión, redacción y validación de noticias universitarias. El sistema cuenta con un flujo de trabajo profesional que separa las funciones de redacción y validación, garantizando la calidad y veracidad del contenido publicado.

Este proyecto cuenta con un enfoque especial en la enseñanza del idioma coreano, permitiendo el soporte completo de caracteres **Unicode (Hangul)** en todas sus publicaciones.

## 🚀 Características Principales

- **Gestión de Roles:** Sistema de permisos diferenciados para Editores y Validadores.
- **Flujo de Trabajo (Workflow):** Control de estados (Borrador, Para Corrección, Lista para Validación, Publicada, Anulada).
- **Seguridad Avanzada:**
  - Protección contra Inyección SQL mediante Sentencias Preparadas.
  - Mitigación de ataques XSS con sanitización de salida.
  - **Segregación de funciones:** Un usuario no puede validar ni aprobar su propio contenido por políticas de transparencia.
- **Soporte Multilingüe:** Validación y almacenamiento compatible con caracteres coreanos (Hangul).
- **Interfaz UX/UI:** Diseño moderno con Bootstrap 5, tarjetas personalizadas y modales de confirmación para acciones críticas.

## 🛠️ Requisitos Técnicos

- **Servidor Web:** Apache (XAMPP / WAMP recomendado).
- **Lenguaje:** PHP 8.0 o superior.
- **Base de Datos:** MySQL / MariaDB (Motor MyISAM).
- **Codificación:** UTF-8 Unicode (Soporte Hangul).

## 📥 Instalación y Configuración

1. **Clonar el repositorio:**
   Descarga o clona este repositorio en tu carpeta local de servidores (ej. `htdocs`).

2. **Importar la Base de Datos:**
   - Accede a phpMyAdmin.
   - Crea una base de datos llamada `noticias_db`.
   - Importa el archivo `noticias_db.sql` que se encuentra en la raíz de este proyecto.

3. **Configurar la Conexión:**
   - Verifica el archivo `config/db.php` y ajusta las credenciales de tu servidor local (host, usuario, contraseña).

4. **Carpeta de Imágenes:**
   - Asegúrate de que la carpeta `uploads/` exista y tenga permisos de escritura para las portadas de las noticias.

## 🔐 Usuarios de Prueba (Ya cargados en la DB)

Para evaluar las funcionalidades, puedes utilizar cualquiera de las siguientes cuentas ya registradas en el sistema:

| Usuario | Email | Contraseña | Rol Asignado |
| :--- | :--- | :--- | :--- |
| **Grace Ashcroft** | `requiem9@gmail.com` | `FBI#123` | Editor - Validador |
| **Leon Scott Kennedy** | `raccoon@gmail.com` | `virus-T#1998` | Validador |
| **Samuel De Luque** | `vegetta777@gmail.com` | `PlanetaVegetta#2012` | Editor - Validador |
| **Rebecca Ford** | `lotus@gmail.com` | `Warframe#2013` | Editor |
| **Brisa Dágata** | `p2usbloco@gmail.com` | `c123456` | Editor |

## 📐 Arquitectura del Proyecto

El sistema utiliza el patrón **Front Controller** (`index.php`), centralizando las peticiones para gestionar la seguridad, sesiones y el enrutamiento de vistas de forma eficiente.

---
**Desarrollado por:** Brisa Ahylin Dágata  
**Carrera:** Tecnicatura Universitaria en Web (TUW) - UNSL
