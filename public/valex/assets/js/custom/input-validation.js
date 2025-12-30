function setInputValidations(id, arrayValidationsSimple, arrayValidationsPersonalizadas, arrayWarnings = []) {
    let input = document.getElementById(id);
    let showError = document.querySelector(`[data-for="${id}"]`);

    input.validateInput = (() => {
        showError.innerHTML = '';
        arrayValidationsSimple.map(e => {
            if (e == 'notEmpty' && input.value.trim() == "") {
                showError.innerHTML += `${input.dataset.label} no puede ser vacío \n`;
            }
            // Nueva validación para IPv4
            if (e == 'ipv4' && !/^(\d{1,3}\.){3}\d{1,3}$/.test(input.value.trim())) {
                showError.innerHTML += `${input.dataset.label} debe ser una dirección IPv4 válida \n`;
            }
        });
        arrayValidationsPersonalizadas.map(e => {
            if (e.function(input)) {
                showError.innerHTML += e.message;
            }
        });
        return showError.innerHTML;
    });

    input.validateWarnings = (() => {
        let warnings = '';
        arrayWarnings.map(e => {
            if (e.function(input)) {
                warnings += e.message;
            }
        });
        return warnings;
    });
}