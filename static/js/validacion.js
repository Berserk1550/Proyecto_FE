
document.addEventListener("DOMContentLoaded", function () {

    const cedulaInput = document.getElementById('documento_emprendedor');
    const mensajeCedula = document.getElementById('mensajeErrorCedula');

    if (!cedulaInput || !mensajeCedula) {
        console.error("ERROR: No se encontró documento_emprendedor o mensajeErrorCedula en el HTML.");
        return;
    }

    cedulaInput.addEventListener('input', async function () {
        const cedula = this.value.trim();

        if (cedula === '' || cedula === null) {
            mensajeCedula.textContent = "El número de identificación no puede estar vacío.";
            mensajeCedula.style.color = "orange";
            mensajeCedula.style.display = "block";
            this.setCustomValidity("Campo vacío");
            return;
        }

        try {
            const response = await fetch(`../models/m_registro.php?documento=${cedula}`);
            const data = await response.text();
            console.log("Respuesta del servidor:", data);

            if (data.includes("ERROR")) {
                mensajeCedula.textContent = "Error en la consulta. Revisa el archivo PHP.";
                mensajeCedula.style.color = "orange";
                mensajeCedula.style.display = "block";
                return;
            }

            if (data === "existe") {
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

});




  //Restriciones para cada tipo de documento
  const tipoDocumentoSelect = document.getElementById('tipo_documento_emprendedor');
  const documentoInput = document.getElementById('documento_emprendedor');

  tipoDocumentoSelect.addEventListener('change', function() {
    const tipoDocumento = this.value;
    if (tipoDocumento === ''|| tipoDocumento === null) {
      mensajeCedula.textContent = "Por favor, selecciona un tipo de documento.";
      mensajeCedula.style.color = "orange";
      mensajeCedula.style.display = "block";
    } else if (tipoDocumento === 'CC') {
      documentoInput.setAttribute('maxlength', '10');
      documentoInput.setAttribute('minlength', '6');
      documentoInput.setAttribute('pattern', '\\d{6,10}');
      documentoInput.setCustomValidity('');
    } else if (tipoDocumento === 'CE') {
      documentoInput.setAttribute('maxlength', '10');
      documentoInput.setAttribute('minlength', '10');
      documentoInput.setAttribute('pattern', '\\d{10}');
      documentoInput.setCustomValidity('');
    } else if (tipoDocumento === 'TI') {
      documentoInput.setAttribute('maxlength', '10');
      documentoInput.setAttribute('minlength', '10');
      documentoInput.setAttribute('pattern', '\\d{10}');
      documentoInput.setCustomValidity('');
    } else if (tipoDocumento === 'PEP') {
      documentoInput.setAttribute('maxlength', '15');
      documentoInput.setAttribute('minlength', '15');
      documentoInput.setAttribute('pattern', '\\d{15}');
      documentoInput.setCustomValidity('');
    } else if (tipoDocumento === 'PAS') {
      documentoInput.setAttribute('maxlength', '20');
      documentoInput.setAttribute('minlength', '6');
      documentoInput.setAttribute('pattern', '[A-Z][0-9]{6,20}');
      documentoInput.setCustomValidity('');
    } else if (tipoDocumento === 'PPT') {
      documentoInput.setAttribute('maxlength', '15');
      documentoInput.setAttribute('minlength', '9');
      documentoInput.setAttribute('pattern', '\\d{9,15}');
      documentoInput.setCustomValidity('');
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
    const patronCorreo = /^[a-zA-Z0-9.\-_]+@[a-z0-9.\-_]+\.[a-z]{2,}$/;

    // Validación en tiempo real
    correoInput.addEventListener('blur', function() {
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
    correoInput.addEventListener('input', function() {
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

