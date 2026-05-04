
  const form = document.getElementById('formulario');
  const fases = [
    document.getElementById('fase_1'),
    document.getElementById('fase_2'),
    document.getElementById('fase_3'),
    document.getElementById('fase_4'),
    document.getElementById('fase_5'),
    document.getElementById('fase_6')
  ];
  const pasos = Array.from(document.querySelectorAll('#progress-steps .step'));
  const barraLleno = document.getElementById('progress-bar-fill');

  if (!form || fases.length === 0 || pasos.length === 0) {
    console.error('Elementos del formulario no encontrados');
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
  const senaCarreras = {
    'Técnico': document.getElementById('carrera_tecnico'),
    'Tecnólogo': document.getElementById('carrera_tecnologo'),
    'Operario': document.getElementById('carrera_operario'),
    'Auxiliar': document.getElementById('carrera_auxiliar')
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
    carreraProf.addEventListener('change', function() {
      // La lógica para mostrar/ocultar especializaciones se maneja arriba
    });
  }

  // NO APLICA automatizado
  const tipoEmprendedor = document.getElementById('tipo_emprendedor');
  const numeroFicha = document.getElementById('numero_ficha');

  if (tipoEmprendedor) {
    tipoEmprendedor.addEventListener('change', function() {
      if (this.value === 'No cuenta con formación' || this.value === 'Otro' || this.value === 'Instructor') {
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
      'orientador'
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
    campoFecha.addEventListener('click', function() {
        this.showPicker();
    });

  }


// API para países y nacionalidades
function cargarPaises() {
  const paisSelect = document.getElementById("paises");
  
  if (!paisSelect) {
    console.error('Elemento #paises no encontrado en el DOM');
    return;
  }

  // Lista de países y gentilicios (sin API externa)
  const paises = [
  { codigo: "AF", nombre: "Afganistán", gentilicio: "Afgano/a" },
  { codigo: "AL", nombre: "Albania", gentilicio: "Albanés/a" },
  { codigo: "DE", nombre: "Alemania", gentilicio: "Alemán/a" },
  { codigo: "AD", nombre: "Andorra", gentilicio: "Andorrano/a" },
  { codigo: "AO", nombre: "Angola", gentilicio: "Angoleño/a" },
  { codigo: "AG", nombre: "Antigua y Barbuda", gentilicio: "Antiguano/a" },
  { codigo: "SA", nombre: "Arabia Saudita", gentilicio: "Saudí/a" },
  { codigo: "DZ", nombre: "Argelia", gentilicio: "Argelino/a" },
  { codigo: "AR", nombre: "Argentina", gentilicio: "Argentino/a" },
  { codigo: "AM", nombre: "Armenia", gentilicio: "Armenio/a" },
  { codigo: "AU", nombre: "Australia", gentilicio: "Australiano/a" },
  { codigo: "AT", nombre: "Austria", gentilicio: "Austriaco/a" },
  { codigo: "AZ", nombre: "Azerbaiyán", gentilicio: "Azerbaiyano/a" },
  { codigo: "BS", nombre: "Bahamas", gentilicio: "Bahamense" },
  { codigo: "BD", nombre: "Bangladés", gentilicio: "Bangladesí" },
  { codigo: "BB", nombre: "Barbados", gentilicio: "Barbadense" },
  { codigo: "BH", nombre: "Baréin", gentilicio: "Bareiní" },
  { codigo: "BE", nombre: "Bélgica", gentilicio: "Belga" },
  { codigo: "BZ", nombre: "Belice", gentilicio: "Beliceño/a" },
  { codigo: "BJ", nombre: "Benín", gentilicio: "Beninés/a" },
  { codigo: "BY", nombre: "Bielorrusia", gentilicio: "Bielorruso/a" },
  { codigo: "MM", nombre: "Birmania", gentilicio: "Birmano/a" },
  { codigo: "BO", nombre: "Bolivia", gentilicio: "Boliviano/a" },
  { codigo: "BA", nombre: "Bosnia y Herzegovina", gentilicio: "Bosnio/a" },
  { codigo: "BW", nombre: "Botsuana", gentilicio: "Botsuano/a" },
  { codigo: "BR", nombre: "Brasil", gentilicio: "Brasileño/a" },
  { codigo: "BN", nombre: "Brunéi", gentilicio: "Bruneano/a" },
  { codigo: "BG", nombre: "Bulgaria", gentilicio: "Búlgaro/a" },
  { codigo: "BF", nombre: "Burkina Faso", gentilicio: "Burkinés/a" },
  { codigo: "BI", nombre: "Burundi", gentilicio: "Burundés/a" },
  { codigo: "BT", nombre: "Bután", gentilicio: "Butanés/a" },
  { codigo: "CV", nombre: "Cabo Verde", gentilicio: "Caboverdiano/a" },
  { codigo: "KH", nombre: "Camboya", gentilicio: "Camboyano/a" },
  { codigo: "CM", nombre: "Camerún", gentilicio: "Camerunés/a" },
  { codigo: "CA", nombre: "Canadá", gentilicio: "Canadiense" },
  { codigo: "QA", nombre: "Catar", gentilicio: "Catarí" },
  { codigo: "TD", nombre: "Chad", gentilicio: "Chadiano/a" },
  { codigo: "CL", nombre: "Chile", gentilicio: "Chileno/a" },
  { codigo: "CN", nombre: "China", gentilicio: "Chino/a" },
  { codigo: "CY", nombre: "Chipre", gentilicio: "Chipriota" },
  { codigo: "VA", nombre: "Ciudad del Vaticano", gentilicio: "Vaticano" },
  { codigo: "CO", nombre: "Colombia", gentilicio: "Colombiano/a" },
  { codigo: "KM", nombre: "Comoras", gentilicio: "Comorense" },
  { codigo: "CG", nombre: "Congo", gentilicio: "Congoleño/a" },
  { codigo: "KP", nombre: "Corea del Norte", gentilicio: "Norcoreano/a" },
  { codigo: "KR", nombre: "Corea del Sur", gentilicio: "Surcoreano/a" },
  { codigo: "CI", nombre: "Costa de Marfil", gentilicio: "Marfileño/a" },
  { codigo: "CR", nombre: "Costa Rica", gentilicio: "Costarricense" },
  { codigo: "HR", nombre: "Croacia", gentilicio: "Croata" },
  { codigo: "CU", nombre: "Cuba", gentilicio: "Cubano/a" },
  { codigo: "CW", nombre: "Curazao", gentilicio: "Curazaleño/a" },
  { codigo: "DK", nombre: "Dinamarca", gentilicio: "Danés/a" },
  { codigo: "DM", nombre: "Dominica", gentilicio: "Dominiqués/a" },
  { codigo: "EC", nombre: "Ecuador", gentilicio: "Ecuatoriano/a" },
  { codigo: "EG", nombre: "Egipto", gentilicio: "Egipcio/a" },
  { codigo: "SV", nombre: "El Salvador", gentilicio: "Salvadoreño/a" },
  { codigo: "AE", nombre: "Emiratos Árabes Unidos", gentilicio: "Emiratí" },
  { codigo: "ER", nombre: "Eritrea", gentilicio: "Eritreo/a" },
  { codigo: "SK", nombre: "Eslovaquia", gentilicio: "Eslovaco/a" },
  { codigo: "SI", nombre: "Eslovenia", gentilicio: "Esloveno/a" },
  { codigo: "ES", nombre: "España", gentilicio: "Español/a" },
  { codigo: "US", nombre: "Estados Unidos", gentilicio: "Estadounidense" },
  { codigo: "EE", nombre: "Estonia", gentilicio: "Estonio/a" },
  { codigo: "ET", nombre: "Etiopía", gentilicio: "Etíope" },
  { codigo: "PH", nombre: "Filipinas", gentilicio: "Filipino/a" },
  { codigo: "FI", nombre: "Finlandia", gentilicio: "Finlandés/a" },
  { codigo: "FJ", nombre: "Fiyi", gentilicio: "Fiyiano/a" },
  { codigo: "FR", nombre: "Francia", gentilicio: "Francés/a" },
  { codigo: "GA", nombre: "Gabón", gentilicio: "Gabonés/a" },
  { codigo: "GM", nombre: "Gambia", gentilicio: "Gambiano/a" },
  { codigo: "GE", nombre: "Georgia", gentilicio: "Georgiano/a" },
  { codigo: "GH", nombre: "Ghana", gentilicio: "Ghanés/a" },
  { codigo: "GI", nombre: "Gibraltar", gentilicio: "Gibraltareño/a" },
  { codigo: "GR", nombre: "Grecia", gentilicio: "Griego/a" },
  { codigo: "GD", nombre: "Granada", gentilicio: "Granadino/a" },
  { codigo: "GL", nombre: "Groenlandia", gentilicio: "Groenlandés/a" },
  { codigo: "GP", nombre: "Guadalupe", gentilicio: "Guadalupeño/a" },
  { codigo: "GU", nombre: "Guam", gentilicio: "Guameño/a" },
  { codigo: "GT", nombre: "Guatemala", gentilicio: "Guatemalteco/a" },
  { codigo: "GF", nombre: "Guayana Francesa", gentilicio: "Guayanés/a" },
  { codigo: "GG", nombre: "Guernsey", gentilicio: "Guernesiano/a" },
  { codigo: "GN", nombre: "Guinea", gentilicio: "Guineo/a" },
  { codigo: "GQ", nombre: "Guinea Ecuatorial", gentilicio: "Ecuatoguineano/a" },
  { codigo: "GW", nombre: "Guinea-Bisáu", gentilicio: "Guineano/a" },
  { codigo: "GY", nombre: "Guyana", gentilicio: "Guyanes/a" },
  { codigo: "HT", nombre: "Haití", gentilicio: "Haitiano/a" },
  { codigo: "NL", nombre: "Holanda", gentilicio: "Holandés/a" },
  { codigo: "HN", nombre: "Honduras", gentilicio: "Hondureño/a" },
  { codigo: "HK", nombre: "Hong Kong", gentilicio: "Hongkonés/a" },
  { codigo: "HU", nombre: "Hungría", gentilicio: "Húngaro/a" },
  { codigo: "IN", nombre: "India", gentilicio: "Indio/a" },
  { codigo: "ID", nombre: "Indonesia", gentilicio: "Indonesio/a" },
  { codigo: "IQ", nombre: "Irak", gentilicio: "Iraquí" },
  { codigo: "IR", nombre: "Irán", gentilicio: "Iraní" },
  { codigo: "IE", nombre: "Irlanda", gentilicio: "Irlandés/a" },
  { codigo: "IS", nombre: "Islandia", gentilicio: "Islandés/a" },
  { codigo: "IL", nombre: "Israel", gentilicio: "Israelí" },
  { codigo: "IT", nombre: "Italia", gentilicio: "Italiano/a" },
  { codigo: "JM", nombre: "Jamaica", gentilicio: "Jamaicano/a" },
  { codigo: "JP", nombre: "Japón", gentilicio: "Japonés/a" },
  { codigo: "JE", nombre: "Jersey", gentilicio: "Jerseyano/a" },
  { codigo: "JO", nombre: "Jordania", gentilicio: "Jordano/a" },
  { codigo: "KZ", nombre: "Kazajistán", gentilicio: "Kazajo/a" },
  { codigo: "KE", nombre: "Kenia", gentilicio: "Keniano/a" },
  { codigo: "KG", nombre: "Kirguistán", gentilicio: "Kirguís/a" },
  { codigo: "KI", nombre: "Kiribati", gentilicio: "Kiribatiano/a" },
  { codigo: "KW", nombre: "Kuwait", gentilicio: "Kuwaití" },
  { codigo: "LA", nombre: "Laos", gentilicio: "Laosiano/a" },
  { codigo: "LS", nombre: "Lesoto", gentilicio: "Lesotense" },
  { codigo: "LV", nombre: "Letonia", gentilicio: "Letón/a" },
  { codigo: "LB", nombre: "Líbano", gentilicio: "Libanés/a" },
  { codigo: "LR", nombre: "Liberia", gentilicio: "Liberiano/a" },
  { codigo: "LY", nombre: "Libia", gentilicio: "Libio/a" },
  { codigo: "LI", nombre: "Liechtenstein", gentilicio: "Liechtensteiniano/a" },
  { codigo: "LT", nombre: "Lituania", gentilicio: "Lituano/a" },
  { codigo: "LU", nombre: "Luxemburgo", gentilicio: "Luxemburgués/a" },
  { codigo: "MO", nombre: "Macao", gentilicio: "Macaense" },
  { codigo: "MG", nombre: "Madagascar", gentilicio: "Malgache" },
  { codigo: "MY", nombre: "Malasia", gentilicio: "Malasio/a" },
  { codigo: "MW", nombre: "Malaui", gentilicio: "Malauí" },
  { codigo: "MV", nombre: "Maldivas", gentilicio: "Maldiviano/a" },
  { codigo: "ML", nombre: "Mali", gentilicio: "Malí" },
  { codigo: "MT", nombre: "Malta", gentilicio: "Maltés/a" },
  { codigo: "MA", nombre: "Marruecos", gentilicio: "Marroquí" },
  { codigo: "MQ", nombre: "Martinica", gentilicio: "Martiniqués/a" },
  { codigo: "MU", nombre: "Mauricio", gentilicio: "Mauriciano/a" },
  { codigo: "MR", nombre: "Mauritania", gentilicio: "Mauritano/a" },
  { codigo: "YT", nombre: "Mayotte", gentilicio: "Mayotense" },
  { codigo: "MX", nombre: "México", gentilicio: "Mexicano/a" },
  { codigo: "FM", nombre: "Micronesia", gentilicio: "Micronesio/a" },
  { codigo: "MD", nombre: "Moldavia", gentilicio: "Moldavo/a" },
  { codigo: "MC", nombre: "Mónaco", gentilicio: "Monegasco/a" },
  { codigo: "MN", nombre: "Mongolia", gentilicio: "Mongol/a" },
  { codigo: "ME", nombre: "Montenegro", gentilicio: "Montenegrino/a" },
  { codigo: "MS", nombre: "Montserrat", gentilicio: "Montserratense" },
  { codigo: "MZ", nombre: "Mozambique", gentilicio: "Mozambiqueño/a" },
  { codigo: "NA", nombre: "Namibia", gentilicio: "Namibio/a" },
  { codigo: "NR", nombre: "Nauru", gentilicio: "Nauruano/a" },
  { codigo: "NP", nombre: "Nepal", gentilicio: "Nepalí" },
  { codigo: "NI", nombre: "Nicaragua", gentilicio: "Nicaragüense" },
  { codigo: "NE", nombre: "Níger", gentilicio: "Nigerino/a" },
  { codigo: "NG", nombre: "Nigeria", gentilicio: "Nigeriano/a" },
  { codigo: "NU", nombre: "Niue", gentilicio: "Niueano/a" },
  { codigo: "NO", nombre: "Noruega", gentilicio: "Noruego/a" },
  { codigo: "NC", nombre: "Nueva Caledonia", gentilicio: "Neocaledonio/a" },
  { codigo: "NZ", nombre: "Nueva Zelanda", gentilicio: "Neozelandés/a" },
  { codigo: "OM", nombre: "Omán", gentilicio: "Omaní" },
  { codigo: "NL", nombre: "Países Bajos", gentilicio: "Holandés/a" },
  { codigo: "PK", nombre: "Pakistán", gentilicio: "Pakistaní" },
  { codigo: "PW", nombre: "Palaos", gentilicio: "Palauano/a" },
  { codigo: "PS", nombre: "Palestina", gentilicio: "Palestino/a" },
  { codigo: "PA", nombre: "Panamá", gentilicio: "Panameño/a" },
  { codigo: "PG", nombre: "Papúa Nueva Guinea", gentilicio: "Papú" },
  { codigo: "PY", nombre: "Paraguay", gentilicio: "Paraguayo/a" },
  { codigo: "PE", nombre: "Perú", gentilicio: "Peruano/a" },
  { codigo: "PF", nombre: "Polinesia Francesa", gentilicio: "Polinésico/a" },
  { codigo: "PL", nombre: "Polonia", gentilicio: "Polaco/a" },
  { codigo: "PT", nombre: "Portugal", gentilicio: "Portugués/a" },
  { codigo: "PR", nombre: "Puerto Rico", gentilicio: "Puertorriqueño/a" },
  { codigo: "QA", nombre: "Qatar", gentilicio: "Qatarí" },
  { codigo: "GB", nombre: "Reino Unido", gentilicio: "Británico/a" },
  { codigo: "CF", nombre: "República Centroafricana", gentilicio: "Centroafricano/a" },
  { codigo: "CZ", nombre: "República Checa", gentilicio: "Checo/a" },
  { codigo: "CG", nombre: "República del Congo", gentilicio: "Congoleño/a" },
  { codigo: "CD", nombre: "República Democrática del Congo", gentilicio: "Congoleño/a" },
  { codigo: "DO", nombre: "República Dominicana", gentilicio: "Dominicano/a" },
  { codigo: "RE", nombre: "Reunión", gentilicio: "Reunionense" },
  { codigo: "RW", nombre: "Ruanda", gentilicio: "Ruandés/a" },
  { codigo: "RO", nombre: "Rumania", gentilicio: "Rumano/a" },
  { codigo: "RU", nombre: "Rusia", gentilicio: "Ruso/a" },
  { codigo: "EH", nombre: "Sahara Occidental", gentilicio: "Saharaui" },
  ];

  // Limpiar opciones anteriores (excepto la primera)
  while (paisSelect.options.length > 1) {
    paisSelect.remove(1);
  }
  // Agregar opciones ordenadas alfabéticamente
  paises.sort((a, b) => a.nombre.localeCompare(b.nombre));
  
  paises.forEach(item => {
    const option = document.createElement("option");
    option.value = item.codigo; // ← AHORA EL VALUE ES EL CÓDIGO
    option.textContent = `${item.nombre} (${item.gentilicio})`;
    option.dataset.nacionalidad = item.gentilicio;
    paisSelect.appendChild(option);
  });


  // Seleccionar Colombia por defecto DESPUÉS de llenar el select
  paisSelect.value = "CO";

  const nacionalidadField = document.getElementById("nacionalidad");
  if (nacionalidadField) {
    nacionalidadField.textContent = "Colombiano/a";
  }

  console.log('✓ Países cargados correctamente: ' + paises.length);
}

// Ejecutar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  // Pequeño delay para asegurar que el DOM esté completamente cargado
  setTimeout(() => {
    cargarPaises();
  }, 100);

  // Evento para actualizar nacionalidad
  const paisSelect = document.getElementById("paises");
  if (paisSelect) {
    paisSelect.addEventListener("change", () => {
      const nacionalidad = paisSelect.selectedOptions[0]?.dataset.nacionalidad || '';
      const nacionalidadField = document.getElementById("nacionalidad");
      if (nacionalidadField) {
        nacionalidadField.textContent = nacionalidad;
      }
    });
  }
});