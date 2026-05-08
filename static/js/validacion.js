function enviarCedula() {

    const campo = document.getElementById("documento_emprendedor");

    const mensajeCedula = document.getElementById("mensajeErrorDocumento");

    campo.addEventListener('keyup', (evento_num) => {

        if (campo.value.length >= 6 && campo.value.length <= 15) {

            fetch('../controller/registro.php', {
                method: "POST",
                body: new URLSearchParams({action: 'validar', emprendedor: campo.value}),
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
            })
                .then(respuesta => respuesta.json())
                .then(emprendedor => {

                    console.log("Respuesta del servidor:", emprendedor);

                    if (emprendedor.existe === true) {
                        console.log("El documento YA existe:", emprendedor.documento);
                        mensajeCedula.textContent = "Este número ya está registrado";
                        mensajeCedula.style.color = "red";
                        mensajeCedula.style.display = "block";
                    }
                    else if (emprendedor.existe === false) {
                        console.log("Documento disponible:", emprendedor.documento);
                        mensajeCedula.textContent = "Documento disponible";
                        mensajeCedula.style.color = "green";
                        mensajeCedula.style.display = "block";

                    }
                })
                .catch(err => console.error("Error en fetch:", err));
        }
    });
}

function validarTipoDocumento() {

    //Restriciones para cada tipo de documento
    const tipoDocumentoSelect2 = document.getElementById('tipo_documento_emprendedor');
    const documentoInput = document.getElementById('documento_emprendedor');
    const mensaje = document.getElementById('mensajeErrorDocumento');

    tipoDocumentoSelect2.addEventListener('change', () => {
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
            documentoInput.setAttribute('pattern', '^[A-Z]{1,3}[0-9]{5,14}$');
            documentoInput.setAttribute('title', 'Debe iniciar con una letra mayúscula seguida de 5 a 14 números');
        }

        if (tipoDocumento == "PPT") {
            documentoInput.setAttribute('pattern', '^[0-9]{7,8}$');
            documentoInput.setAttribute('title', 'Debe contener entre 7 y 8 dígitos');
        }
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
                mensaje.style.color = "red";
            }
        })
    });

}

function validarCorreo() {

    //variables
    const correoInput = document.getElementById('correo_emprendedor');
    const mensajeErrorCorreo = document.getElementById('mensajeErrorCorreo');

    //extensiones principales válidas
    const extensionesValidas = ['com', 'es', 'org', 'net', 'info', 'biz', 'tv', 'io', 'app', 'dev', 'edu', 'gov', 'mil', 'int'];

    //extensiones mini que requieren una principal antes
    const extensionesMini = [
        'co', 'mx', 'ar', 've', 'pe', 'cl', 'br', 'uy', 'py', 'ec', 'bo', 'gt', 'hn', 'ni', 'sv', 'pa', 'do', 'cu', 'pr', 'cr',
        'uk', 'nz', 'au', 'in', 'cn', 'jp', 'kr', 'th', 'ph', 'sg', 'id', 'my', 'vn', 'za', 'eg', 'ng', 'ke', 'gh', 'tz', 'pk',
        'bd', 'ir', 'sa', 'ae', 'jo', 'il', 'tr', 'gr', 'it', 'fr', 'de', 'nl', 'be', 'ch', 'at', 'se', 'no', 'dk', 'fi', 'pl',
        'cz', 'hu', 'ro', 'ua', 'ru'
    ];

    //regex base mejorado
    const patronCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Za-z]{2,}$/;

    if (!correoInput || !mensajeErrorCorreo) return;

    //evento blur
    correoInput.addEventListener('blur', () => {

        const correo = correoInput.value.trim();

        if (correo === '') {
            mensajeErrorCorreo.style.display = 'none';
            correoInput.setCustomValidity('');
            return;
        }

        //validación patrón base
        if (!patronCorreo.test(correo)) {
            correoInput.setCustomValidity('Correo inválido');
            mensajeErrorCorreo.textContent = 'Formato inválido. Ej: soyemprendedor@gmail.com. Solo minúsculas y sin caracteres especiales.';
            mensajeErrorCorreo.style.display = 'block';
            return;
        }

        //extraer partes
        const partes = correo.split('@');
        if (partes.length < 2) {
            mensajeErrorCorreo.textContent = 'El correo debe contener un dominio válido después de @';
            mensajeErrorCorreo.style.display = 'block';
            correoInput.setCustomValidity('Dominio inválido');
            return;
        }

        const dominioCompleto = partes[1];
        const partesDominio = dominioCompleto.split('.');

        if (partesDominio.length < 2) {
            mensajeErrorCorreo.textContent = 'El correo debe contener una extensión válida después del punto';
            mensajeErrorCorreo.style.display = 'block';
            correoInput.setCustomValidity('Extensión inválida');
            return;
        }

        const extension = partesDominio.pop().toLowerCase();
        const extensionAnterior = partesDominio[partesDominio.length - 1]?.toLowerCase();

        //validar extensión
        if (extension === 'con') {
            mensajeErrorCorreo.textContent = 'La extensión ".con" no es válida. ¿Quiso decir ".com"?';
            mensajeErrorCorreo.style.display = 'block';
            correoInput.setCustomValidity('Extensión inválida');
            return;
        }

        if (extension.length < 2 || extension.length > 6) {
            mensajeErrorCorreo.textContent = 'La extensión debe tener entre 2 y 6 caracteres.';
            mensajeErrorCorreo.style.display = 'block';
            correoInput.setCustomValidity('Extensión inválida');
            return;
        }

        //extensiones mini
        if (extensionesMini.includes(extension)) {

            if (partesDominio.length < 1) {
                mensajeErrorCorreo.textContent = `".${extension}" requiere una extensión principal antes. Ej: ejemplo.com.${extension}`;
                mensajeErrorCorreo.style.display = 'block';
                correoInput.setCustomValidity('Extensión incompleta');
                return;
            }

            if (!extensionesValidas.includes(extensionAnterior)) {
                mensajeErrorCorreo.textContent = `Antes de ".${extension}" debe haber una extensión válida (com, org, net, etc.)`;
                mensajeErrorCorreo.style.display = 'block';
                correoInput.setCustomValidity('Extensión anterior inválida');
                return;
            }
        }

        //extensiones normales
        if (!extensionesMini.includes(extension) && !extensionesValidas.includes(extension)) {
            mensajeErrorCorreo.textContent = `La extensión ".${extension}" no es válida. Permitidas: ${extensionesValidas.join(', ')}`;
            mensajeErrorCorreo.style.display = 'block';
            correoInput.setCustomValidity('Extensión no permitida');
            return;
        }

        //todo válido
        correoInput.setCustomValidity('');
        mensajeErrorCorreo.style.display = 'none';
    });

    //evento input (limpiar errores)
    correoInput.addEventListener('input', () => {
        mensajeErrorCorreo.style.display = 'none';
        correoInput.setCustomValidity('');
    });
}


document.addEventListener("DOMContentLoaded", () => {

    if (document.getElementById("documento_emprendedor")) {
        enviarCedula();
    }

    if (document.getElementById("tipo_documento_emprendedor")) {
        validarTipoDocumento();
    }

    if (document.getElementById("correo_emprendedor")) {
        validarCorreo();
    }

});
