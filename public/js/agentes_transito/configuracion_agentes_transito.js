let containerAgentsItems = document.getElementById('container_agents_items');
let txtBusqueda = document.getElementById('txt_busqueda');
let btnRefresh = document.getElementById('btn_refresh');
// Variable para almacenar el timeout
let typingTimer;

$(document).ready(function () {
    getAgentesTransito();
});

btnRefresh.addEventListener('click', () => {
    getAgentesTransito();
});

txtBusqueda.addEventListener('keyup', e => {
    let value = e.target.value.toUpperCase().trim();
    let inputsCodigosAgentes = containerAgentsItems.querySelectorAll('input.container_agents_items__input');
    let elements = containerAgentsItems.querySelectorAll('[data-emp_id]:not(i)');
    if (value == '') {
        elements.forEach(e => {
            e.style.display = 'block';
        });
        return;
    }
    elements.forEach(e => {
        e.style.display = 'none';
    });

    inputsCodigosAgentes.forEach(i => {
        if (
            i.dataset.emp_cedula.toUpperCase().includes(value)
            || `${i.dataset.emp_apellido} ${i.dataset.emp_nombre}`.toUpperCase().includes(value)
            || i.dataset.dep_departamento.toUpperCase().includes(value)
            || i.dataset.per_perfil.toUpperCase().includes(value)
            || i.dataset.ca_cargo.toUpperCase().includes(value)
        ) {
            let elementFound = containerAgentsItems.querySelectorAll(`[data-emp_id="${i.dataset.emp_id}"]:not(i)`);
            elementFound.forEach(e => {
                e.style.display = 'block';
            });
        }
    })
});

function getAgentesTransito() {
    showLoadChargeAgents(true);
    $.ajax({
        url: '/conf_agentes_transito/get_agentes_transito',
        type: "GET",
        dataType: "json",
        success: function (response) {
            renderListAgentesTransito(response);
        }
    });
}

function renderListAgentesTransito(items) {
    containerAgentsItems.innerHTML = "";
    items.forEach(i => {
        containerAgentsItems.innerHTML += `
        <div class="container_agents_items__container_input" data-emp_id="${i.emp_id}">
            <input class="container_agents_items__input ${i.at_codigo != "" ? 'container_agents_items__input--success' : ''}"
            data-at_id="${i.at_id}"
            data-emp_id="${i.emp_id}"
            data-emp_cedula="${i.emp_cedula}"
            data-emp_apellido="${i.emp_apellido}"
            data-emp_nombre="${i.emp_nombre}"
            data-dep_departamento="${i.dep_departamento}"
            data-per_perfil="${i.per_perfil}"
            data-ca_cargo="${i.ca_cargo}"
            type="text" 
            name="codigo"
            value="${i.at_codigo}"
            maxlength="20" 
            style="text-transform: uppercase;">
            <i class="fa fa-spinner container_agents_items__charge ${i.at_codigo != "" ? 'container_agents_items__charge--success' : ''}" data-emp_id="${i.emp_id}" aria-hidden="true" style="display:none;"></i>
        </div>
        <p class="container_agents_items__cell container_agents_items__cell--start" data-emp_id="${i.emp_id}">${i.emp_apellido} ${i.emp_nombre}</p>
        <p class="container_agents_items__cell" data-emp_id="${i.emp_id}">${i.emp_cedula}</p>
        <p class="container_agents_items__cell" data-emp_id="${i.emp_id}">${i.dep_departamento}</p>
        <p class="container_agents_items__cell" data-emp_id="${i.emp_id}">${i.per_perfil}</p>
        <p class="container_agents_items__cell" data-emp_id="${i.emp_id}">${i.ca_cargo}</p>
        `;
    });
    showLoadChargeAgents(false);
    addEventKeyUpFromCodesAgents();
}

function showLoadChargeAgents(active) {
    $("#container_agents_charge").hide();
    $("#container_agents").show();
    if (active) {
        $("#container_agents_charge").show();
        $("#container_agents").hide();
    }
}

function addEventKeyUpFromCodesAgents() {
    let inputs = containerAgentsItems.querySelectorAll('input.container_agents_items__input');

    inputs.forEach(i => {
        i.addEventListener('input', e => {
            let value = e.target.value;
            // Limpia el temporizador anterior
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                i.readOnly = true;
                storePostCodAgenteTransito(i.dataset.at_id, value, i.dataset.emp_id, i.dataset.emp_cedula)
            }, 1000);
        });
    });
}

function storePostCodAgenteTransito(at_id, at_codigo, emp_id, at_cedula) {
    let input = containerAgentsItems.querySelector(`input.container_agents_items__input[data-emp_id="${emp_id}"]`);
    let iconChargeCod = containerAgentsItems.querySelector(`i.container_agents_items__charge[data-emp_id="${emp_id}"]`);

    iconCodShow(iconChargeCod, true, 'waiting');
    inputCodShow(input, 'waiting')


    let token = $("#csrf-token").val();
    let datos = new FormData();
    datos.append('at_id', at_id);
    datos.append('at_codigo', at_codigo);
    datos.append('emp_id', emp_id);
    datos.append('at_cedula', at_cedula);
    $.ajax({
        url: '/conf_agentes_transito/store',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            input.readOnly = false;
            iconCodShow(iconChargeCod, false);
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Código Registrado!",
                    type: "success",
                    zindex: 99999
                });
                input.dataset.at_id = response.data;
                inputCodShow(input, at_codigo != "" ? 'success' : 'waiting');

            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido registrar el código!",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
            }
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        input.readOnly = false;
        iconCodShow(iconChargeCod, false);
        if (jqXHR.status === 0) {
            alert('Not connect: Verify Network.');
        } else if (jqXHR.status == 404) {
            alert('Requested page not found [404]');
        } else if (jqXHR.status == 500) {
            alert('Internal Server Error [500]. Intente nuevamente');
        } else if (textStatus === 'timeout') {
            alert('Time out error.');
        } else if (textStatus === 'abort') {
            alert('Ajax request aborted.');
        }
    });
}

function iconCodShow(icon, show, value = "") {
    icon.style.display = "none";
    icon.classList.remove('container_agents_items__charge--success');
    icon.classList.remove('container_agents_items__charge--waiting');
    if (show) {
        icon.style.display = "block";
        icon.classList.add(`container_agents_items__charge--${value}`);
    }
}

function inputCodShow(input, value = "") {
    input.classList.remove('container_agents_items__input--success');
    input.classList.remove('container_agents_items__input--waiting');
    if (value != "") {
        input.classList.add(`container_agents_items__input--${value}`);
    }
}