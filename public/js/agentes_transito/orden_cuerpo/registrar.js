let btnVolverOrdenCuerpo = document.getElementById('btn_volver_orden_cuerpo');
let btnSaveOrdenCuerpo = document.getElementById('btn_guardar_orden_cuerpo');
const containerMain = 'container_doc';
let idList = 1;
let idRowTable = 1;
let idAgentRowTable = 1;
let oc_id = 0;
let conf_plantilla = '';
let duplicate = false;
let countDocumentoOC = '-';
let listControlContainer = [];
let list_all_agents = [];
let list_personal_franco = [];
let autosave = false;

$(document).ready(function () {
    $.ajax({
        url: `/orden_cuerpo/secuencialoc`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            countDocumentoOC = response.length > 0 ? response[0].cf_valor : countDocumentoOC;
            oc_id = document.getElementById('oc_id').value;
            duplicate = document.getElementById('duplicate').value;
            if (oc_id == 0) {
                loadPlantillaActive();
            } else {
                loadPlantillaGuardada(oc_id);
                if (duplicate)
                    oc_id = 0;
            }
        }
    });

    $.ajax({
        url: `/conf_agentes_transito/get_agentes_transito`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            list_all_agents = response.filter(r => r.at_codigo != "");
        }
    });
});

btnVolverOrdenCuerpo.addEventListener('click', () => {
    window.location.replace('/orden_cuerpo');
});

btnSaveOrdenCuerpo.addEventListener('click', () => {
    saveDataOrdenCuerpo(function () {
        window.location.replace('/orden_cuerpo');
    });
});

function saveDataOrdenCuerpo(fun) {
    let plantillaContainer = document.getElementById(containerMain);
    let items = plantillaContainer.querySelectorAll(':scope > div[data-type]');
    let token = $("#csrf-token").val();
    const formData = new FormData();

    const values = getItemsContainers(plantillaContainer);

    if (items.length == 0) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No existe ningun item para guardar",
            position: "right",
            autohide: true,
            zindex: 99999
        });
        return;
    }

    formData.append('oc_id', oc_id);
    formData.append('oc_plantilla', JSON.stringify(conf_plantilla));
    formData.append('oc_datos', JSON.stringify(values));

    $("#btn_guardar_orden_cuerpo").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");

    $.ajax({
        url: '/orden_cuerpo/store',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: formData,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Orden de cuerpo Registrada!",
                    type: "success",
                    zindex: 99999
                });
                oc_id = response.data;
                $("#btn_guardar_orden_cuerpo").html("<i class='fa fa-save'></i> GUARDAR");
                fun();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido registrar la orden de cuerpo!",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#btn_guardar_orden_cuerpo").html("<i class='fa fa-save'></i> GUARDAR");
            }
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
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

function loadPlantillaGuardada(id) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: `/orden_cuerpo/lista_orden_cuerpo/${id}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            let registro = response[0];

            let plantillaContainer = document.getElementById(containerMain);
            conf_plantilla = JSON.parse(registro.oc_plantilla);
            datos = JSON.parse(registro.oc_datos);
            readPlantillaCargada(conf_plantilla, plantillaContainer);
            setTimeout(() => {
                loadDataSaved(plantillaContainer, datos);
                $("#global-loader").removeClass("block");
                $("#global-loader").addClass("none");
                autosave = true;
            }, 1000);
        }
    });
}

function loadDataSaved(container, data) {
    data = data.reverse();
    data.forEach(d => {
        let item = container.querySelector(`:scope > div[data-type="${d.type}"][data-cod="${d.cod}"]`);

        switch (d.type) {
            case "title":
                let h1Title = item.querySelector('h1');
                h1Title.innerHTML = d.text;
                break;
            case "paragraph":
                if (duplicate && d.name == 'title_document') return;
                let p_paragraph = item.querySelector('p');
                p_paragraph.innerHTML = d.text;
                break;
            case "container":
                let container_elements = item.querySelector(':scope > .container_elements');
                let header_container = container_elements.querySelector(':scope > .container_elements_header');
                let p_container = header_container.querySelector(':scope > p.container_elements_header_text');
                p_container.innerHTML = d.textHeader;
                loadDataSaved(container_elements, d.items);
                break;
            case "list":
                let listContainer = item.querySelector('.list_container');
                d.items.forEach(r => {
                    let row = listContainer.querySelector(r.bind == 0
                        ? `.row_list[data-row="${r.row}"]`
                        : `.row_list.configure[data-index="${r.bind}"]`);
                    let izqCell = row.querySelector('.row_list_col.izq');
                    let derCell = row.querySelector('.row_list_col.der');
                    resolveDataCell(izqCell, r.izq);
                    resolveDataCell(derCell, r.der);
                    if (row.classList.contains('configure')) {
                        let okButton = row.querySelector('[id^="list_conf_camp_ok_"]');
                        okButton.dispatchEvent(new Event('click'));
                    }
                });
                break;
            case "table":
                if (d.cod_copy != "") {
                    let tableContainerOriginal = container.querySelector(`[data-type="table"][data-cod="${d.cod_copy}"]`);
                    let btnDuplicate = tableContainerOriginal.querySelector('.duplicate_table');
                    btnDuplicate.dispatchEvent(new Event('click'));
                    let contTable = readMaxTypeContainer("table");
                    item = container.querySelector(`:scope > div[data-type="${d.type}"][data-cod="${contTable}"]`);
                }
                let tableContainer = item.querySelector('.table_container');
                let table = tableContainer.querySelector('.table');
                let btnDeleteRows = table.querySelectorAll('.delete_row_table');
                let headersTable = table.querySelectorAll('.header_table');

                btnDeleteRows.forEach(b => {
                    b.dispatchEvent(new Event('click'));
                });

                headersTable.forEach((h, i) => {
                    let p = h.querySelector('p');
                    p.innerHTML = d.headerColumns[i].text;
                });

                d.filas.forEach(f => {
                    let colsRow = table.querySelectorAll(`.cell.configure[data-row="${f.row}"]`);
                    colsRow.forEach((c, i) => {
                        resolveDataCellTable(c, f.columns[i]);
                    });
                    if (f.row_copy) {
                        let configureOption = table.querySelector(`.configure_table_div.configure[data-row="${f.row}"]`);
                        let okButton = configureOption.querySelector('.ok_row_table');
                        okButton.dispatchEvent(new Event('click'));
                    }
                });
                break;
            case "image":
                break;
            default:
                console.log('no implementado');
                break;
        }
    });
}

function resolveDataCell(element, data) {
    if (element.dataset.type == "text") {
        let p = element.querySelector('p');
        p.innerHTML = data.value;
    }
    if (element.dataset.type == "search") {
        let input = element.querySelector('input');
        input.dataset.text = data.text;
        input.dataset.value = data.value;
        input.value = data.text;
        if (input.dataset.origin == "agente") {
            input.dataset.at_id = data.at_id;
            input.dataset.at_codigo = data.at_codigo;
            input.dataset.emp_cedula = data.emp_cedula;
        }
    }
}

function resolveDataCellTable(element, data) {
    if (element.dataset.type == "text") {
        let p = element.querySelector('p');
        p.innerHTML = data.value;
    }
    if (element.dataset.type == "clear") {
        let p = element.querySelector('p');
        p.innerHTML = data.value;
    }
    if (element.dataset.type == "dataset") {
        let p = element.querySelector('p');
        p.innerHTML = data.value;
    }
    if (element.dataset.type == "search") {
        let input = element.querySelector('input');
        input.dataset.text = data.text;
        input.dataset.value = data.value;
        input.value = data.text;
        if (input.dataset.origin == "agente") {
            input.dataset.at_id = data.at_id;
            input.dataset.at_codigo = data.at_codigo;
            input.dataset.emp_cedula = data.emp_cedula;
        }

        input.dispatchEvent(new Event('changeAsing'));

    }
}

function calculateSummaryAgents() {
    const table_total = document.querySelector('.box-content[data-type="table_total"]');
    const table_franco = document.querySelector('.box-content[data-type="table_franco"]');
    const element_primer_turno = table_total.querySelector(`#td_table_total_${table_total.dataset.cod}_personal_primer_turno`);
    const element_segundo_turno = table_total.querySelector(`#td_table_total_${table_total.dataset.cod}_personal_segundo_turno`);
    const element_administrativo = table_total.querySelector(`#td_table_total_${table_total.dataset.cod}_personal_administrativo`);
    const element_descanso_medico = table_total.querySelector(`#td_table_total_${table_total.dataset.cod}_personal_descanso_medico`);
    const element_vacaciones = table_total.querySelector(`#td_table_total_${table_total.dataset.cod}_personal_vacaciones_permisos`);
    const element_operativo = table_total.querySelector(`#td_table_total_${table_total.dataset.cod}_personal_operativo`);
    const element_nocturna_entrante = table_total.querySelector(`#td_table_total_${table_total.dataset.cod}_personal_nocturna_entrante`);
    const element_terminal_terrestre = table_total.querySelector(`#td_table_total_${table_total.dataset.cod}_personal_terminal_terrestre`);
    const element_franco = table_total.querySelector(`#td_table_total_${table_total.dataset.cod}_personal_franco`);
    const element_total = table_total.querySelector(`#td_table_total_${table_total.dataset.cod}_personal_total`);
    let agents_total = [];
    let agents_franco = [];

    //Agentes francos
    const agentesFranco = table_franco.querySelectorAll('.id_agent');
    agentesFranco.forEach(a => {
        agents_franco.push(a.dataset.at_id);
    });
    //--------------------------------------------

    agents_total = agents_total.concat(asignCountElement(['patrulleros_primer_turno', 'puntos_fijos_primer_turno', 'motorizados_primer_turno', 'ciclistas_primer_turno'], element_primer_turno));
    agents_total = agents_total.concat(asignCountElement(['patrulleros_segundo_turno', 'puntos_fijos_segundo_turno', 'motorizados_segundo_turno', 'ciclistas_segundo_turno'], element_segundo_turno));
    agents_total = agents_total.concat(asignCountElement(['personal_administrativo'], element_administrativo));
    agents_total = agents_total.concat(asignCountElement(['personal_descanso_medico'], element_descanso_medico));
    agents_total = agents_total.concat(asignCountElement(['personal_vacaciones'], element_vacaciones));
    agents_total = agents_total.concat(asignCountElement(['personal_operativo'], element_operativo));
    agents_total = agents_total.concat(asignCountElement(['personal_nocturna'], element_nocturna_entrante));
    agents_total = agents_total.concat(asignCountElement(['personal_terminal_terrestre'], element_terminal_terrestre));
    element_franco.innerText = agents_franco.length;
    agents_total = agents_total.concat(agents_franco);
    agents_total = [...new Set(agents_total)];
    element_total.innerText = agents_total.length;

}

function asignCountElement(listNames, element) {
    let names = "";
    listNames.forEach(n => {
        names += `[data-name="${n}"],`;
    });
    names = names.slice(0, -1);

    const elements = document.querySelectorAll(names);
    let agents = [];
    elements.forEach(e => {
        const inputsAgents = e.querySelectorAll('.row_list:not(.configure) input[data-origin="agente"], .cell:not(.configure.repeat) > input[data-origin="agente"]');
        inputsAgents.forEach(i => {
            if (i.dataset.at_id)
                agents.push(i.dataset.at_id);
        });
    });
    agents = [...new Set(agents)];
    if (element)
        element.innerText = agents.length;
    return agents;
}

function resolvePersonalFranco() {
    const agents = asignCountElement(['patrulleros_primer_turno',
        'puntos_fijos_primer_turno',
        'motorizados_primer_turno',
        'ciclistas_primer_turno',
        'patrulleros_segundo_turno',
        'puntos_fijos_segundo_turno',
        'motorizados_segundo_turno',
        'ciclistas_segundo_turno',
        'personal_administrativo',
        'personal_descanso_medico',
        'personal_vacaciones',
        'personal_operativo',
        'personal_nocturna',
        'personal_terminal_terrestre',
        'list_supervisor',
        'distribucion_supervisor',
        'horario_redactor']);
    list_personal_franco = list_all_agents.filter(f => !agents.includes(f.at_id.toString()));
    const table_franco = document.querySelector('.box-content[data-type="table_franco"]');
    addRowAgentFrancoToTable(table_franco.dataset.cod, list_personal_franco);
}

function getItemsContainers(container) {
    let items = container.querySelectorAll(':scope > div[data-type]');
    return [...items].map(i => {
        let value = {};
        switch (i.dataset.type) {
            case "title":
                let h1 = i.querySelector('h1');
                value = {
                    type: i.dataset.type,
                    name: i.dataset.name,
                    cod: i.dataset.cod,
                    text: h1.innerHTML.replace(/&amp;/g, "&"),
                    style: h1.getAttribute('style')
                }
                break;
            case "paragraph":
                let p = i.querySelector('p');
                value = {
                    type: i.dataset.type,
                    name: i.dataset.name,
                    cod: i.dataset.cod,
                    text: p.innerHTML.replace(/&amp;/g, "&"),
                    style: p.getAttribute('style')
                }
                break;
            case "container":
                let containerElements = i.querySelector('.container_elements');
                let styleBackgroundHeader = containerElements.querySelector('.container_elements_header');
                let element = styleBackgroundHeader.querySelector('.container_elements_header_text');
                value = {
                    type: i.dataset.type,
                    cod: i.dataset.cod,
                    name: i.dataset.name,
                    styleHeader: styleBackgroundHeader.getAttribute('style'),
                    styleParrafo: element.getAttribute('style'),
                    textHeader: element.innerHTML,
                    items: getItemsContainers(containerElements)
                }
                break;
            case "list":
                let listContainer = i.querySelector('.list_container');
                value = {
                    type: i.dataset.type,
                    cod: i.dataset.cod,
                    name: i.dataset.name,
                    items: [...listContainer.querySelectorAll(':scope > div[data-cod]:not(.configure)')].map(l => {
                        return {
                            index: l.dataset.index,
                            bind: l.dataset.bind,
                            row: l.dataset.row,
                            izq: resolveValueList(l.querySelector('div.izq')),
                            der: resolveValueList(l.querySelector('div.der'))
                        }
                    })
                }
                break;
            case "table":
                let table = i.querySelector('.table');
                let columns = table.querySelectorAll('div.header_table');
                let filas = table.querySelectorAll('.cell[data-row]');
                let filas_agregadas = [];
                value = {
                    type: i.dataset.type,
                    cod: i.dataset.cod,
                    name: i.dataset.name,
                    cod_copy: i.dataset.cod_copy ?? '',
                    styleThead: table.dataset.style_th,
                    headerColumns: [...columns].map(c => {
                        return {
                            styleTh: c.dataset.style_th,
                            styleP: c.querySelector('p').getAttribute('style'),
                            text: c.querySelector('p').innerText
                        }
                    }),
                    filas: [...filas].map(f => {
                        let typeFila = `o${f.dataset.row}`;
                        const noAction = table.querySelector(`div.not_actions[data-row="${f.dataset.row}"]`);

                        if (!noAction) {
                            if (!f.dataset.row_copy)
                                return;
                            typeFila = `c${f.dataset.row_copy}`;
                        }

                        if (!filas_agregadas.includes(typeFila)) {
                            filas_agregadas.push(typeFila);
                            return resolveFilasTable(table, f);
                        }
                    }).filter(f => f != undefined)
                }
                break;
            case "table_total":
                let table_total = i.querySelector('.table');
                let list_name_summary = table_total.querySelectorAll('.name_summary');
                let list_value_summary = table_total.querySelectorAll('.value_summary');
                value = {
                    type: i.dataset.type,
                    cod: i.dataset.cod,
                    name: i.dataset.name,
                    items: [...list_name_summary].map((s, index) => {
                        return {
                            name: s.innerText,
                            value: list_value_summary[index].innerText
                        }
                    })
                }
                break;
            case "table_franco":
                let table_franco = i.querySelector('.table_franco');
                let list_rows = table_franco.querySelectorAll('.count_row');
                let list_cod_agentes = table_franco.querySelectorAll('.at_id');
                let list_name_agents = table_franco.querySelectorAll('.agent');
                let list_ids_agents = table_franco.querySelectorAll('.id_agent');
                value = {
                    type: i.dataset.type,
                    cod: i.dataset.cod,
                    name: i.dataset.name,
                    items: [...list_rows].map((r, index) => {
                        return {
                            row: r.innerText,
                            id: list_ids_agents[index].dataset.at_id,
                            codigo: list_cod_agentes[index].innerText,
                            name: list_name_agents[index].innerText
                        }
                    })
                }
                break;
            case "image":
                let containerImage = i.querySelector('.image_content');
                value = {
                    type: i.dataset.type,
                    cod: i.dataset.cod,
                    name: i.dataset.name,
                    image: containerImage.dataset.image
                }
                break;
            default:
                break;
        }
        return value;
    });
}

function resolveFilasTable(table, fila) {

    datasetJson = {
        row: fila.dataset.row,
        columns: []
    };

    let rowCopy = null;

    let rowOriginal = table.querySelectorAll(`div.cell.configure[data-row="${fila.dataset.row}"]`);
    if (fila.dataset.row_copy) {
        rowCopy = table.querySelectorAll(`div.cell[data-row_copy="${fila.dataset.row_copy}"]`);
        datasetJson.row_copy = fila.dataset.row_copy;
    }


    rowOriginal.forEach((r, i) => {
        let row = r;
        let column = {};
        if (rowCopy && r.dataset.repeat == "si") {
            row = [...rowCopy].filter(element => element.dataset.col == r.dataset.col)[0];
        }

        column['type'] = row.dataset.type
        column['origin'] = row.dataset.origin

        switch (row.dataset.type) {
            case "text":
                column['data_text'] = row.querySelector('p').dataset.text;
                column['value'] = row.querySelector('p').innerText;
                column['style'] = row.querySelector('p').getAttribute('style');
                break;
            case "clear":
                column['value'] = row.querySelector('p').innerText;
                column['style'] = row.querySelector('p').getAttribute('style');
                break;
            case "dataset":
                column['data_data'] = row.querySelector('p').dataset.data;
                column['value'] = row.querySelector('p').innerText;
                column['style'] = row.querySelector('p').getAttribute('style');
                break;
            case "search":
                column['value'] = row.querySelector('input').dataset.value ?? '';
                column['text'] = row.querySelector('input').dataset.text ?? '';
                column['style'] = row.querySelector('input').getAttribute('style');
                if (row.querySelector('input').dataset.origin == "agente") {
                    column['at_id'] = row.querySelector('input').dataset.at_id ?? '';
                    column['at_codigo'] = row.querySelector('input').dataset.at_codigo ?? '';
                    column['emp_cedula'] = row.querySelector('input').dataset.emp_cedula ?? '';
                }
                break;
        }

        datasetJson.columns.push(column);
    });

    return datasetJson;
}

function resolveValueList(containerCell) {
    let datasetJson = {};
    if (containerCell.dataset.type == "text") {
        datasetJson["type"] = "text";
        datasetJson["value"] = containerCell.querySelector('p.text_list').innerHTML;
    }
    if (containerCell.dataset.type == "search") {
        let input = containerCell.querySelector('input.input_list');
        Object.keys(input.dataset).map(key => {
            datasetJson[key] = input.dataset[key];
        })
    }
    return datasetJson;
}

function loadPlantillaActive() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: `/conf_agentes_transito_plantilla/getPlantilla`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.length > 0) {
                let plantillaContainer = document.getElementById(containerMain);
                conf_plantilla = JSON.parse(response[0].cf_plantilla);
                readPlantillaCargada(conf_plantilla, plantillaContainer);
                $("#global-loader").removeClass("block");
                $("#global-loader").addClass("none");
                autosave = true;
            }
        }
    });
}

function readPlantillaCargada(elements, container) {
    elements.forEach(e => {
        switch (e.type) {
            case "title":
            case "paragraph":
                const newElementTitle = createElement(e);
                container.appendChild(newElementTitle);
                break;
            case "container":
                const newElementContainer = createElement(e);
                container.appendChild(newElementContainer);
                break;
            case "list":
                const newElementList = createElement(e);
                container.appendChild(newElementList);
                let inputsBusqueda = newElementList.querySelectorAll('input[data-origin="agente"]');
                let configureOptions = newElementList.querySelectorAll('.row_list.configure > .configure_options');
                inputsBusqueda.forEach(i => {
                    setBusqAgenteList(i, e.name);
                });
                configureOptions.forEach(c => {
                    setActionsConfigureOption(c, e.name);
                });
                setearFilasIngresadas(newElementList);
                break;
            case "table":
                const newElementTable = createElement(e);
                container.appendChild(newElementTable);
                let addRecordTable = newElementTable.querySelectorAll('.configure_options > .ok_row_table');
                let clearRecordTable = newElementTable.querySelectorAll('.configure_options > .delete_row_table');
                let inputsBusquedaTabla = newElementTable.querySelectorAll('input[data-origin="agente"]');
                let optionsContainer = newElementTable.querySelector('.table_options');
                inputsBusquedaTabla.forEach(i => {
                    setTimeout(() => {
                        setBusqAgenteTable(i, e.name);
                    }, 1000);
                });
                clearRecordTable.forEach(c => {
                    clearRowTable(newElementTable, c);
                });
                addRecordTable.forEach(c => {
                    addRowTable(newElementTable, c, e.name);
                });
                asignOptionsTable(optionsContainer, e.name);
                break;
            case "table_total":
                const newElementTable_total = createElement(e);
                container.appendChild(newElementTable_total);
                break;
            case "table_franco":
                const newElementTable_franco = createElement(e);
                container.appendChild(newElementTable_franco);
                break;
            case "image":
                const newElementImage = createElement(e);
                container.appendChild(newElementImage);
                let imageContainer = newElementImage.querySelector('.image_content');
                let carpeta = "/imagenes_orden_cuerpo";
                let rutaFile = `${carpeta}/${e.name}`;
                imageContainer.style.backgroundImage = "url('" + rutaFile + "')";
                break;

            default:
                break;
        }
    });
}

function createElement(element) {
    const newElement = document.createElement('div');
    newElement.classList.add('box-content');
    newElement.dataset.type = element.type;
    newElement.dataset.name = element.name;
    let cont = readMaxTypeContainer(element.type) + 1;
    newElement.dataset.cod = cont;
    newElement.dataset.cod_original = cont;

    switch (element.type) {
        case 'title':
            newElement.innerHTML = getPlantillaTitulo(element.text, element.style);
            break;
        case 'paragraph':
            newElement.innerHTML = getPlantillaParrafo(element.text, element.style);
            break;
        case "container":
            newElement.innerHTML = getContenedorPlantilla(element.textHeader, element.styleParrafo, element.styleHeader);
            let containerZone = newElement.querySelector('.dropzone');
            readPlantillaCargada(element.items, containerZone);
            break;
        case "list":
            newElement.innerHTML = getPlantillaLista(element.items, cont);
            break;
        case "table":
            newElement.innerHTML = getContenedorTabla(element, cont);
            break;
        case "table_total":
            newElement.innerHTML = getContenedorTabla_total(cont);
            break;
        case "table_franco":
            newElement.innerHTML = getContenedorTabla_franco(cont);
            break;
        case "image":
            newElement.innerHTML = getPlantillaImage(element.name);
            break;
        default:
            console.log('no implementado');
    }
    return newElement;
}

//Funciones para titulo
function getPlantillaTitulo(titulo, style) {
    let value = changeConstantValues(titulo);
    return `
            <h1 class="text_align" style="${style}" contenteditable="true">${value}</h1>
    `;
}
//Fin Funciones para titulo

//Funciones para parrafo
function getPlantillaParrafo(titulo, style) {
    let value = changeConstantValues(titulo);
    return `
        <p class="paragraph text_align" style="${style}" contenteditable="true">${value}</p>
    `;
}
//Fin Funciones para parrafo

//Funciones para container
function getContenedorPlantilla(titulo, styleText, styleBackground) {
    return `
        <div class="container_elements dropzone">
            <div class="container_elements_header background_color text_color" style="${styleBackground}">
                <p class="no_margin container_elements_header_text text_align bold_text" style="${styleText}" contenteditable="true">${changeConstantValues(titulo)}</p>
            </div>
        </div>
    `;
}
//Fin Funciones para container

//Funciones para Lista
function getPlantillaLista(items, cod) {
    let filas = '';

    items.forEach((i, k) => {
        filas += `
        <div class="row_list ${i.repeat == 'si' ? 'configure' : ''}" data-cod="${cod}" data-index="${k + 1}" data-bind="${i.repeat == 'si' ? k + 1 : '0'}">
            <div class="row_list_col izq" data-type="${i.izq.type}">
                ${renderCellList(i.izq, "izq", cod, k + 1)}
            </div>
            <div class="row_list_col der" data-type="${i.der.type}">
                ${renderCellList(i.der, "der", cod, k + 1)}
            </div>
            <span class="configure_options">
                ${i.repeat == 'si' ? `<i class="fa fa-check" id="list_conf_camp_ok_${cod}_${k + 1}" aria-hidden="true"></i>` : ''}
                ${i.repeat == 'si' ? `<i class="fa fa-trash" id="list_conf_camp_trash_${cod}_${k + 1}" aria-hidden="true"></i>` : ''}
            </span>
        </div>`;
    });

    return `
            <div class="list_container">
                ${filas}
            </div>
    `;
}

function renderCellList(opcion, direction, cod, index) {
    let element = '';
    if (opcion.type == "text") {
        element = `<p class="no_margin text_list" contenteditable="true" data-text="${opcion.text}">${opcion.text}</p> `;
    }
    if (opcion.type == "search") {
        element = `<input class="input_list" id="list_${opcion.origin}_${direction}_${cod}_${index}" data-id="list_${opcion.origin}_${direction}_${cod}_${index}" style="text-transform: uppercase;" type="text" name="${opcion.origin}" data-origin="${opcion.origin}" data-busq="${opcion.busq}" data-data="${opcion.data}" data-campo="${opcion.campo}" data-label="Agente" data-noresults_text="No se encontraron resultados" data-wait_search="Buscando Agentes..." placeholder = "Buscar agente..." autocomplete="off" /> `;
    }
    return element;
}

function setearFilasIngresadas(container) {
    let listContainer = container.querySelector('.list_container');
    let filas = listContainer.querySelectorAll('.row_list:not(.configure)');
    let i = 1;
    filas.forEach(f => {
        f.dataset.row = i++;
    });
}

function setActionsConfigureOption(containerOptions, name) {
    let okControls = containerOptions.querySelector(':scope > i[id^="list_conf_camp_ok_"]');
    let resetControls = containerOptions.querySelector(':scope > i[id^="list_conf_camp_trash_"]');
    let padreContainer = containerOptions.parentElement;

    okControls.addEventListener('click', () => {
        duplicateFilaList(padreContainer, name);
    });

    resetControls.addEventListener('click', () => {
        clearListConfigure(padreContainer);
    });
}

function duplicateFilaList(padreContainer, name, clearParent = true) {
    const clonRow = padreContainer.cloneNode(true);
    clonRow.classList.remove('configure');
    padreContainer.parentElement.insertBefore(clonRow, padreContainer);
    setearFilasIngresadas(padreContainer.parentElement.parentElement);
    let inputsBusq = clonRow.querySelectorAll('input[data-origin="agente"]');
    let containerOptions = clonRow.querySelector('.configure_options');
    if (clearParent)
        clearListConfigure(padreContainer);
    inputsBusq.forEach(i => {
        i.id = `${i.dataset.id}_${idList} `;
        setBusqAgenteList(i, name);
    });
    containerOptions.innerHTML = `
            <i class="fa fa-arrow-circle-down" id="list_conf_camp_duplicate_${clonRow.dataset.cod}_${clonRow.dataset.index}_${idList}" aria-hidden="true"></i >
                <i class="fa fa-trash" id="list_conf_camp_trash_${clonRow.dataset.cod}_${clonRow.dataset.index}_${idList}" aria-hidden="true"></i>
        `;

    let deleteIcon = containerOptions.querySelector(`i[id = "list_conf_camp_trash_${clonRow.dataset.cod}_${clonRow.dataset.index}_${idList}"]`);
    let duplicateIcon = containerOptions.querySelector(`i[id = "list_conf_camp_duplicate_${clonRow.dataset.cod}_${clonRow.dataset.index}_${idList}"]`);

    deleteIcon.addEventListener('click', () => {
        clonRow.remove();
        resolvePersonalFranco();
        calculateSummaryAgents();
    });

    duplicateIcon.addEventListener('click', () => {
        duplicateFilaList(containerOptions.parentElement, clonRow.dataset.name, false);
    });

    resolvePersonalFranco();
    calculateSummaryAgents();


    idList++;
}

function clearListConfigure(containerPadre) {
    let texts = containerPadre.querySelectorAll('p.text_list');
    let searchInputs = containerPadre.querySelectorAll('input[data-origin="agente"]');

    texts.forEach(t => {
        t.innerHTML = t.dataset.text;
    });

    searchInputs.forEach(s => {
        s.value = "";
        s.dataset.value = "";
        s.dataset.at_id = "";
        s.dataset.text = "";
    });
}

function setBusqAgenteList(element, name) {
    setBusqAgente(element, name);
    element.addEventListener('changeAsing', (e) => {
        resolvePersonalFranco();
        calculateSummaryAgents();
        if (autosave) {
            autosave = false;
            saveDataOrdenCuerpo(function () {
                autosave = true;
            });
        }
    });
}
//Fin Funciones para Lista

//Funciones para imagen
function getPlantillaImage(imagen) {
    return `
            <div class="image_content" data-image="${imagen}">
            </div>
    `;
}
//Fin de funciones para imagen

//Funciones para Tabla
function getContenedorTabla(table, cod) {
    const countColumns = table.filas[0].columns.length;
    let columnsHeaders = '';
    let filas = '';
    let repeatOption = false;
    let column = 1;
    let row = 1;
    table.headerColumns.forEach((h, i) => {
        columnsHeaders += `
        <div class="header_table" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${table.uniqueColumHeader ? countColumns + 1 : column + 1}" data-style_th="${h.styleTh}" style="${table.styleThead} ${h.styleTh} grid-column-start: ${column}; ${table.uniqueColumHeader ? `grid-column-end: ${countColumns + 1};` : `grid-column-end: ${column + 1};`}">
            <p class="no_margin" contenteditable="true" style="${h.styleP}">${h.text}</p>
        </div>`;
        column++;
    });
    row++;

    table.filas.forEach(f => {
        repeatOption = false;

        column = 1;
        f.columns.forEach(c => {
            repeatOption = repeatOption || c.dataset.repeat == "si";
            filas += `
                <div class="cell configure ${c.dataset.repeat == "si" ? 'repeat' : ''}" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="${c.dataset.row}" data-col="${c.dataset.col}" data-repeat="${c.dataset.repeat == "si" ? 'si' : 'no'}" data-type="${c.dataset.type}" data-origin="${c.dataset.origin}">${renderCellTable(c, cod)}</div>
            `;
            column++;
        });

        if (repeatOption) {
            filas += `
            <div class="configure_table_div configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="${f.row}">
                <span class="configure_options configure_table">
                    <i class="fa fa-check ok_row_table" data-row="${f.row}" aria-hidden="true"></i>
                    <i class="fa fa-trash delete_row_table" data-row="${f.row}" aria-hidden="true"></i>
                </span>
            </div>
            `;
        }
        else {
            filas += `<div class="not_actions" data-row="${f.row}" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}"></div>`;
        }
        row++;
    });

    return `
            <div class="table_container">
                ${table.repeat == "si"
            ? `
                    <div class="table_options">
                            <span class="badge bg-light option_table duplicate_table"><i class="fa fa-files-o" aria-hidden="true"></i> Duplicar</span>
                        </div>
                    `
            : ''}
                <div class="table" data-style_th="${table.styleThead}" style="grid-template-columns: repeat(${countColumns}, minmax(max-content, 1fr)) max-content;">
                    ${columnsHeaders}
                    <div class="header_opciones"></div>

                    ${filas}
                </div>
            </div>
            `;
}

function renderCellTable(colData, cod) {
    let element = '';
    if (colData.dataset.type == "text") {
        let countRows = false;
        let textCell = colData.dataset.text;
        if (colData.dataset.text.includes("&COUNT_ROW")) {
            textCell = colData.dataset.text.replace(/&COUNT_ROW/g, '-');
            countRows = true;
        }
        element = `<p class="no_margin p_border max_width_cell" style="${colData.styleP}" data-count_row="${countRows}" data-text="${colData.dataset.text}" contenteditable="true">${textCell}</p>`;
    }
    if (colData.dataset.type == "clear") {
        element = `<p class="no_margin p_border max_width_cell" style="${colData.styleP}" contenteditable="true"></p> `;
    }
    if (colData.dataset.type == "dataset") {
        element = `<p class="no_margin max_width_cell" style="${colData.styleP}" data-data="${colData.dataset.data}"></p> `;
    }
    if (colData.dataset.type == "search") {
        element = `<input class="input_list input_cell" id="table_${cod}_${colData.dataset.row}_${colData.dataset.col}" data-setting="${colData.dataset.row}_${colData.dataset.col}" data-id="table_${cod}_${colData.dataset.row}_${colData.dataset.col}" style="text-transform: uppercase;" type="text" name="${colData.dataset.namecol}" data-origin="${colData.dataset.origin}" data-busq="${colData.dataset.busq}" data-data="${colData.dataset.data}" data-campo="${colData.dataset.campo}" data-label="Agente" data-noresults_text="No se encontraron resultados" data-wait_search="Buscando Agentes..." placeholder = "Buscar agente..." autocomplete="off" /> `;
    }
    return element;
}

function asignOptionsTable(optionsContainer, name) {
    if (!optionsContainer)
        return;

    let btnDelete = optionsContainer.querySelector('.delete_table');
    let btnDuplicate = optionsContainer.querySelector('.duplicate_table');
    btnDuplicate.addEventListener('click', () => {
        let tableClon = optionsContainer.parentElement.parentElement.cloneNode(true);
        optionsContainer.parentElement.parentElement.insertAdjacentElement('afterend', tableClon);
        let cont = readMaxTypeContainer(tableClon.dataset.type) + 1;
        tableClon.dataset.cod_copy = tableClon.dataset.cod_original;
        tableClon.dataset.cod = cont;
        let addRecordTable = tableClon.querySelectorAll('.configure_table_div.configure > .configure_options > .ok_row_table');
        let clearRecordTable = tableClon.querySelectorAll('.configure_table_div.configure > .configure_options > .delete_row_table');
        let deleteRecordTableNotConfigure = tableClon.querySelectorAll('.configure_table_div:not(.configure) > .configure_options > .delete_row_table');
        let duplicateRecordTableNotConfigure = tableClon.querySelectorAll('.configure_table_div:not(.configure) > .configure_options > .duplicate_row_table');
        let inputsBusquedaTabla = tableClon.querySelectorAll('input[data-origin="agente"]');
        let optionsContainerN = tableClon.querySelector('.table_options');

        if (!optionsContainerN.querySelector('.delete_table'))
            optionsContainerN.innerHTML += `
                <span class="badge bg-light option_table delete_table"><i class="fa fa-trash" aria-hidden="true"></i> Borrar</span>
            `;

        inputsBusquedaTabla.forEach(i => {
            setTimeout(() => {
                i.id = `table_${cont}_${i.dataset.setting}_${idAgentRowTable++}`;
                i.dataset.id = `table_${cont}_${i.dataset.setting}`;
                setBusqAgenteTable(i, name);
            }, 1000);
        });
        clearRecordTable.forEach(c => {
            clearRowTable(tableClon, c);
        });
        addRecordTable.forEach(c => {
            addRowTable(tableClon, c, name);
        });
        deleteRecordTableNotConfigure.forEach(c => {
            deleteRowNewTable(tableClon, c);
        });
        duplicateRecordTableNotConfigure.forEach(c => {
            duplicateRowNewTable(tableClon, c, name);
        });
        asignOptionsTable(optionsContainerN, name);
    });
    if (btnDelete) {
        btnDelete.addEventListener('click', () => {
            btnDelete.parentElement.parentElement.parentElement.remove();
        });
    }
}

function addRowTable(containerTable, buttonAdd, name) {
    buttonAdd.addEventListener('click', () => {
        let cellsRow = containerTable.querySelectorAll(`.cell.configure[data-row="${buttonAdd.dataset.row}"]:not([data-row_copy])`);
        let cellInsertRow = containerTable.querySelector(`.cell.configure[data-row="${buttonAdd.dataset.row}"][data-col="1"]:not([data-row_copy])`);
        let configureOption = containerTable.querySelector(`.configure_table_div.configure[data-row="${buttonAdd.dataset.row}"]:not([data-row_copy])`);
        addElementRowTable(containerTable, cellsRow, cellInsertRow, configureOption, name, buttonAdd);
        resolvePersonalFranco();
        calculateSummaryAgents();
    });
}

function addElementRowTable(containerTable, cellsRow, cellInsertRow, configureOption, name, buttonAdd = "no") {
    const cloneOption = configureOption.cloneNode(true);
    cloneOption.dataset.row_copy = idRowTable;
    cloneOption.classList.remove('configure');
    cloneOption.innerHTML = `
        <span class="configure_options configure_table">
            <i class="fa fa-arrow-circle-down duplicate_row_table" data-row="${cellInsertRow.dataset.row}" data-row_copy="${idRowTable}" aria-hidden="true"></i>
            <i class="fa fa-trash delete_row_table" data-row="${cellInsertRow.dataset.row}" data-row_copy="${idRowTable}" aria-hidden="true"></i>
        </span>
    `;

    let deleteButton = cloneOption.querySelector('.delete_row_table');
    let duplicateButton = cloneOption.querySelector('.duplicate_row_table');
    cellsRow.forEach(c => {
        if (c.dataset.repeat == "si") {
            const clonCell = c.cloneNode(true);
            clonCell.dataset.row_copy = idRowTable;
            clonCell.classList.remove('configure');
            cellInsertRow.parentElement.insertBefore(clonCell, cellInsertRow);
            let inputBusquedaTabla = clonCell.querySelector('input[data-origin="agente"]');
            if (inputBusquedaTabla) {
                inputBusquedaTabla.id = inputBusquedaTabla.dataset.id + `_${idAgentRowTable++}`;
                setBusqAgenteTable(inputBusquedaTabla, name);
            }

        } else {
            movePositionRowEndCell(containerTable, c);
        }
    });

    idRowTable++;
    deleteRowNewTable(containerTable, deleteButton);
    duplicateRowNewTable(containerTable, duplicateButton, name);
    countRowTable(containerTable);
    resolvePersonalFranco();
    calculateSummaryAgents();
    if (buttonAdd != "no")
        clearRowTableEvent(containerTable, buttonAdd.dataset.row);
    cellInsertRow.parentElement.insertBefore(cloneOption, cellInsertRow);
}

function movePositionRowEndCell(container, element, sumStart = 0) {
    if (!element)
        return;
    let nextElement = container.querySelector(`.cell[data-row="${+element.dataset.row + 1}"][data-col="${element.dataset.col}"][data-row_start="${element.dataset.row_end}"]`);
    movePositionRowEndCell(container, nextElement, 1);
    element.dataset.row_start = +element.dataset.row_start + sumStart;
    element.dataset.row_end = +element.dataset.row_end + 1;
    element.style.gridColumnStart = element.dataset.column_start;
    element.style.gridColumnEnd = element.dataset.column_end;
    element.style.gridRowStart = element.dataset.row_start;
    element.style.gridRowEnd = element.dataset.row_end;
}

function setBusqAgenteTable(element, name) {
    setBusqAgente(element, name);
    element.addEventListener('changeAsing', (e) => {
        let origin = element.dataset.origin;
        let selector = element.parentElement.dataset.row_copy ? `[data-row_copy="${element.parentElement.dataset.row_copy}"]` : `[data-row="${element.parentElement.dataset.row}"]:not([data-row_copy])`;
        let cellsDataset = element.parentElement.parentElement.querySelectorAll(`.cell[data-type="dataset"]${selector} > p[data-data*="${origin}."]`);
        cellsDataset.forEach(c => {
            c.innerHTML = eval('`' + c.dataset.data.replace(`${origin}.`, 'element.dataset.') + '`');
        });
        resolvePersonalFranco();
        calculateSummaryAgents();

        if (autosave) {
            autosave = false;
            saveDataOrdenCuerpo(function () {
                autosave = true;
            });
        }
    });
}

function countRowTable(containerTable) {
    let pCells = containerTable.querySelectorAll('.cell[data-type="text"]:not(.configure) > p[data-text*="&COUNT_ROW"]');
    let cols = [];
    pCells.forEach(p => {
        if (!cols.includes(p.parentElement.dataset.col)) {
            let cont = 1;
            pCellsCount = containerTable.querySelectorAll(`.cell[data-type="text"][data-col="${p.parentElement.dataset.col}"]:not(.configure) > p[data-text*="&COUNT_ROW"]`);
            pCellsCount.forEach(p => {
                p.innerHTML = p.dataset.text.replace('&COUNT_ROW', cont);
                cont++;
            });
            cols.push(p.parentElement.dataset.col);
        }
    });
}

function duplicateRowNewTable(containerTable, button, name) {
    button.addEventListener('click', () => {
        let cellsRow = containerTable.querySelectorAll(`.cell.configure[data-row="${button.dataset.row}"]:not([data-row_copy])`);
        let cellInsertRow = containerTable.querySelector(`.cell[data-row="${button.dataset.row}"][data-row_copy="${button.dataset.row_copy}"]`);
        let configureOption = containerTable.querySelector(`.configure_table_div.configure[data-row="${button.dataset.row}"]:not([data-row_copy])`);
        cellsRow = [...cellsRow].map(c => {
            let element = c;
            if (c.dataset.repeat == "si") {
                element = containerTable.querySelector(`.cell[data-row="${button.dataset.row}"][data-col="${c.dataset.col}"][data-row_copy="${button.dataset.row_copy}"]`);
            }
            return element;
        });
        addElementRowTable(containerTable, cellsRow, cellInsertRow, configureOption, name);
    });
}

function deleteRowNewTable(containerTable, button) {
    button.addEventListener('click', () => {
        let cellsRowRepeat = containerTable.querySelectorAll(`.cell.configure[data-row="${button.dataset.row}"][data-repeat="no"]:not([data-row_copy])`);
        let cellsRow = containerTable.querySelectorAll(`.cell[data-row="${button.dataset.row}"][data-row_copy="${button.dataset.row_copy}"]`);
        let configureOption = containerTable.querySelector(`.configure_table_div[data-row="${button.dataset.row}"][data-row_copy="${button.dataset.row_copy}"]`);
        cellsRowRepeat.forEach(c => {
            reducePositionRowEndCell(containerTable, c);
        });
        cellsRow.forEach(c => {
            c.remove();
        });
        configureOption.remove();
        countRowTable(containerTable);
        resolvePersonalFranco();
        calculateSummaryAgents();
    });
}

function reducePositionRowEndCell(container, element, restStart = 0) {
    if (!element)
        return;
    let nextElement = container.querySelector(`.cell[data-row="${+element.dataset.row + 1}"][data-col="${element.dataset.col}"][data-row_start="${element.dataset.row_end}"]`);
    reducePositionRowEndCell(container, nextElement, 1);
    element.dataset.row_start = +element.dataset.row_start - restStart;
    element.dataset.row_end = +element.dataset.row_end - 1;
    element.style.gridColumnStart = element.dataset.column_start;
    element.style.gridColumnEnd = element.dataset.column_end;
    element.style.gridRowStart = element.dataset.row_start;
    element.style.gridRowEnd = element.dataset.row_end;
}

function clearRowTable(containerTable, buttonClear) {
    buttonClear.addEventListener('click', () => {
        clearRowTableEvent(containerTable, buttonClear.dataset.row);
    });
}

function clearRowTableEvent(containerTable, row) {
    let cellsRow = containerTable.querySelectorAll(`.cell.configure[data-row="${row}"][data-repeat="si"]`);
    cellsRow.forEach(c => {
        if (c.dataset.type == "text") {
            let p = c.querySelector('p');
            let textCell = p.dataset.text;
            if (p.dataset.text.includes("&COUNT_ROW")) {
                textCell = p.dataset.text.replace(/&COUNT_ROW/g, '-');
            }
            p.innerHTML = textCell;
        }
        if (c.dataset.type == "clear" || c.dataset.type == "dataset") {
            let p = c.querySelector('p');
            p.innerHTML = "";
        }
        if (c.dataset.type == "search") {
            let input = c.querySelector('input');
            input.value = "";
            input.dataset.value = "";
            input.dataset.text = "";
            input.dataset.at_id = "";
        }
    });
}
//Fin Funciones para tabla


//funciones tabla total
function getContenedorTabla_total(cod) {
    let columnsHeaders = '';
    let filas = '';
    let repeatOption = false;
    let column = 1;
    let row = 1;

    //TOTAL PERSONAL
    columnsHeaders += `
    <div class="header_table" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 2}" style="grid-column-start: ${column}; grid-column-end: ${column + 2};">
        <p class="no_margin">TOTAL PERSONAL</p>
    </div>`;
    column++;
    row++;
    //FIN TOTAL PERSONAL

    //PERSONAL PRIMER TURNO
    column = 1;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="1" data-col="1" data-repeat="no" data-type="TEXT" data-origin="">
            <p class="no_margin p_border max_width_cell name_summary" data-text="PERSONAL PRIMER TURNO">PERSONAL PRIMER TURNO</p>
        </div>
    `;
    column++;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="1" data-col="2" data-repeat="no" data-type="TEXT" data-origin="">
            <p id="td_table_total_${cod}_personal_primer_turno" class="no_margin p_border max_width_cell value_summary" data-text="0">0</p>
        </div>
    `;
    column++;
    filas += `<div class="not_actions" data-row="1" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}"></div>`;
    row++;
    //FIN PERSONAL PRIMER TURNO

    //PERSONAL SEGUNDO TURNO
    column = 1;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="2" data-col="1" data-repeat="no" data-type="TEXT" data-origin="">
            <p class="no_margin p_border max_width_cell name_summary" data-text="PERSONAL SEGUNDO TURNO">PERSONAL SEGUNDO TURNO</p>
        </div>
    `;
    column++;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="2" data-col="2" data-repeat="no" data-type="TEXT" data-origin="">
            <p id="td_table_total_${cod}_personal_segundo_turno" class="no_margin p_border max_width_cell value_summary" data-text="0">0</p>
        </div>
    `;
    column++;
    filas += `<div class="not_actions" data-row="2" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}"></div>`;
    row++;
    //FIN PERSONAL SEGUNDO TURNO

    //PERSONAL ADMINISTRATIVO
    column = 1;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="3" data-col="1" data-repeat="no" data-type="TEXT" data-origin="">
            <p class="no_margin p_border max_width_cell name_summary" data-text="PERSONAL ADMINISTRATIVO">PERSONAL ADMINISTRATIVO</p>
        </div>
    `;
    column++;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="3" data-col="2" data-repeat="no" data-type="TEXT" data-origin="">
            <p id="td_table_total_${cod}_personal_administrativo" class="no_margin p_border max_width_cell value_summary" data-text="0">0</p>
        </div>
    `;
    column++;
    filas += `<div class="not_actions" data-row="3" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}"></div>`;
    row++;
    //FIN PERSONAL ADMINISTRATIVO

    //PERSONAL DESCANSO MEDICO
    column = 1;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="4" data-col="1" data-repeat="no" data-type="TEXT" data-origin="">
            <p class="no_margin p_border max_width_cell name_summary" data-text="PERSONAL DESCANSO MEDICO">PERSONAL DESCANSO MEDICO</p>
        </div>
    `;
    column++;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="4" data-col="2" data-repeat="no" data-type="TEXT" data-origin="">
            <p id="td_table_total_${cod}_personal_descanso_medico" class="no_margin p_border max_width_cell value_summary" data-text="0">0</p>
        </div>
    `;
    column++;
    filas += `<div class="not_actions" data-row="4" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}"></div>`;
    row++;
    //FIN PERSONAL DESCANSO 

    //PERSONAL VACACIONES
    column = 1;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="5" data-col="1" data-repeat="no" data-type="TEXT" data-origin="">
            <p class="no_margin p_border max_width_cell name_summary" data-text="PERSONAL CON VACACIONES - PERMISOS">PERSONAL CON VACACIONES - PERMISOS</p>
        </div>
    `;
    column++;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="5" data-col="2" data-repeat="no" data-type="TEXT" data-origin="">
            <p id="td_table_total_${cod}_personal_vacaciones_permisos" class="no_margin p_border max_width_cell value_summary" data-text="0">0</p>
        </div>
    `;
    column++;
    filas += `<div class="not_actions" data-row="5" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}"></div>`;
    row++;
    //FIN PERSONAL VACACIONES

    //PERSONAL OPERATIVO
    column = 1;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="6" data-col="1" data-repeat="no" data-type="TEXT" data-origin="">
            <p class="no_margin p_border max_width_cell name_summary" data-text="PERSONAL OPERATIVO">PERSONAL OPERATIVO</p>
        </div>
    `;
    column++;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="6" data-col="2" data-repeat="no" data-type="TEXT" data-origin="">
            <p id="td_table_total_${cod}_personal_operativo" class="no_margin p_border max_width_cell value_summary" data-text="0">0</p>
        </div>
    `;
    column++;
    filas += `<div class="not_actions" data-row="6" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}"></div>`;
    row++;
    //FIN PERSONAL OPERATIVO

    //PERSONAL NOCTURNA ENTRANTE
    column = 1;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="7" data-col="1" data-repeat="no" data-type="TEXT" data-origin="">
            <p class="no_margin p_border max_width_cell name_summary" data-text="PERSONAL NOCTURNA ENTRANTE">PERSONAL NOCTURNA ENTRANTE</p>
        </div>
    `;
    column++;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="7" data-col="2" data-repeat="no" data-type="TEXT" data-origin="">
            <p id="td_table_total_${cod}_personal_nocturna_entrante" class="no_margin p_border max_width_cell value_summary" data-text="0">0</p>
        </div>
    `;
    column++;
    filas += `<div class="not_actions" data-row="7" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}"></div>`;
    row++;
    //FIN PERSONAL NOCTURNA ENTRANTE

    //PERSONAL TERMINAL TERRESTRE
    column = 1;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="8" data-col="1" data-repeat="no" data-type="TEXT" data-origin="">
            <p class="no_margin p_border max_width_cell name_summary" data-text="PERSONAL TERMINAL TERRESTRE">PERSONAL TERMINAL TERRESTRE</p>
        </div>
    `;
    column++;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="8" data-col="2" data-repeat="no" data-type="TEXT" data-origin="">
            <p id="td_table_total_${cod}_personal_terminal_terrestre" class="no_margin p_border max_width_cell value_summary" data-text="0">0</p>
        </div>
    `;
    column++;
    filas += `<div class="not_actions" data-row="8" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}"></div>`;
    row++;
    //FIN PERSONAL TERMINAL TERRESTRE

    //PERSONAL FRANCO
    column = 1;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="9" data-col="1" data-repeat="no" data-type="TEXT" data-origin="">
            <p class="no_margin p_border max_width_cell name_summary" data-text="PERSONAL FRANCO">PERSONAL FRANCO</p>
        </div>
    `;
    column++;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="9" data-col="2" data-repeat="no" data-type="TEXT" data-origin="">
            <p id="td_table_total_${cod}_personal_franco" class="no_margin p_border max_width_cell value_summary" data-text="0">0</p>
        </div>
    `;
    column++;
    filas += `<div class="not_actions" data-row="9" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}"></div>`;
    row++;
    //FIN PERSONAL FRANCO

    //PERSONAL TOTAL
    column = 1;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="10" data-col="1" data-repeat="no" data-type="TEXT" data-origin="">
            <p class="no_margin p_border max_width_cell name_summary" data-text="PERSONAL TOTAL">PERSONAL TOTAL</p>
        </div>
    `;
    column++;
    filas += `
        <div class="cell configure" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}" data-row="10" data-col="2" data-repeat="no" data-type="TEXT" data-origin="">
            <p id="td_table_total_${cod}_personal_total" class="no_margin p_border max_width_cell value_summary" data-text="0">0</p>
        </div>
    `;
    column++;
    filas += `<div class="not_actions" data-row="10" data-row_start="${row}" data-row_end="${row + 1}" data-column_start="${column}" data-column_end="${column + 1}"></div>`;
    row++;
    //FIN PERSONAL TOTAL

    return `
            <div class="table_container">
                <div class="table" style="grid-template-columns: repeat(2, minmax(max-content, 1fr)) max-content;">
                    ${columnsHeaders}
                    <div class="header_opciones"></div>

                    ${filas}
                </div>
            </div>
            `;
}
//fin funciones tabla total

//funciones tabla FRANCO
function getContenedorTabla_franco(cod) {

    return `
            <div class="table_container">
                <div class="table_franco" id="table_franco_${cod}" style="grid-template-columns: repeat(3, minmax(max-content, 1fr)) max-content;">
                </div>
            </div>
            `;
}
function addRowAgentFrancoToTable(cod, agents) {
    const tableFrancos = document.getElementById(`table_franco_${cod}`);
    tableFrancos.innerHTML = "";
    let count = 1;
    let filas = "";
    agents.forEach(a => {
        filas += `
            <div class="cell" data-row="${count}">
                <p class="no_margin count_row">${count}</p>
            </div>
            <div class="cell id_agent" data-row="${count}" data-at_id="${a.at_id}">
                <p class="no_margin at_id">${a.at_codigo}</p>
            </div>
            <div class="cell" data-row="${count}">
                <p class="no_margin agent">${a.emp_apellido} ${a.emp_nombre}</p>
            </div>
            <div class="configure_table_div configure" data-row="${count}">
                <span class="configure_options configure_table">
                    <i class="fa fa-trash delete_row_table" data-row="${count}" aria-hidden="true"></i>
                </span>
            </div>
        `;
        count++;
    });
    tableFrancos.innerHTML = filas;

    const readAllDeletesRow = tableFrancos.querySelectorAll('.delete_row_table');
    readAllDeletesRow.forEach(r => {
        r.addEventListener('click', () => {
            let table_delete = document.getElementById(tableFrancos.id);
            deleteRowTableFranco(table_delete, r);
        });
    });
}
function deleteRowTableFranco(table, element) {
    let cells = table.querySelectorAll(`.cell[data-row="${element.dataset.row}"], .configure_table_div[data-row="${element.dataset.row}"]`);

    cells.forEach(c => {
        c.remove();
        calculateSummaryAgents();
    });

    table = document.getElementById(table.id);
    let cellsRow = table.querySelectorAll('p.count_row');
    let index = 1;
    cellsRow.forEach(c => {
        c.innerText = index++;
    });
}
//fin funciones tabla total

function setBusqAgente(input, name) {
    let ajaxPrev = null;
    custom_search_input(input.id, {
        formatResult: function (item) {
            return {
                value: item.at_id,
                text: eval(convertToInterpolation(input.dataset.campo, "agente", "item")),
                html: eval(convertToInterpolation(input.dataset.busq, "agente", "item"))
            };
        },
        datasets: function (item) {
            return eval('(' + convertDataToJSON(input.dataset.data, "item") + ')');
        },
        search: function (text, callback) {
            if (ajaxPrev != null)
                ajaxPrev.abort();

            let ajax = $.ajax(
                `/orden_cuerpo/get_search_agente/10/${text} `
            ).done(function (res) {
                let agents_utilizados = [];
                let agents_supervisores = asignCountElement(['list_supervisor', 'distribucion_supervisor']);
                switch (name) {
                    case "list_supervisor":
                        agents_utilizados = asignCountElement(['list_supervisor']);
                        res.data = res.data.filter(d => !agents_utilizados.includes(d.at_id.toString()));
                        break;
                    case "unidades_patrullero_manana":
                    case "puntos_fijos_manana_este":
                    case "puntos_fijos_manana_oeste":
                    case "motorizados_manana_este":
                    case "motorizados_manana_oeste":
                    case "ciclista_manana_este_oeste":
                    case "unidades_patrullero_tarde":
                    case "puntos_fijos_tarde_este":
                    case "puntos_fijos_tarde_oeste":
                    case "motorizados_tarde_este":
                    case "motorizados_tarde_oeste":
                    case "ciclista_tarde_este_oeste":
                    case "personal_vacaciones":
                    case "personal_descanso_medico":
                    case "tabla_grupo_operativo":
                    case "tabla_personal_nocturna":
                    case "personal_administrativo":
                    case "personal_terminal_terrestre":
                    case "horario_redactor":
                        agents_utilizados = asignCountElement(['patrulleros_primer_turno',
                            'puntos_fijos_primer_turno',
                            'motorizados_primer_turno',
                            'ciclistas_primer_turno',
                            'patrulleros_segundo_turno',
                            'puntos_fijos_segundo_turno',
                            'motorizados_segundo_turno',
                            'ciclistas_segundo_turno',
                            'personal_administrativo',
                            'personal_descanso_medico',
                            'personal_vacaciones',
                            'personal_operativo',
                            'personal_nocturna',
                            'personal_terminal_terrestre',
                            'horario_redactor']);
                        agents_utilizados = agents_utilizados.filter(d => !agents_supervisores.includes(d));
                        res.data = res.data.filter(d => !agents_utilizados.includes(d.at_id.toString()));
                        break;
                    default:
                        break;
                }
                callback(res.respuesta ? res.data : []);
            });

            ajaxPrev = ajax;
        }
    });

    document.getElementById(input.id).addEventListener('keydown', e => {
        if (e.key == 'Backspace' && e.target.value == "") {
            e.target.dataset.at_id = "";
            e.target.dataset.text = "";
            e.target.dataset.value = "";
            e.target.dataset.at_codigo = "";

            let origin = e.target.dataset.origin;
            let selector = e.target.parentElement.dataset.row_copy ? `[data-row_copy="${e.target.parentElement.dataset.row_copy}"]` : `[data-row="${e.target.parentElement.dataset.row}"]:not([data-row_copy])`;
            let cellsDataset = e.target.parentElement.parentElement.querySelectorAll(`.cell[data-type="dataset"]${selector} > p[data-data*="${origin}."]`);
            cellsDataset.forEach(c => {
                c.innerHTML = "";
            });
        }
    });
}

function convertToInterpolation(str, campoquitar, camporeemplazo) {
    const regex = new RegExp(`&${campoquitar}\\.`, 'g');
    let result = '`' + str
        .replace(regex, `${camporeemplazo}.`)
        .replace(/\s+/g, ' ') + '`';

    return result;
}

function convertDataToJSON(dataStr, campo) {
    const keys = dataStr.split(',');
    const result = {};

    keys.forEach(key => {
        result[key.trim()] = `${campo}.${key.trim()}`;
    });

    let jsonString = JSON.stringify(result, null, 4);

    // Remover las comillas alrededor de los valores
    jsonString = jsonString.replace(/\"item\.(\w+)\"/g, 'item.$1');

    return jsonString;
}

function changeConstantValues(text) {
    let fechaDia = fechaDiaFuncion();
    text = text.replace(/&count/g, countDocumentoOC);
    text = text.replace(/&FechaDia/g, fechaDia);
    return text;
}

function fechaDiaFuncion() {
    const days = ["DOMINGO", "LUNES", "MARTES", "MIÉRCOLES", "JUEVES", "VIERNES", "SÁBADO"];
    const months = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
    const today = new Date();
    const dayName = days[today.getDay()];
    const day = today.getDate();
    const month = months[today.getMonth()];
    const year = today.getFullYear();
    return `${dayName} ${day} DE ${month} DEL ${year}`;
}

function readMaxTypeContainer(type) {
    let maxCount = 0;

    // Buscar todos los contenedores que tienen la propiedad 'type' y encontrar el valor máximo
    const containersWithType = listControlContainer.filter(l => l.hasOwnProperty(type));

    if (containersWithType.length > 0) {
        // Encontrar el valor máximo de la propiedad 'type'
        maxCount = Math.max(...containersWithType.map(l => l[type])) + 1;
    }

    // Crear o actualizar un contenedor con la propiedad 'type' y el valor maxCount
    const containerIndex = listControlContainer.findIndex(l => l.hasOwnProperty(type));
    if (containerIndex >= 0) {
        listControlContainer[containerIndex][type] = maxCount;
    } else {
        let newContainer = {};
        newContainer[type] = maxCount;
        listControlContainer.push(newContainer);
    }

    return maxCount;
}