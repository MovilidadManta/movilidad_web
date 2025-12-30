let btnGuardar = document.getElementById('save_plantilla');

$(document).ready(function () {
    readDraggagles();
    setInputValidations('txt_text-modal_configurar_campo', ['notEmpty'], []);
    setInputValidations('txt_search_busq-modal_configurar_campo', ['notEmpty'], []);
    setInputValidations('txt_search_campo-modal_configurar_campo', ['notEmpty'], []);
    setInputValidations('txt_name_col-modal_configurar_campo', ['notEmpty'], []);
    setInputValidations('txt_dataset-modal_configurar_campo', ['notEmpty'], []);
    loadPlantillaActive();
});

btnGuardar.addEventListener('click', () => {
    let plantillaContainer = document.getElementById('content_plantilla');
    let items = plantillaContainer.querySelectorAll(':scope > div[data-type]');
    let images = plantillaContainer.querySelectorAll(':scope > div[data-type="image"]');
    let token = $("#csrf-token").val();
    let cont = 1;

    if (items.length == 0) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Debe configurar una plantilla válida",
            position: "right",
            autohide: true,
            zindex: 99999
        });
        return;
    }

    const values = getItemsContainers(plantillaContainer);

    const formData = new FormData();

    images.forEach(i => {
        let input = i.querySelector(`input[id="input_img_${i.dataset.cod}"]`);

        if (input.files.length > 0) {
            const file = input.files[0];
            const newFileName = `input_img_${i.dataset.cod}.` + file.name.split('.').pop();
            const renamedFile = new File([file], newFileName, { type: file.type });
            formData.append(`file_imagen_${cont++}`, renamedFile);
        }
    });

    formData.append('cf_plantilla', JSON.stringify(values));
    $("#save_plantilla").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");

    $.ajax({
        url: '/conf_agentes_transito_plantilla/store',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: formData,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Configuración de plantilla Registrada!",
                    type: "success",
                    zindex: 99999
                });
                $("#save_plantilla").html("<i class='fa fa-save'></i> Guardar");
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido registrar la Configuración de plantilla!",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#save_plantilla").html("<i class='fa fa-save'></i> Guardar");
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

});

function getItemsContainers(container) {
    let items = container.querySelectorAll(':scope > div[data-type]');
    return [...items].map(i => {
        let value = {};
        switch (i.dataset.type) {
            case "title":
                let h1 = i.querySelector('h1');
                value = {
                    type: i.dataset.type,
                    cod: i.dataset.cod,
                    name: i.dataset.name_container,
                    text: h1.innerHTML.replace(/&amp;/g, "&"),
                    style: h1.getAttribute('style')
                }
                break;
            case "paragraph":
                let p = i.querySelector('p');
                value = {
                    type: i.dataset.type,
                    cod: i.dataset.cod,
                    name: i.dataset.name_container,
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
                    name: i.dataset.name_container,
                    repeat: containerElements.dataset.repeat,
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
                    name: i.dataset.name_container,
                    items: [...listContainer.querySelectorAll(':scope > div[data-cod]')].map(l => {
                        return {
                            repeat: l.dataset.repeat,
                            izq: {
                                type: l.querySelector('div.izq').dataset.type,
                                text: l.querySelector('div.izq').dataset.text ?? '',
                                text: l.querySelector('div.izq').dataset.text ?? '',
                                origin: l.querySelector('div.izq').dataset.origin ?? '',
                                busq: l.querySelector('div.izq').dataset.busq ?? '',
                                campo: l.querySelector('div.izq').dataset.campo ?? '',
                                data: l.querySelector('div.izq').dataset.data ?? '',
                            },
                            der: {
                                type: l.querySelector('div.der').dataset.type,
                                text: l.querySelector('div.der').dataset.text ?? '',
                                origin: l.querySelector('div.der').dataset.origin ?? '',
                                busq: l.querySelector('div.der').dataset.busq ?? '',
                                campo: l.querySelector('div.der').dataset.campo ?? '',
                                data: l.querySelector('div.der').dataset.data ?? '',
                            }
                        }
                    })
                }
                break;
            case "table":
                let optionsContainer = i.querySelector('.table_options_container');
                let bindsColumns = optionsContainer.querySelector('.bind_columns');
                let tableContainer = i.querySelector('.table_container');
                let table = tableContainer.querySelector('table');
                let thead = table.querySelector('thead');
                let columns = thead.querySelectorAll('th[data-col]:not(.col_actions)');
                let tbody = table.querySelector('tbody');
                let filas = tbody.querySelectorAll('tr[data-row]');
                value = {
                    type: i.dataset.type,
                    cod: i.dataset.cod,
                    name: i.dataset.name_container,
                    uniqueColumHeader: bindsColumns.classList.contains('active') ? true : false,
                    repeat: table.dataset.repeat,
                    styleThead: thead.getAttribute('style'),
                    headerColumns: [...columns].map(c => {
                        return {
                            col: c.dataset.col,
                            styleTh: c.getAttribute('style'),
                            styleP: c.querySelector('p').getAttribute('style'),
                            text: c.querySelector('p').innerHTML.replace(/&amp;/g, "&")
                        }
                    }),
                    filas: [...filas].map(f => {
                        let tds = f.querySelectorAll('td[data-row]');
                        return {
                            row: f.dataset.row,
                            columns: [...tds].map(c => {
                                let datasetJson = {};
                                Object.keys(c.dataset).map(key => {
                                    datasetJson[key] = c.dataset[key];
                                })
                                return {
                                    col: c.dataset.col,
                                    dataset: datasetJson,
                                    styleP: c.querySelector('p').getAttribute('style'),
                                    p: c.querySelector('p').innerHTML.replace(/&amp;/g, "&")
                                }
                            })
                        }
                    })
                }
                break;
            case "table_total":
                value = {
                    type: i.dataset.type,
                    cod: i.dataset.cod,
                    name: i.dataset.name_container,
                }
                break;
            case "table_franco":
                value = {
                    type: i.dataset.type,
                    cod: i.dataset.cod,
                    name: i.dataset.name_container,
                }
                break;
            case "image":
                let inputImage = i.querySelector(`input[id="input_img_${i.dataset.cod}"]`);
                let imageSelected = inputImage.files.length > 0 ? true : false;
                value = {
                    type: i.dataset.type,
                    cod: i.dataset.cod,
                    name: i.dataset.name_container,
                    name: imageSelected ? `input_img_${i.dataset.cod}.${inputImage.files[0].name.split('.').pop()}` : 'vacio'
                }
                break;
            default:
                break;
        }
        return value;
    });
}

function loadPlantillaActive() {
    $.ajax({
        url: `/conf_agentes_transito_plantilla/getPlantilla`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.length > 0) {
                let plantillaContainer = document.getElementById('content_plantilla');
                readPlantillaCargada(JSON.parse(response[0].cf_plantilla), plantillaContainer);
                readDraggagles();
            }
        }
    });
}

function readPlantillaCargada(elements, container) {
    elements.forEach(e => {
        switch (e.type) {
            case "title":
                const newElementTitle = createContainerPlantilla(e.type, e.name, getPlantillaTitulo(e.text, e.style));
                container.appendChild(newElementTitle);
                configureContainersFromPlantilla(newElementTitle.dataset.type, newElementTitle.dataset.cod);
                break;
            case "paragraph":
                const newElementParagraph = createContainerPlantilla(e.type, e.name, getPlantillaParrafo(e.text, e.style));
                container.appendChild(newElementParagraph);
                configureContainersFromPlantilla(newElementParagraph.dataset.type, newElementParagraph.dataset.cod);
                break;
            case "container":
                const newElementContainer = createContainerPlantilla(e.type, e.name, getContenedorPlantilla(e.textHeader, e.styleParrafo, e.styleHeader));
                container.appendChild(newElementContainer);
                configureContainersFromPlantilla(newElementContainer.dataset.type, newElementContainer.dataset.cod);

                let containerDropzone = newElementContainer.querySelector('.dropzone');
                let repeatButtonContainer = newElementContainer.querySelector('.repeat_container');
                let headerContainer = newElementContainer.querySelector('.container_elements_header');
                let textColor = headerContainer.querySelector('span[data-action="text_color"] > select');
                let backgroundColor = headerContainer.querySelector('span[data-action="background_color"] > select');
                if (e.repeat == "si") {
                    repeatButtonContainer.dispatchEvent(new Event('click'));
                }
                if (headerContainer.getAttribute('style')) {
                    if (headerContainer.style.color == "white") {
                        textColor.value = "white";
                    }
                    if (headerContainer.style.color == "black") {
                        textColor.value = "black";
                    }
                    if (headerContainer.style.backgroundColor == "var(--header-blue)"); {
                        backgroundColor.value = "blue";
                    }
                    if (headerContainer.style.backgroundColor == "var(--header-yellow)"); {
                        backgroundColor.value = "yellow";
                    }
                    if (headerContainer.style.backgroundColor == "transparent"); {
                        backgroundColor.value = "transparent";
                    }
                }
                readPlantillaCargada(e.items, containerDropzone);
                break;

            case "list":
                const newElementList = createContainerPlantilla(e.type, e.name);
                container.appendChild(newElementList);
                configureContainersFromPlantilla(newElementList.dataset.type, newElementList.dataset.cod);

                let listContainer = newElementList.querySelector('.list_container');
                let configureRowList = listContainer.querySelector('.row_list.configure');
                let optionIzqRowList = configureRowList.querySelector(`div[id="list_conf_campo_izq_${newElementList.dataset.cod}"]`);
                let optionDerRowList = configureRowList.querySelector(`div[id="list_conf_campo_der_${newElementList.dataset.cod}"]`);
                let okListRowList = configureRowList.querySelector(`i[id="list_conf_camp_ok_${newElementList.dataset.cod}"]`);
                e.items.forEach((i, k) => {
                    asignValueDataTextRowList(i.izq, optionIzqRowList);
                    asignValueDataTextRowList(i.der, optionDerRowList);
                    okListRowList.dispatchEvent(new Event('click'));
                    if (i.repeat == "si") {
                        let repeatFilaCreated = listContainer.querySelector(`:scope > div[data-cod="${k + 1}"] i.repeat`);
                        repeatFilaCreated.dispatchEvent(new Event('click'));
                    }
                });
                break;

            case "table":
                let cont = readMaxTypeContainer(e.type)
                const newElementTable = createContainerPlantilla(e.type, e.name, getContenedorTabla(cont, e.headerColumns[0].text));
                container.appendChild(newElementTable);
                configureContainersFromPlantilla(newElementTable.dataset.type, newElementTable.dataset.cod);

                let tableOptionsContainer = newElementTable.querySelector('.table_options_container');
                let tableContainer = newElementTable.querySelector('.table_container');
                let repeatContainer = newElementTable.querySelector('.repeat_container');
                let thead = tableContainer.querySelector('thead');
                let tbody = tableContainer.querySelector('tbody');
                let buttonbindColumns = tableOptionsContainer.querySelector('.bind_columns');
                let buttonaddColumn = tableOptionsContainer.querySelector('.add_column');
                let selectBackgroundColor = tableOptionsContainer.querySelector('select[name="background_header"]');
                let selectColorHeader = tableOptionsContainer.querySelector('select[name="color_header"]');
                let numColumns = 1;

                thead.style = e.styleThead;
                asignStylesTableHeader(thead, selectBackgroundColor, selectColorHeader)
                if (e.uniqueColumHeader)
                    buttonbindColumns.dispatchEvent(new Event('click'));
                if (e.repeat == "si")
                    repeatContainer.dispatchEvent(new Event('click'));

                if (e.uniqueColumHeader) {
                    if (e.filas.length > 0) {
                        numColumns = e.filas[0].columns.length;
                    }
                } else {
                    numColumns = e.headerColumns.length;
                }

                if (numColumns > 1) {
                    for ($i = 2; $i <= numColumns; $i++) {
                        buttonaddColumn.dispatchEvent(new Event('click'));
                    }
                }

                e.headerColumns.forEach((h, i) => {
                    asginValueColumnHeader(tableContainer, i, h.styleTh, h.styleP, h.text)
                });

                e.filas.forEach((f, k) => {
                    let configureRowTr = tbody.querySelector('tr.configure_row');
                    let buttonAddRow = configureRowTr.querySelector('td.row_actions > i[id^="conf_check_table_"]');
                    f.columns.forEach((c, i) => {
                        addColumnTableRow(configureRowTr, i, c.col, c.dataset, c.p);

                    });
                    buttonAddRow.dispatchEvent(new Event('click'));
                    let trs = tbody.querySelectorAll(':scope > tr[data-row]');
                    let lastTr = trs[trs.length - 1];

                    f.columns.forEach((c, i) => {
                        applyStyleColumnTableRow(lastTr, i, c.styleP, c.dataset.repeat);
                    });
                });

                break;

            case "table_total":
                const newElementTable_total = createContainerPlantilla(e.type, e.name);
                container.appendChild(newElementTable_total);
                configureContainersFromPlantilla(newElementTable_total.dataset.type, newElementTable_total.dataset.cod);
                break;

            case "table_franco":
                const newElementTable_franco = createContainerPlantilla(e.type, e.name);
                container.appendChild(newElementTable_franco);
                configureContainersFromPlantilla(newElementTable_franco.dataset.type, newElementTable_franco.dataset.cod);
                break;

            case "image":
                const newElementImage = createContainerPlantilla(e.type, e.name);
                container.appendChild(newElementImage);
                configureContainersFromPlantilla(newElementImage.dataset.type, newElementImage.dataset.cod);
                let img_mod = new Image();
                let inputImage = newElementImage.querySelector('input[type="file"]');
                let carpeta = "/imagenes_orden_cuerpo";
                let rutaFile = `${carpeta}/${e.name}`;

                if (e.name != "") {
                    img_mod.src = rutaFile;
                    img_mod.onload = function () {
                        // Crear un objeto File con la imagen cargada
                        fetch(rutaFile)
                            .then(res => res.blob())
                            .then(blob => {
                                let file = new File([blob], e.name);

                                let fileList = new DataTransfer();
                                fileList.items.add(file);

                                inputImage.files = fileList.files;
                                inputImage.dispatchEvent(new Event('change'));
                            });
                    };
                }

                break;
            default:
                break;
        }
    });
}

function applyStyleColumnTableRow(lastTr, index, styleP, repeat) {
    let Td = lastTr.querySelector(`td[data-col="${index + 1}"]`);
    let buttonBold = Td.querySelector('i[data-action="bold_text"]');
    let buttonRepeat = Td.querySelector('i[data-action="repeat_cell"]');
    let p = Td.querySelector('p');
    p.style = styleP;
    if (repeat == "si") {
        buttonRepeat.dispatchEvent(new Event('click'));
    }
    if (p.style.fontWeight == "bold") {
        buttonBold.dispatchEvent(new Event('click'));
    }
}

function addColumnTableRow(tr, index, col, datasets, htmlText) {
    let tds = tr.querySelectorAll('td[data-col]');
    let td = tds[index];
    let content = td.querySelector('div.replace_content');

    td.dataset.type = datasets.type;
    td.classList.remove('empty');

    if (datasets.type == "clear") {
        content.innerHTML = `<p class="no_margin value">${htmlText}</p>`;
    }
    if (datasets.type == "text") {
        td.dataset.text = datasets.text;
        content.innerHTML = `<p class="no_margin value">${htmlText}</p>`;
    }
    if (datasets.type == "search") {
        td.dataset.origin = datasets.origin;
        td.dataset.busq = datasets.busq;
        td.dataset.campo = datasets.campo;
        td.dataset.data = datasets.data;
        td.dataset.nameCol = datasets.namecol;
        content.innerHTML = `<span class="badge bg-secondary value">${htmlText}</span>`;
    }
    if (datasets.type == "dataset") {
        td.dataset.data = datasets.data;
        content.innerHTML = `<p class="no_margin value">${htmlText}</p>`;
    }
}

function asginValueColumnHeader(tableContainer, i, styleTh, styleP, text) {
    let thead = tableContainer.querySelector('thead');
    let tr = thead.querySelector('tr');
    let th = tr.querySelector(`th[data-col="${i + 1}"]`);
    let p = th.querySelector('p');

    th.style = styleTh;
    p.style = styleP;
    p.innerHTML = text;
}

function asignStylesTableHeader(thead, backgroundColor, selectColorHeader) {
    if (thead.style.backgroundColor == 'var(--header-blue)') {
        backgroundColor.value = "blue";
    }
    if (thead.style.backgroundColor == "var(--header-green)") {
        backgroundColor.value = "green";
    }
    if (thead.style.backgroundColor == "transparent") {
        backgroundColor.value = "transparent";
    }

    if (thead.style.color == "white") {
        selectColorHeader.value = "white";
    }
    if (thead.style.color == "rgb(34, 34, 34)") {
        selectColorHeader.value = "black";
    }
}

function asignValueDataTextRowList(item, element) {
    if (item.type == "text") {
        element.dataset.type = item.type;
        element.dataset.text = item.text;
    }
    if (item.type == "search") {
        element.dataset.type = item.type;
        element.dataset.origin = item.origin;
        element.dataset.busq = item.busq;
        element.dataset.campo = item.campo;
        element.dataset.data = item.data;
    }
}