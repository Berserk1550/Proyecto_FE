
//validacion de cedula si existe en la base de datos
const cedulaInput = document.getElementById('documento_emprendedor');
const mensajeCedula = document.getElementById('mensajeErrorCedula');

cedulaInput.addEventListener('input', async function () {
  const cedula = this.value.trim();

  if (cedula === '') return;

  try {
    const response = await fetch(`../models/m_registro.php?numero_id=${cedula}`);
    const data = await response.text();
    console.log("Respuesta del servidor:", data);
    // Detectar errores del PHP
    if (data.includes("ERROR")) {
      mensajeCedula.textContent = "Error en la consulta. Revisa el archivo PHP.";
      mensajeCedula.style.color = "orange";
      mensajeCedula.style.display = "block";
      console.error("Respuesta del servidor:", data);
      return;
    }

    if (data === "EXISTE") {
      mensajeCedula.textContent = "Este número de identificación ya está registrado.";
      mensajeCedula.style.color = "red";
      mensajeCedula.style.display = "block";
      this.setCustomValidity("Duplicado");
    } else {
      mensajeCedula.textContent = "Número de identificación disponible.";
      mensajeCedula.style.color = "green";
      mensajeCedula.style.display = "block";
      this.setCustomValidity("");
    }

  } catch (error) {
    console.error("Error en la validación:", error);
    mensajeCedula.textContent = "No se pudo conectar con el servidor.";
    mensajeCedula.style.color = "orange";
    mensajeCedula.style.display = "block";
  }
});

//Restriciones para cada tipo de documento
const tipoDocumentoSelect = document.getElementById('tipo_documento_emprendedor');
const documentoInput = document.getElementById('documento_emprendedor');
const mensaje = document.getElementById('mensajeErrorDocumento');

tipoDocumentoSelect.addEventListener('change', function () {
  const tipoDocumento = this.value;

  if (tipoDocumento == "CC" || tipoDocumento == "CE") {
    documentoInput.setAttribute('pattern', '^[0-9]{6,10}$');
    documentoInput.setAttribute('title', 'Debe contener entre 6 y 10 dígitos');
  }

  if (tipoDocumento == "TI") {
    documentoInput.setAttribute('pattern', '^[0-9]{10}$');
    documentoInput.setAttribute('title', 'Debe contener 10 dígitos');
  }

  if (tipoDocumento == "PEP") {
    documentoInput.setAttribute('pattern', '^[0-9]{15}$');
    documentoInput.setAttribute('title', 'Debe contener 15 dígitos');
  }

  if (tipoDocumento == "PAS") {
    documentoInput.setAttribute('pattern', '^[A-Z][0-9]{5,14}$');
    documentoInput.setAttribute('title', 'Debe iniciar con una letra mayúscula seguida de 5 a 14 números');
  }

  if (tipoDocumento == "PPT") {
    documentoInput.setAttribute('pattern', '^[0-9]{7,8}$');
    documentoInput.setAttribute('title', 'Debe contener entre 7 y 8 dígitos');
  }
});

// Validación en tiempo real
documentoInput.addEventListener('input', () => {
  const patron = documentoInput.getAttribute('pattern');
  if (!patron) return;

  const regex = new RegExp(patron);
  if (regex.test(documentoInput.value)) {
    documentoInput.style.borderColor = "green";
    mensaje.textContent = "Formato válido";
    mensaje.style.color = "green";
    mensaje.style.display = "none";
  } else {
    documentoInput.style.borderColor = "red";
    mensaje.textContent = "Formato incorrecto";
    mensaje.style.display = "block";
  }
});



//Validacion de correo eletronico
const correoInput = document.getElementById('correo_emprendedor');
const mensajeErrorCorreo = document.getElementById('mensajeErrorCorreo');

if (correoInput && mensajeErrorCorreo) {
  // Extensiones comunes permitidas
  const extensionesValidas = ['com', 'es', 'org', 'net', 'info', 'biz', 'tv', 'io', 'app', 'dev', 'edu', 'gov', 'mil', 'int'];
  // Extensiones de nivel 2 (mini) que requieren extensión principal antes
  const extensionesMini = ['co', 'mx', 'ar', 've', 'pe', 'cl', 'br', 'uy', 'py', 'ec', 'bo', 'gt', 'hn', 'ni', 'sv', 'pa', 'do', 'cu', 'pr', 'cr', 'uk', 'nz', 'au', 'in', 'cn', 'jp', 'kr', 'th', 'ph', 'sg', 'id', 'my', 'vn', 'za', 'eg', 'ng', 'ke', 'gh', 'tz', 'pk', 'bd', 'ir', 'sa', 'ae', 'jo', 'il', 'tr', 'gr', 'it', 'fr', 'de', 'nl', 'be', 'ch', 'at', 'se', 'no', 'dk', 'fi', 'pl', 'cz', 'hu', 'ro', 'ua', 'ru'];

  // Patrón de validación de correo base
  const patronCorreo = /^[a-zA-Z0-9.\-_]+@[a-z0-9.\-_]+\.[a-z]{2}$/;

  // Validación en tiempo real
  correoInput.addEventListener('blur', function () {
    const correo = this.value.trim();

    if (correo === '') {
      mensajeErrorCorreo.style.display = 'none';
      this.setCustomValidity('');
      return;
    }

    // Validar contra el patrón básico
    if (!patronCorreo.test(correo)) {
      this.setCustomValidity('Correo inválido');
      mensajeErrorCorreo.textContent = 'El correo debe tener un formato válido. Ej: soyemprendedor@gmail.com';
      mensajeErrorCorreo.style.display = 'block';
      return;
    }

    // Validar dominio
    const dominio = correo.split('@')[1].split('.')[0].toLowerCase();
    if (!dominio || dominio === '') {
      mensajeErrorCorreo.textContent = 'El correo debe contener un dominio válido después de @';
      mensajeErrorCorreo.style.display = 'block';
      this.setCustomValidity('Dominio inválido');
      return;
    }

    // Extraer y validar extensión
    const extension = correo.split('.').pop().toLowerCase();

    if (!extension || extension === '') {
      mensajeErrorCorreo.textContent = 'El correo debe contener una extensión válida después del último punto';
      mensajeErrorCorreo.style.display = 'block';
      this.setCustomValidity('Extensión inválida');
      return;
    }

    if (extension.length < 2) {
      mensajeErrorCorreo.textContent = 'La extensión debe tener al menos 2 caracteres';
      mensajeErrorCorreo.style.display = 'block';
      this.setCustomValidity('Extensión demasiado corta');
      return;
    }

    if (extension.length > 6) {
      mensajeErrorCorreo.textContent = 'La extensión no debe exceder 6 caracteres';
      mensajeErrorCorreo.style.display = 'block';
      this.setCustomValidity('Extensión demasiado larga');
      return;
    }

    if (extension === 'con') {
      mensajeErrorCorreo.textContent = 'La extensión ".con" no es válida. ¿Quiso decir ".com"?';
      mensajeErrorCorreo.style.display = 'block';
      this.setCustomValidity('Extensión inválida');
      return;
    }

    // Validar extensiones mini (requieren extensión principal antes)
    if (extensionesMini.includes(extension)) {
      const partesDominio = correo.split('@')[1].split('.');
      if (partesDominio.length < 3) {
        mensajeErrorCorreo.textContent = `La extensión ".${extension}" requiere una extensión principal antes (ej: ejemplo.com.${extension})`;
        mensajeErrorCorreo.style.display = 'block';
        this.setCustomValidity('Extensión incompleta');
        return;
      }
      // Validar que la extensión anterior sea válida
      const extensionAnterior = partesDominio[partesDominio.length - 2].toLowerCase();
      if (!extensionesValidas.includes(extensionAnterior)) {
        mensajeErrorCorreo.textContent = `Antes de ".${extension}" debe haber una extensión válida (com, org, net, etc.)`;
        mensajeErrorCorreo.style.display = 'block';
        this.setCustomValidity('Extensión anterior inválida');
        return;
      }
    }

    // Validar extensión si no es mini
    if (!extensionesMini.includes(extension) && !extensionesValidas.includes(extension)) {
      mensajeErrorCorreo.textContent = `La extensión ".${extension}" no es válida. Extensiones permitidas: ${extensionesValidas.join(', ')}`;
      mensajeErrorCorreo.style.display = 'block';
      this.setCustomValidity('Extensión no permitida');
      return;
    }

    // Todo válido
    this.setCustomValidity('');
    mensajeErrorCorreo.style.display = 'none';
  });

  // Limpiar mensaje de error al escribir
  correoInput.addEventListener('input', function () {
    if (this.value.trim() === '') {
      mensajeErrorCorreo.style.display = 'none';
      this.setCustomValidity('');
    } else if (patronCorreo.test(this.value.trim())) {
      const extension = this.value.trim().split('.').pop().toLowerCase();
      if (extensionesValidas.includes(extension) || extensionesMini.includes(extension)) {
        mensajeErrorCorreo.style.display = 'none';
        this.setCustomValidity('');
      }
    }
  });
};

