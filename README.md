# Proyecto de Formulario con Validación, Backend y Base de Datos

¡Bienvenido a este increíble proyecto de formulario web! Esta aplicación permite a los usuarios enviar sus datos personales a través de un formulario elegante y funcional. La aplicación incluye validación en el frontend, procesamiento en el backend y almacenamiento en una base de datos. Además, se envía un correo de confirmación al usuario después de enviar el formulario.

## Estructura del Proyecto

- **HTML**: La interfaz de usuario del formulario.
- **CSS**: Estilos para la interfaz de usuario.
- **JavaScript**: Validación del formulario en el frontend.
- **PHP**: Procesamiento del formulario en el backend y envío de correos electrónicos.
- **SQL**: Script para la creación de la base de datos y la tabla correspondiente.
- **.env**: Archivo de configuración para las variables de entorno.

## Validación del Formulario

El archivo `validacion.js` contiene la lógica de validación del formulario. Se asegura de que los campos obligatorios estén completos y que los datos ingresados sean válidos. Las validaciones incluyen:

- Verificación de que los campos no estén vacíos.
- Validación del formato del correo electrónico.
- Detección de posibles inyecciones SQL y ataques XSS.
- Verificación de que el correo electrónico no sea temporal.

## Backend

El archivo `form.php` maneja el procesamiento del formulario en el backend. Sus funciones incluyen:

- Cargar las variables de entorno desde el archivo `.env`.
- Validar los datos recibidos del formulario.
- Conectar a la base de datos y almacenar los datos.
- Enviar un correo de confirmación al usuario utilizando PHPMailer.

## Base de Datos

El archivo `formulario.sql` contiene el script SQL para crear la base de datos y la tabla `formulario`. La tabla almacena los datos enviados por los usuarios, incluyendo:

- Nombre
- Correo electrónico
- Celular
- Ciudad
- Localidad
- Estado
- Colonia
- Área de interés
- Tipo de persona (física o moral)
- Fecha de envío

## Configuración

El archivo `.env` contiene las variables de entorno necesarias para la configuración de la base de datos y el servidor SMTP para el envío de correos electrónicos. Ejemplo de configuración:

```
DB_SERVER=Tu_Servidor
DB_USERNAME=Tu_Usuario
DB_PASSWORD=Tu_Contraseña
DB_NAME=Tu_Base_De_Datos
SMTP_HOST=smtp.gmail.com
SMTP_USERNAME=Tu_correo@gmail.com
SMTP_PASSWORD="tu_contraseña_de_Aplicacion"
SMTP_PORT=587
SMTP_FROM_EMAIL=Tu_correo@gmail.com
SMTP_FROM_NAME="Tu_nombre"
```

## Instrucciones de Instalación

1. Clona el repositorio en tu servidor local:
   ```bash
   git clone https://github.com/DARKTOTEM2703/Formulario_Front_Back_DB_Mailter.git
   ```
2. Ejecuta `composer install` para instalar las dependencias de PHP.
3. Configura el archivo `.env` con tus credenciales de base de datos y SMTP.
4. Importa el archivo `formulario.sql` en tu servidor de base de datos.
5. Abre `index.html` en tu navegador para acceder al formulario.

## Uso

1. Completa el formulario con tus datos personales.
2. Haz clic en "Enviar".
3. Recibirás un correo de confirmación si los datos se han enviado correctamente.

## Créditos

Desarrollado por Jafeth Daniel Gamboa Baas

## Derechos de Autor

© 2025 Jafeth Daniel Gamboa Baas. Todos los derechos reservados. Este proyecto es propiedad del autor y está protegido por las leyes de derechos de autor. No se permite la reproducción, distribución ni modificación sin el permiso expreso del autor.
