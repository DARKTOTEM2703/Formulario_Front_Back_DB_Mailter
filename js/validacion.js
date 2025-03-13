$(document).ready(function () {
  // Esta función se ejecuta cuando el documento HTML ha sido completamente cargado y está listo.
  $("#miFormulario").submit(function (event) {
    // Obtener los valores de los campos de entrada del formulario.
    var nombre = sanitizeInput($("#nombre").val());
    var email = sanitizeInput($("#email").val());
    var celular = sanitizeInput($("#Celular").val());
    var ciudad = sanitizeInput($("#Ciudad").val());
    var localidad = sanitizeInput($("#localidad").val());
    var estado = sanitizeInput($("#Estado").val());
    var colonia = sanitizeInput($("#colonia").val());
    var interes = sanitizeInput($("#interes").val());
    var tipo_persona = sanitizeInput(
      $("input[name='tipo_persona']:checked").val()
    );

    // Patrón para validar el formato del correo electrónico.
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

    // Patrón para detectar posibles inyecciones SQL.
    var sqlPattern =
      /(\b(SELECT|UPDATE|DELETE|INSERT|DROP|ALTER|CREATE|TRUNCATE|EXEC|UNION|GRANT|REVOKE)\b)/i;

    // Patrón para detectar posibles ataques XSS.
    var xssPattern = /(<|>|\"|\'|%|;|\(|\)|&|\+|-)/g;

    // Validar que el campo nombre no esté vacío.
    if (nombre === "") {
      alert("Por favor, ingrese su nombre.");
      event.preventDefault(); // Evitar que el formulario se envíe.
    }
    // Validar que el correo electrónico tenga un formato válido.
    else if (!emailPattern.test(email)) {
      alert("Por favor, ingrese un correo electrónico válido.");
      event.preventDefault(); // Evitar que el formulario se envíe.
    }
    // Validar que no haya inyecciones SQL en los campos nombre y correo electrónico.
    else if (sqlPattern.test(nombre) || sqlPattern.test(email)) {
      alert("Entrada inválida detectada.");
      event.preventDefault(); // Evitar que el formulario se envíe.
    }
    // Validar que no haya ataques XSS en los campos nombre y correo electrónico.
    else if (xssPattern.test(nombre) || xssPattern.test(email)) {
      alert("Entrada inválida detectada.");
      event.preventDefault(); // Evitar que el formulario se envíe.
    }
    // Validar que el correo electrónico no sea una dirección temporal.
    else if (isTemporaryEmail(email)) {
      alert("Por favor, ingrese un correo electrónico válido.");
      event.preventDefault(); // Evitar que el formulario se envíe.
    }
  });

  // Función para sanitizar la entrada del usuario.
  function sanitizeInput(input) {
    return input.replace(/[<>"'%;()&+]/g, "");
  }

  // Función para verificar si el correo electrónico es temporal.
  function isTemporaryEmail(email) {
    var tempEmailDomains = [
      "tempmail.com",
      "10minutemail.com",
      "mailinator.com",
    ];
    var emailDomain = email.split("@")[1];
    return tempEmailDomains.includes(emailDomain);
  }
});
