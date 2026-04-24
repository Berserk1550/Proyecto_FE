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
  const pasos = Array.from(document.querySelectorAll('#progress-steps .step'));
  const barraLleno = document.getElementById('progress-bar-fill');

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

  // Envío del formulario
  form.addEventListener('submit', (event) => {
    event.preventDefault();
    if (validarFaseActual()) {
      console.log('Formulario válido, enviando...');
      // Aquí iría la lógica para enviar el formulario
      // form.submit();
    }
  });

  // Inicializar
  actualizarProgreso();
});
