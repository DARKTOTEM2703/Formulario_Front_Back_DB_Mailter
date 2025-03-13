<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verificar si el archivo autoload.php existe
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    die("Error: El archivo 'vendor/autoload.php' no existe. Ejecuta 'composer install' para instalar las dependencias.");
}

require __DIR__ . '/../vendor/autoload.php';

// Verificar si el archivo .env existe
if (!file_exists(__DIR__ . '/../.env')) { // Cambiar la ruta aquí
    die("Error: El archivo '.env' no existe.");
}

// Cargar variables de entorno con manejo de excepciones
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..'); // Cambiar la ruta aquí
    $dotenv->load();
} catch (Dotenv\Exception\InvalidFileException $e) {
    die("Error al cargar el archivo .env: " . $e->getMessage());
}

// Verificar que las variables de entorno se han cargado correctamente
if (!isset($_ENV['DB_SERVER']) || !isset($_ENV['SMTP_HOST'])) {
    die("Error: Variables de entorno no cargadas correctamente.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $celular = trim($_POST['Celular']);
    $ciudad = trim($_POST['Ciudad']);
    $localidad = trim($_POST['localidad']);
    $estado = trim($_POST['Estado']);
    $colonia = trim($_POST['colonia']);
    $interes = trim($_POST['interes']);
    $tipo_persona = trim($_POST['tipo_persona']);

    // Validaciones
    if (empty($nombre) || empty($correo) || empty($celular) || empty($interes) || empty($tipo_persona)) {
        die("Por favor, complete todos los campos obligatorios.");
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        die("Formato de correo electrónico no válido.");
    }
    if (!preg_match('/^[0-9]{10}$/', $celular)) {
        die("Formato de número de celular no válido.");
    }

    // Conectar a la base de datos
    $servername = $_ENV['DB_SERVER'];
    $username = $_ENV['DB_USERNAME'];
    $password = $_ENV['DB_PASSWORD'];
    $dbname = $_ENV['DB_NAME'];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO formulario (nombre, correo, celular, ciudad, localidad, estado, colonia, interes, tipo_persona) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error en la preparación de la declaración: " . $conn->error);
    }
    $stmt->bind_param("sssssssss", $nombre, $correo, $celular, $ciudad, $localidad, $estado, $colonia, $interes, $tipo_persona);

    if ($stmt->execute()) {
        echo "Datos guardados correctamente.<br>";

        // Configurar PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USERNAME'];
            $mail->Password = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['SMTP_PORT'];

            $mail->setFrom($_ENV['SMTP_FROM_EMAIL'], $_ENV['SMTP_FROM_NAME']);
            $mail->addAddress($correo, $nombre); // Destinatario

            $mail->isHTML(true);
            $mail->Subject = "Confirmación de recepción de datos";
            $mail->Body = "<p>Hola <b>$nombre</b>,<br><br>Hemos recibido tus datos correctamente. Nos pondremos en contacto contigo lo más pronto posible.<br><br>Gracias.</p>";

            // Enviar correo
            if ($mail->send()) {
                echo "Correo de confirmación enviado.";
            } else {
                echo "Error al enviar el correo: " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo} <br> Exception: " . $e->getMessage();
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>