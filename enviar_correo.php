<?php
/**
 * Backend para Formulario de Peticiones de Iglesia Esperanza
 * PHP v7.0+ Compatible
 */

// ==========================================================
// 1. CONFIGURACIÓN PRINCIPAL
// ==========================================================
// Reemplaza el correo de abajo con el tuyo real para recibir las notificaciones
$destinatario = "correo_de_tu_iglesia@gmail.com"; 

$asunto_base = "Buzón Web Iglesia Esperanza";

// ==========================================================
// 2. SEGURIDAD Y PROCESAMIENTO
// ==========================================================
// Solo permitimos procesar si el usuario presionó 'Enviar' (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Capturamos las variables del frontend y limpiamos el texto para evitar hackers
    $nombre = htmlspecialchars(trim($_POST["nombre"] ?? "Hermano/Anónimo"));
    $tipo_mensaje = htmlspecialchars(trim($_POST["tipo_mensaje"] ?? "Mensaje General"));
    $mensaje = htmlspecialchars(trim($_POST["mensaje"] ?? "Sin contenido."));
    
    // ==========================================================
    // 3. ARMADO DEL CORREO
    // ==========================================================
    // Formatear el texto de manera bonita y estructurada para tu lectura
    $cuerpo_correo = "=========================================\n";
    $cuerpo_correo .= "NUEVO MENSAJE DE LA COMUNIDAD WEB\n";
    $cuerpo_correo .= "=========================================\n\n";
    
    $cuerpo_correo .= "MOTIVO: " . strtoupper($tipo_mensaje) . "\n";
    $cuerpo_correo .= "ENVIADO POR: " . $nombre . "\n\n";
    
    $cuerpo_correo .= "----------[ CONTENIDO ]----------\n";
    $cuerpo_correo .= $mensaje . "\n";
    $cuerpo_correo .= "---------------------------------\n\n";
    
    $cuerpo_correo .= "Sistema automatizado de notificaciones web.";

    // Cabeceras estándares de seguridad de correo (SMTP Headers)
    $headers = "From: buzon_automatico@iglesiaesperanza.com" . "\r\n";
    $headers .= "Reply-To: no-reply@iglesiaesperanza.com" . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // ==========================================================
    // 4. FUNCION DE ENVÍO
    // ==========================================================
    // PHP instruye al servidor para que envíe el correo electrónico
    mail($destinatario, $asunto_base . " (" . ucfirst($tipo_mensaje) . ")", $cuerpo_correo, $headers);

    // ==========================================================
    // 5. REDIRECCIÓN UX
    // ==========================================================
    // Devolvemos al usuario inmediatamente a la página sin que note el script
    // Adicionamos el estado 'exito' en la URL para que el JS active la Notificación
    header("Location: index.html?estado=exito#reflexion");
    exit();

} else {
    // Si algún intruso trata de ingresar a este script copiando la URL .php directamente
    // lo regresamos tranquilamente a la página principal.
    header("Location: index.html");
    exit();
}
?>
