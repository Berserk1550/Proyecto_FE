document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formulario');
    const fases = [
        document.getElementById('fase_1'),
        document.getElementById('fase_2'),
        document.getElementById('fase_3'),
        document.getElementById('fase_4'),
        document.getElementById('fase_5'),
        document.getElementById('fase_6')
    ];
    const pasos = Array.from(document.querySelectorAll('#caja_progreso .step'));
    const barraLleno = document.getElementById('progreso_total-fill');

    if (!form || fases.length === 0 || pasos.length === 0) {
        console.error('Elementos del formulario no encontrados');
        return;
    }

    let faseActual = 0;

    function actualizarProgreso() {
        // Mostrar/ocultar fases
        fases.forEach((fase, index) => {
            if (fase) {
                fase.style.display = index === faseActual ? 'block' : 'none';
            }
        });

        // Actualizar pasos activos
        pasos.forEach((paso, index) => {
            if (index === faseActual) {
                paso.classList.add('active');
            } else {
                paso.classList.remove('active');
            }
        });

        // Actualizar barra de progreso
        if (barraLleno) {
            const porcentaje = ((faseActual + 1) / fases.length) * 100;
            barraLleno.style.width = `${porcentaje}%`;
        }

        // Enfocar primer input
        const primeraFase = fases[faseActual];
        if (primeraFase) {
            const primerCampo = primeraFase.querySelector('input, select, textarea');
            if (primerCampo) {
                primerCampo.focus();
            }
        }
    }

    function validarFaseActual() {
        const fase = fases[faseActual];
        if (!fase) return true;

        const campos = Array.from(fase.querySelectorAll('input, select, textarea')).filter(
            (campo) => campo.hasAttribute('required') && campo.offsetParent !== null
        );

        for (const campo of campos) {
            if (!campo.checkValidity()) {
                campo.reportValidity();
                campo.focus();
                return false;
            }
        }
        return true;
    }

    // Manejar visibilidad dinámica de campos de carrera
    const nivelFormacion = document.getElementById('nivel_formacion');
    const camposCarrera = {
        'Técnico': document.getElementById('carrera_tecnico'),
        'Tecnólogo': document.getElementById('carrera_tecnologo'),
        'Operario': document.getElementById('carrera_operario'),
        'Auxiliar': document.getElementById('carrera_auxiliar'),
        'Profesional': document.getElementById('carrera_profesional'),
        'Especialización': document.getElementById('posgrado_especializacion'),
        'Maestría': document.getElementById('posgrado_maestria'),
        'Doctorado': document.getElementById('posgrado_doctorado')
    };

    function actualizarCarrerasVisibles() {
        if (!nivelFormacion) return;

        const nivelSeleccionado = nivelFormacion.value;

        // Ocultar todos los campos de carrera
        Object.values(camposCarrera).forEach(campo => {
            if (campo) {
                campo.style.display = 'none';
                campo.removeAttribute('required');
            }
        });

        // Mostrar el campo de carrera correspondiente
        if (camposCarrera[nivelSeleccionado]) {
            camposCarrera[nivelSeleccionado].style.display = 'block';
            camposCarrera[nivelSeleccionado].setAttribute('required', 'required');
        }
    }

    if (nivelFormacion) {
        nivelFormacion.addEventListener('change', actualizarCarrerasVisibles);
    }

    // Manejar visibilidad dinámica de campos de posgrado
    const carreraProf = document.getElementById('carrera_profesional');
    if (carreraProf) {
        carreraProf.addEventListener('change', function () {
            // La lógica para mostrar/ocultar especializaciones se maneja arriba
        });
    }

    // Manejar tipo_emprendedor para llenar número de ficha automáticamente
    const tipoEmprendedor = document.getElementById('tipo_emprendedor');
    const numeroFicha = document.getElementById('numero_ficha');

    if (tipoEmprendedor) {
        tipoEmprendedor.addEventListener('change', function () {
            if (this.value === 'No cuenta con formación' || this.value === 'Otro') {
                numeroFicha.value = 'No aplica';
                numeroFicha.disabled = true;
                numeroFicha.removeAttribute('required');
            } else {
                numeroFicha.value = '';
                numeroFicha.disabled = false;
                numeroFicha.setAttribute('required', 'required');
            }
        });
    }

    // Función para ordenar alfabéticamente los selects
    function ordenarSelectsAlfabeticamente() {
        const selectsParaOrdenar = [
            'clasificacion',
            'discapacidad',
            'tipo_emprendedor',
            'nivel_formacion',
            'carrera_tecnico',
            'carrera_tecnologo',
            'carrera_operario',
            'carrera_auxiliar',
            'carrera_profesional',
            'posgrado_especializacion',
            'posgrado_maestria',
            'posgrado_doctorado',
            'situacion_negocio',
            'programa',
            'ejercer_actividad_proyecto',
            'empresa_formalizada',
            'centro_orientacion',
            'orientador',
            'departamento'
        ];

        selectsParaOrdenar.forEach(selectId => {
            const select = document.getElementById(selectId);
            if (!select) return;

            // Separar opciones con optgroup
            const conOptgroup = [];
            let opcionesActuales = [];

            // Procesar todos los hijos del select
            Array.from(select.children).forEach((child, index) => {
                if (child.tagName === 'OPTION') {
                    if (index === 0) return; // Saltar la primera opción (placeholder)
                    opcionesActuales.push(child);
                } else if (child.tagName === 'OPTGROUP') {
                    if (opcionesActuales.length > 0) {
                        conOptgroup.push({ opciones: opcionesActuales, grupo: null });
                        opcionesActuales = [];
                    }
                    const grupo = child.label;
                    const opcionesDelGrupo = Array.from(child.querySelectorAll('option'));
                    conOptgroup.push({ opciones: opcionesDelGrupo, grupo: grupo });
                }
            });

            if (opcionesActuales.length > 0) {
                conOptgroup.push({ opciones: opcionesActuales, grupo: null });
            }

            // Ordenar las opciones alfabéticamente
            conOptgroup.forEach(item => {
                item.opciones.sort((a, b) => a.text.localeCompare(b.text, 'es'));
            });

            // Limpiar el select manteniendo solo la primera opción
            while (select.children.length > 1) {
                select.children[1].remove();
            }

            // Reconstruir el select con opciones ordenadas
            conOptgroup.forEach(item => {
                if (item.grupo) {
                    const optgroup = document.createElement('optgroup');
                    optgroup.label = item.grupo;
                    item.opciones.forEach(opcion => {
                        optgroup.appendChild(opcion);
                    });
                    select.appendChild(optgroup);
                } else {
                    item.opciones.forEach(opcion => {
                        select.appendChild(opcion);
                    });
                }
            });
        });
    }

    // Event listeners para botones de navegación
    document.addEventListener('click', (e) => {
        // Botón siguiente
        if (e.target.id.startsWith('btn_fase')) {
            const numero = parseInt(e.target.id.replace('btn_fase', ''));
            if (numero - 1 === faseActual) {
                if (validarFaseActual()) {
                    if (faseActual < fases.length - 1) {
                        faseActual += 1;
                        actualizarProgreso();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                }
            }
        }

        // Botón volver
        if (e.target.id === 'btn_volver' || e.target.closest('#btn_volver')) {
            if (faseActual > 0) {
                faseActual -= 1;
                actualizarProgreso();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    });

    const enviar_formulario = document.getElementById('btn_fase6');
    // Envío del formulario
    form.addEventListener('submit', (event) => {
        event.preventDefault();

        if (validarFaseActual()) {
            console.log('Formulario válido, enviando...');

            // Crear objeto FormData con todos los campos del formulario
            const formData = new FormData(form);

            // Enviar al controlador con fetch
            fetch('../controller/registro.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    console.log('Respuesta del servidor:', data);
                    alert('Registro guardado correctamente');
                })
                .catch(error => {
                    console.error('Error al enviar:', error);
                });
        }
    });

    // Inicializar
    actualizarProgreso();
    ordenarSelectsAlfabeticamente();

    // Establecer restricciones de fecha en el campo de nacimiento
    const campoFecha = document.getElementById('fecha_nacimiento_emprendedor');
    if (campoFecha) {
        const hoy = new Date();
        const desde15anos = new Date(hoy.getFullYear() - 15, hoy.getMonth(), hoy.getDate());
        const hasta100anos = new Date(desde15anos.getFullYear() - 100, desde15anos.getMonth(), desde15anos.getDate());

        // Formato YYYY-MM-DD para HTML5 date input
        const formatoFecha = (fecha) => fecha.toISOString().split('T')[0];

        campoFecha.max = formatoFecha(desde15anos);
        campoFecha.min = formatoFecha(hasta100anos);

        // Hacer clickeable el input de fecha para abrir el datepicker
        campoFecha.addEventListener('click', function () {
            this.showPicker();
        });

        // También permitir que se abra con focus
        campoFecha.addEventListener('focus', function () {
            this.showPicker();
        });
    }

    //                     |||||||||||||| VALIDACION DE CORREO ELETRONICO ||||||||||||||||||||
    const correoInput = document.getElementById('correo_emprendedor');
    const mensajeErrorCorreo = document.getElementById('mensajeErrorCorreo');

    if (correoInput && mensajeErrorCorreo) {
        // Extensiones comunes permitidas
        const extensionesValidas = ['com', 'es', 'org', 'net', 'info', 'biz', 'tv', 'io', 'app', 'dev', 'edu', 'gov', 'mil', 'int'];
        // Extensiones de nivel 2 (mini) que requieren extensión principal antes
        const extensionesMini = ['co', 'mx', 'ar', 've', 'pe', 'cl', 'br', 'uy', 'py', 'ec', 'bo', 'gt', 'hn', 'ni', 'sv', 'pa', 'do', 'cu', 'pr', 'cr', 'uk', 'nz', 'au', 'in', 'cn', 'jp', 'kr', 'th', 'ph', 'sg', 'id', 'my', 'vn', 'za', 'eg', 'ng', 'ke', 'gh', 'tz', 'pk', 'bd', 'ir', 'sa', 'ae', 'jo', 'il', 'tr', 'gr', 'it', 'fr', 'de', 'nl', 'be', 'ch', 'at', 'se', 'no', 'dk', 'fi', 'pl', 'cz', 'hu', 'ro', 'ua', 'ru'];

        // Patrón de validación de correo base
        const patronCorreo = /^[a-zA-Z0-9.\-_]+@[a-zA-Z0-9.\-_]+\.[a-z]{2,}$/;

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
    }
});

// API para países y nacionalidades
function cargarPaises() {
    const paisSelect = document.getElementById("paises");

    if (!paisSelect) {
        console.error('Elemento #paises no encontrado en el DOM');
        return;
    }

    // Lista de países y gentilicios (sin API externa)
    const paises = [
        { nombre: "Colombia", gentilicio: "Colombiano/a" },
        { nombre: "Afganistán", gentilicio: "Afgano/a" },
        { nombre: "Albania", gentilicio: "Albanés/a" },
        { nombre: "Alemania", gentilicio: "Alemán/a" },
        { nombre: "Andorra", gentilicio: "Andorrano/a" },
        { nombre: "Angola", gentilicio: "Angoleño/a" },
        { nombre: "Antigua y Barbuda", gentilicio: "Antiguano/a" },
        { nombre: "Arabia Saudita", gentilicio: "Saudí/a" },
        { nombre: "Argelia", gentilicio: "Argelino/a" },
        { nombre: "Argentina", gentilicio: "Argentino/a" },
        { nombre: "Armenia", gentilicio: "Armenio/a" },
        { nombre: "Australia", gentilicio: "Australiano/a" },
        { nombre: "Austria", gentilicio: "Austriaco/a" },
        { nombre: "Azerbaiyán", gentilicio: "Azerbaiyano/a" },
        { nombre: "Bahamas", gentilicio: "Bahamense" },
        { nombre: "Bangladés", gentilicio: "Bangladesí" },
        { nombre: "Barbados", gentilicio: "Barbadense" },
        { nombre: "Baréin", gentilicio: "Bareiní" },
        { nombre: "Bélgica", gentilicio: "Belga" },
        { nombre: "Belice", gentilicio: "Beliceño/a" },
        { nombre: "Benín", gentilicio: "Beninés/a" },
        { nombre: "Bielorrusia", gentilicio: "Bielorruso/a" },
        { nombre: "Birmania", gentilicio: "Birmano/a" },
        { nombre: "Bolivia", gentilicio: "Boliviano/a" },
        { nombre: "Bosnia y Herzegovina", gentilicio: "Bosnio/a" },
        { nombre: "Botsuana", gentilicio: "Botsuano/a" },
        { nombre: "Brasil", gentilicio: "Brasileño/a" },
        { nombre: "Brunéi", gentilicio: "Bruneano/a" },
        { nombre: "Bulgaria", gentilicio: "Búlgaro/a" },
        { nombre: "Burkina Faso", gentilicio: "Burkinés/a" },
        { nombre: "Burundi", gentilicio: "Burundés/a" },
        { nombre: "Bután", gentilicio: "Butanés/a" },
        { nombre: "Cabo Verde", gentilicio: "Caboverdiano/a" },
        { nombre: "Camboya", gentilicio: "Camboyano/a" },
        { nombre: "Camerún", gentilicio: "Camerunés/a" },
        { nombre: "Canadá", gentilicio: "Canadiense" },
        { nombre: "Catar", gentilicio: "Catarí" },
        { nombre: "Chad", gentilicio: "Chadiano/a" },
        { nombre: "Chile", gentilicio: "Chileno/a" },
        { nombre: "China", gentilicio: "Chino/a" },
        { nombre: "Chipre", gentilicio: "Chipriota" },
        { nombre: "Ciudad del Vaticano", gentilicio: "Vaticano" },
        { nombre: "Comoras", gentilicio: "Comorense" },
        { nombre: "Congo", gentilicio: "Congoleño/a" },
        { nombre: "Corea del Norte", gentilicio: "Norcoreano/a" },
        { nombre: "Corea del Sur", gentilicio: "Surcoreano/a" },
        { nombre: "Costa de Marfil", gentilicio: "Marfileño/a" },
        { nombre: "Costa Rica", gentilicio: "Costarricense" },
        { nombre: "Croacia", gentilicio: "Croata" },
        { nombre: "Cuba", gentilicio: "Cubano/a" },
        { nombre: "Curazao", gentilicio: "Curazaleño/a" },
        { nombre: "Dinamarca", gentilicio: "Danés/a" },
        { nombre: "Dominica", gentilicio: "Dominiqués/a" },
        { nombre: "Ecuador", gentilicio: "Ecuatoriano/a" },
        { nombre: "Egipto", gentilicio: "Egipcio/a" },
        { nombre: "El Salvador", gentilicio: "Salvadoreño/a" },
        { nombre: "Emiratos Árabes Unidos", gentilicio: "Emiratí" },
        { nombre: "Eritrea", gentilicio: "Eritreo/a" },
        { nombre: "Eslovaquia", gentilicio: "Eslovaco/a" },
        { nombre: "Eslovenia", gentilicio: "Esloveno/a" },
        { nombre: "España", gentilicio: "Español/a" },
        { nombre: "Estados Unidos", gentilicio: "Estadounidense" },
        { nombre: "Estonia", gentilicio: "Estonio/a" },
        { nombre: "Etiopía", gentilicio: "Etíope" },
        { nombre: "Filipinas", gentilicio: "Filipino/a" },
        { nombre: "Finlandia", gentilicio: "Finlandés/a" },
        { nombre: "Fiji", gentilicio: "Fiyiano/a" },
        { nombre: "Francia", gentilicio: "Francés/a" },
        { nombre: "Gabón", gentilicio: "Gabonés/a" },
        { nombre: "Gambia", gentilicio: "Gambiano/a" },
        { nombre: "Georgia", gentilicio: "Georgiano/a" },
        { nombre: "Ghana", gentilicio: "Ghanés/a" },
        { nombre: "Gibraltar", gentilicio: "Gibraltareño/a" },
        { nombre: "Grecia", gentilicio: "Griego/a" },
        { nombre: "Granada", gentilicio: "Granadino/a" },
        { nombre: "Groenlandia", gentilicio: "Groenlandés/a" },
        { nombre: "Guadalupe", gentilicio: "Guadalupeño/a" },
        { nombre: "Guam", gentilicio: "Guameño/a" },
        { nombre: "Guatemala", gentilicio: "Guatemalteco/a" },
        { nombre: "Guayana Francesa", gentilicio: "Guayanés/a" },
        { nombre: "Guernsey", gentilicio: "Guernesiano/a" },
        { nombre: "Guinea", gentilicio: "Guineo/a" },
        { nombre: "Guinea Ecuatorial", gentilicio: "Ecuatoguineano/a" },
        { nombre: "Guinea-Bisáu", gentilicio: "Guineano/a" },
        { nombre: "Guyana", gentilicio: "Guyanes/a" },
        { nombre: "Haití", gentilicio: "Haitiano/a" },
        { nombre: "Holanda", gentilicio: "Holandés/a" },
        { nombre: "Honduras", gentilicio: "Hondureño/a" },
        { nombre: "Hong Kong", gentilicio: "Hongkonés/a" },
        { nombre: "Hungría", gentilicio: "Húngaro/a" },
        { nombre: "India", gentilicio: "Indio/a" },
        { nombre: "Indonesia", gentilicio: "Indonesio/a" },
        { nombre: "Irak", gentilicio: "Iraquí" },
        { nombre: "Irán", gentilicio: "Iraní" },
        { nombre: "Irlanda", gentilicio: "Irlandés/a" },
        { nombre: "Irlanda del Norte", gentilicio: "Norirlandés/a" },
        { nombre: "Islandia", gentilicio: "Islandés/a" },
        { nombre: "Israel", gentilicio: "Israelí" },
        { nombre: "Italia", gentilicio: "Italiano/a" },
        { nombre: "Jamaica", gentilicio: "Jamaicano/a" },
        { nombre: "Japón", gentilicio: "Japonés/a" },
        { nombre: "Jersery", gentilicio: "Jerseyano/a" },
        { nombre: "Jordania", gentilicio: "Jordano/a" },
        { nombre: "Kazajistán", gentilicio: "Kazajo/a" },
        { nombre: "Kenia", gentilicio: "Keniano/a" },
        { nombre: "Kirguistán", gentilicio: "Kirguís/a" },
        { nombre: "Kiribati", gentilicio: "Kiribatiano/a" },
        { nombre: "Kuwait", gentilicio: "Kuwaití" },
        { nombre: "Laos", gentilicio: "Laosiano/a" },
        { nombre: "Lesoto", gentilicio: "Lesotense" },
        { nombre: "Letonia", gentilicio: "Letón/a" },
        { nombre: "Líbano", gentilicio: "Libanés/a" },
        { nombre: "Liberia", gentilicio: "Liberiano/a" },
        { nombre: "Libia", gentilicio: "Libio/a" },
        { nombre: "Liechtenstein", gentilicio: "Liechtensteiniano/a" },
        { nombre: "Lituania", gentilicio: "Lituano/a" },
        { nombre: "Luxemburgo", gentilicio: "Luxemburgués/a" },
        { nombre: "Macao", gentilicio: "Macaense" },
        { nombre: "Madagascar", gentilicio: "Malgache" },
        { nombre: "Malasia", gentilicio: "Malasio/a" },
        { nombre: "Malaui", gentilicio: "Malaui" },
        { nombre: "Maldivas", gentilicio: "Maldiviano/a" },
        { nombre: "Mali", gentilicio: "Malí" },
        { nombre: "Malta", gentilicio: "Maltés/a" },
        { nombre: "Marruecos", gentilicio: "Marroquí" },
        { nombre: "Martinica", gentilicio: "Martiniqués/a" },
        { nombre: "Mauricio", gentilicio: "Mauriciano/a" },
        { nombre: "Mauritania", gentilicio: "Mauritano/a" },
        { nombre: "Mayota", gentilicio: "Mayotense" },
        { nombre: "México", gentilicio: "Mexicano/a" },
        { nombre: "Micronesia", gentilicio: "Micronesio/a" },
        { nombre: "Moldavia", gentilicio: "Moldavo/a" },
        { nombre: "Mónaco", gentilicio: "Monegasco/a" },
        { nombre: "Mongolia", gentilicio: "Mongol/a" },
        { nombre: "Montenegro", gentilicio: "Montenegrino/a" },
        { nombre: "Montserrat", gentilicio: "Montserratense" },
        { nombre: "Mozambique", gentilicio: "Mozambiqueño/a" },
        { nombre: "Namibia", gentilicio: "Namibio/a" },
        { nombre: "Nauru", gentilicio: "Nauruano/a" },
        { nombre: "Nepal", gentilicio: "Nepalí" },
        { nombre: "Nicaragua", gentilicio: "Nicaragüense" },
        { nombre: "Níger", gentilicio: "Nigerino/a" },
        { nombre: "Nigeria", gentilicio: "Nigeriano/a" },
        { nombre: "Niue", gentilicio: "Niueano/a" },
        { nombre: "Noruega", gentilicio: "Noruego/a" },
        { nombre: "Nueva Caledonia", gentilicio: "Neocaledonio/a" },
        { nombre: "Nueva Zelanda", gentilicio: "Neozelandés/a" },
        { nombre: "Omán", gentilicio: "Omaní" },
        { nombre: "Países Bajos", gentilicio: "Holandés/a" },
        { nombre: "Pakistán", gentilicio: "Pakistaní" },
        { nombre: "Palaos", gentilicio: "Palauano/a" },
        { nombre: "Palestina", gentilicio: "Palestino/a" },
        { nombre: "Panamá", gentilicio: "Panameño/a" },
        { nombre: "Papúa Nueva Guinea", gentilicio: "Papú" },
        { nombre: "Paraguay", gentilicio: "Paraguayo/a" },
        { nombre: "Perú", gentilicio: "Peruano/a" },
        { nombre: "Polinesia Francesa", gentilicio: "Polinésico/a" },
        { nombre: "Polonia", gentilicio: "Polaco/a" },
        { nombre: "Portugal", gentilicio: "Portugués/a" },
        { nombre: "Puerto Rico", gentilicio: "Puertorriqueño/a" },
        { nombre: "Qatar", gentilicio: "Qatarí" },
        { nombre: "Reino Unido", gentilicio: "Británico/a" },
        { nombre: "República Centroafricana", gentilicio: "Centroafricano/a" },
        { nombre: "República Checa", gentilicio: "Checo/a" },
        { nombre: "República del Congo", gentilicio: "Congoleño/a" },
        { nombre: "República Democrática del Congo", gentilicio: "Congoleño/a" },
        { nombre: "República Dominicana", gentilicio: "Dominicano/a" },
        { nombre: "Reunión", gentilicio: "Reunionense" },
        { nombre: "Ruanda", gentilicio: "Ruandés/a" },
        { nombre: "Rumania", gentilicio: "Rumano/a" },
        { nombre: "Rusia", gentilicio: "Ruso/a" },
        { nombre: "Sahara Occidental", gentilicio: "Saharaui" },
        { nombre: "Samoa", gentilicio: "Samoano/a" },
        { nombre: "Samoa Americana", gentilicio: "Samoamericano/a" },
        { nombre: "San Bartolomé", gentilicio: "Bartolomense" },
        { nombre: "San Cristóbal y Nieves", gentilicio: "Cristobaleño/a" },
        { nombre: "San Marino", gentilicio: "Sanmarinense" },
        { nombre: "San Martín", gentilicio: "Martinense" },
        { nombre: "San Pedro y Miquelón", gentilicio: "Miquelonense" },
        { nombre: "San Vicente y las Granadinas", gentilicio: "Granadino/a" },
        { nombre: "Santa Elena", gentilicio: "Heleniano/a" },
        { nombre: "Santa Lucía", gentilicio: "Luciano/a" },
        { nombre: "Santo Tomé y Príncipe", gentilicio: "Santotomense" },
        { nombre: "Senegal", gentilicio: "Senegalés/a" },
        { nombre: "Serbia", gentilicio: "Serbio/a" },
        { nombre: "Seychelles", gentilicio: "Seychellense" },
        { nombre: "Sierra Leona", gentilicio: "Sierraleonés/a" },
        { nombre: "Singapur", gentilicio: "Singaporiano/a" },
        { nombre: "Sint Maarten", gentilicio: "Maartense" },
        { nombre: "Siria", gentilicio: "Sirio/a" },
        { nombre: "Somalía", gentilicio: "Somalí" },
        { nombre: "Sri Lanka", gentilicio: "Ceilandés/a" },
        { nombre: "Suazilandia", gentilicio: "Suazi" },
        { nombre: "Sudáfrica", gentilicio: "Sudafricano/a" },
        { nombre: "Sudán", gentilicio: "Sudanés/a" },
        { nombre: "Sudán del Sur", gentilicio: "Sursudanés/a" },
        { nombre: "Suecia", gentilicio: "Sueco/a" },
        { nombre: "Suiza", gentilicio: "Suizo/a" },
        { nombre: "Surinam", gentilicio: "Surinamés/a" },
        { nombre: "Tailandia", gentilicio: "Tailandés/a" },
        { nombre: "Taiwán", gentilicio: "Taiwanés/a" },
        { nombre: "Tajikistán", gentilicio: "Tayiko/a" },
        { nombre: "Tanzania", gentilicio: "Tanzano/a" },
        { nombre: "Timor Oriental", gentilicio: "Timorense" },
        { nombre: "Togo", gentilicio: "Togolés/a" },
        { nombre: "Tokelau", gentilicio: "Tokelauano/a" },
        { nombre: "Tonga", gentilicio: "Tongano/a" },
        { nombre: "Trinidad y Tobago", gentilicio: "Trinitario/a" },
        { nombre: "Tunicia", gentilicio: "Tunecino/a" },
        { nombre: "Turkmenistán", gentilicio: "Turcomano/a" },
        { nombre: "Turquía", gentilicio: "Turco/a" },
        { nombre: "Tuvalu", gentilicio: "Tuvaluano/a" },
        { nombre: "Ucrania", gentilicio: "Ucraniano/a" },
        { nombre: "Uganda", gentilicio: "Ugandés/a" },
        { nombre: "Uruguay", gentilicio: "Uruguayo/a" },
        { nombre: "Uzbekistán", gentilicio: "Uzbeko/a" },
        { nombre: "Vanuatu", gentilicio: "Vanuatuense" },
        { nombre: "Venezuela", gentilicio: "Venezolano/a" },
        { nombre: "Vietnam", gentilicio: "Vietnamita" },
        { nombre: "Wallis y Futuna", gentilicio: "Wallisiano/a" },
        { nombre: "Yemen", gentilicio: "Yemení" },
        { nombre: "Zambia", gentilicio: "Zambiano/a" },
        { nombre: "Zimbabue", gentilicio: "Zimbabuense" }
    ];

    // Limpiar opciones anteriores (excepto la primera)
    while (paisSelect.options.length > 1) {
        paisSelect.remove(1);
    }

    // Agregar opciones ordenadas alfabéticamente
    paises.sort((a, b) => a.nombre.localeCompare(b.nombre));

    paises.forEach(item => {
        const option = document.createElement("option");
        option.value = item.nombre;
        option.textContent = `${item.nombre} (${item.gentilicio})`;
        option.dataset.nacionalidad = item.gentilicio;
        paisSelect.appendChild(option);
    });

    // Establecer Colombia como seleccionado por defecto
    paisSelect.value = "Colombia";

    console.log('✓ Países cargados correctamente: ' + paises.length);
}

// Ejecutar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", function () {
    // Pequeño delay para asegurar que el DOM esté completamente cargado
    setTimeout(() => {
        cargarPaises();
    }, 100);

    // Evento para actualizar nacionalidad
    const paisSelect = document.getElementById("paises");
    if (paisSelect) {
        paisSelect.addEventListener("change", function () {
            const nacionalidad = this.selectedOptions[0]?.dataset.nacionalidad || '';
            const nacionalidadField = document.getElementById("nacionalidad");
            if (nacionalidadField) {
                nacionalidadField.textContent = nacionalidad;
            }
        });
    }
});