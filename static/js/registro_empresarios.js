document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('MIformulario');
    const phases = Array.from(document.querySelectorAll('.fase'));
    const progressSteps = Array.from(document.querySelectorAll('.progress-steps .step'));
    const progressBar = document.querySelector('.progress-bar');

    if (!form || phases.length === 0 || progressSteps.length === 0) {
        return;
    }

    let currentStep = 0;
    let submitButton = form.querySelector('button[type="submit"]');
    if (!submitButton) {
        submitButton = document.createElement('button');
        submitButton.type = 'submit';
        submitButton.className = 'btn-verde';
        submitButton.textContent = 'Enviar Formulario';
    } else {
        submitButton.classList.add('btn-verde');
    }
    const nav = document.createElement('div');
    nav.className = 'form-actions';

    const prevButton = document.createElement('button');
    prevButton.type = 'button';
    prevButton.className = 'btn-secondary';
    prevButton.textContent = 'Anterior';

    const nextButton = document.createElement('button');
    nextButton.type = 'button';
    nextButton.className = 'btn-verde';
    nextButton.textContent = 'Siguiente';

    if (submitButton) {
        submitButton.type = 'submit';
        submitButton.classList.add('btn-verde');
    }

    nav.appendChild(prevButton);
    nav.appendChild(nextButton);
    if (submitButton) {
        nav.appendChild(submitButton);
    }
    form.appendChild(nav);

    function updateProgress() {
        phases.forEach((phase, index) => {
            phase.style.display = index === currentStep ? 'grid' : 'none';
        });

        progressSteps.forEach((step, index) => {
            step.classList.toggle('active', index === currentStep);
        });

        prevButton.disabled = currentStep === 0;

        if (submitButton) {
            if (currentStep === phases.length - 1) {
                nextButton.style.display = 'none';
                submitButton.style.display = 'inline-flex';
            } else {
                nextButton.style.display = 'inline-flex';
                submitButton.style.display = 'none';
            }
        }

        if (progressBar) {
            const percentage = ((currentStep + 1) / phases.length) * 100;
            progressBar.style.width = `${percentage}%`;
        }

        const firstField = phases[currentStep].querySelector('input, select, textarea');
        if (firstField) {
            firstField.focus();
        }
    }

    function validateCurrentPhase() {
        const fields = Array.from(phases[currentStep].querySelectorAll('input, select, textarea')).filter((field) => field.willValidate);
        for (const field of fields) {
            if (!field.checkValidity()) {
                field.reportValidity();
                field.focus();
                return false;
            }
        }
        return true;
    }

    prevButton.addEventListener('click', () => {
        if (currentStep > 0) {
            currentStep -= 1;
            updateProgress();
        }
    });

    nextButton.addEventListener('click', () => {
        if (!validateCurrentPhase()) {
            return;
        }
        if (currentStep < phases.length - 1) {
            currentStep += 1;
            updateProgress();
        }
    });

    form.addEventListener('submit', (event) => {
        if (currentStep !== phases.length - 1) {
            event.preventDefault();
            if (validateCurrentPhase()) {
                currentStep = phases.length - 1;
                updateProgress();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    });

    updateProgress();
});

document.getElementById('toggleInfo').addEventListener('click', function () {
    const manual = document.querySelector('.dashboard-manual');
    manual.classList.toggle('expanded');
    this.textContent = manual.classList.contains('expanded') ? 'Ver menos' : 'Ver más';
});

document.getElementById('toggleInfo').addEventListener('click', function () {
    const manual = document.querySelector('.dashboard-manual');
    manual.classList.toggle('expanded');
    this.textContent = manual.classList.contains('expanded') ? 'Ver menos' : 'Ver más';
});

document.getElementById('toggleInfo').addEventListener('click', function () {
    const manual = document.querySelector('.dashboard-manual');
    manual.classList.toggle('expanded');
    this.textContent = manual.classList.contains('expanded') ? 'Ver menos' : 'Ver más';
});
