let modalConfigurarCampo = document.getElementById('modal_configurar_campo');
let nameModalAsignNameElement = 'modal_asign_name_element';
let elementAsigNameModifer;

let btnAceptModalAsignName = document.getElementById(`btn_guardar_nombre-${nameModalAsignNameElement}`);

btnAceptModalAsignName.addEventListener('click', () => {
    let text = document.getElementById(`txt_name-${nameModalAsignNameElement}`);
    elementAsigNameModifer.dataset.name_container = text.value;
    text.value = "";
    $(`#${nameModalAsignNameElement}`).modal('hide');
});

function createContainerPlantilla(plantilla, name_container = '', functionPlantilla = undefined) {
    const newElement = document.createElement('div');
    newElement.classList.add('box-content');
    newElement.classList.add('draggable');
    newElement.dataset.type = plantilla;
    let cont = readMaxTypeContainer(plantilla)
    newElement.dataset.cod = cont;
    newElement.dataset.name_container = name_container;

    switch (plantilla) {
        case 'title':
            newElement.innerHTML = functionPlantilla ?? getPlantillaTitulo("Título", "");
            let h1 = newElement.querySelector('h1');
            h1.contentEditable = true;
            break;
        case 'paragraph':
            newElement.innerHTML = functionPlantilla ?? getPlantillaParrafo("Título", "");
            let p = newElement.querySelector('p');
            p.contentEditable = true;
            break;
        case 'list':
            newElement.innerHTML = functionPlantilla ?? getPlantillaLista(cont);
            break;
        case 'container':
            newElement.innerHTML = functionPlantilla ?? getContenedorPlantilla("Título", "", "");
            let text = newElement.querySelector('.container_elements_header_text');
            text.contentEditable = true;
            break;
        case 'table':
            newElement.innerHTML = functionPlantilla ?? getContenedorTabla(cont, "Columna");
            break;
        case 'table_total':
            newElement.innerHTML = functionPlantilla ?? getContenedorTabla_Totales(cont);
            break;
        case 'table_franco':
            newElement.innerHTML = functionPlantilla ?? getContenedorTabla_Franco(cont);
            break;
        case 'image':
            newElement.innerHTML = functionPlantilla ?? getPlantillaImage(cont);
            break;
        default:
            console.log('no implementado')
    }

    return newElement;
}

//Funciones Titulo
function getPlantillaTitulo(titulo, style) {
    return `
            <h1 class="text_align" style="${style}">${titulo}</h1>
            <span class="box-options-icon box_move box_move--left drag-handle">
                <i class="fa fa-arrows" aria-hidden="true"></i>
            </span>
            <span class="box-options-icon box_move box_move--right">
                <i class="fa fa-pencil-square asign_header" aria-hidden="true"></i>
                <i class="fa fa-cog option_settings" aria-hidden="true"></i>
                <i class="fa fa-trash delete_container" aria-hidden="true"></i>
            </span>
            <div class="box-options" style="display: none;">
                <span class="box-options-icon" data-action="move_text_left">
                    <i class="fa fa-align-left"></i>
                </span>
                <span class="box-options-icon" data-action="move_text_center">
                    <i class="fa fa-align-center"></i>
                </span>
                <span class="box-options-icon" data-action="move_text_right">
                    <i class="fa fa-align-right"></i>
                </span>
            </div>
    `;
}
//------------------------------------------------------------

//Funciones Parrafo
function getPlantillaParrafo(titulo, style) {
    return `
            <p class="paragraph text_align" style="${style}">${titulo}</p>
            <span class="box-options-icon box_move box_move--left drag-handle">
                <i class="fa fa-arrows" aria-hidden="true"></i>
            </span>
            <span class="box-options-icon box_move box_move--right">
                <i class="fa fa-pencil-square asign_header" aria-hidden="true"></i>
                <i class="fa fa-cog option_settings" aria-hidden="true"></i>
                <i class="fa fa-trash delete_container" aria-hidden="true"></i>
            </span>
            <div class="box-options" style="display: none;">
                <span class="box-options-icon" data-action="move_text_left">
                    <i class="fa fa-align-left"></i>
                </span>
                <span class="box-options-icon" data-action="move_text_center">
                    <i class="fa fa-align-center"></i>
                </span>
                <span class="box-options-icon" data-action="move_text_right">
                    <i class="fa fa-align-right"></i>
                </span>
            </div>
    `;
}
//------------------------------------------------------------

//Funciones generales
function resolveButtonContainersActions(container, principal) {
    let icons = container.querySelectorAll('.box-options-icon');
    let backgroundColor = container.querySelector('.box-options-background_color');
    let textColor = container.querySelector('.box-options-text_color');

    icons.forEach(i => {
        i.addEventListener('click', () => {
            switch (i.dataset.action) {
                case 'move_text_left':
                    principal.querySelectorAll('.text_align')
                        .forEach(t => {
                            t.style.textAlign = "start";
                        });
                    break;
                case 'move_text_center':
                    principal.querySelectorAll('.text_align')
                        .forEach(t => {
                            t.style.textAlign = "center";
                        });
                    break;
                case 'move_text_right':
                    principal.querySelectorAll('.text_align')
                        .forEach(t => {
                            t.style.textAlign = "end";
                        });
                    break;
                case 'bold_text':
                    principal.querySelectorAll('.bold_text')
                        .forEach(t => {
                            if (t.style.fontWeight == 'normal' || !t.style.fontWeight)
                                t.style.fontWeight = "bold";
                            else
                                t.style.fontWeight = "normal";
                        });
                    break;
                default:
                    console.log('no implementado')
            }
        });
    });

    if (backgroundColor) {
        let select = backgroundColor.querySelector('select[name="background_color"]');
        select.addEventListener('change', e => {
            if (e.target.value == "transparent") {
                principal.querySelectorAll('.background_color')
                    .forEach(b => {
                        b.style.backgroundColor = "transparent";
                    });
            }
            if (e.target.value == "yellow") {
                principal.querySelectorAll('.background_color')
                    .forEach(b => {
                        b.style.backgroundColor = "var(--header-yellow)";
                    });
            }
            if (e.target.value == "blue") {
                principal.querySelectorAll('.background_color')
                    .forEach(b => {
                        b.style.backgroundColor = "var(--header-blue)";
                    });
            }
        });
    }

    if (textColor) {
        let select = textColor.querySelector('select[name="text_color"]');
        select.addEventListener('change', e => {
            if (e.target.value == "black") {
                principal.querySelectorAll('.text_color')
                    .forEach(t => {
                        t.style.color = "#031b4e";
                    });
            }
            if (e.target.value == "white") {
                principal.querySelectorAll('.text_color')
                    .forEach(t => {
                        t.style.color = "white";
                    });
            }
        });
    }
}
function readMaxTypeContainer(type) {
    let contentPlantilla = document.getElementById('content_plantilla');
    let containers = contentPlantilla.querySelectorAll(`div[data-type="${type}"]`);

    let maxCount = 0;

    containers.forEach(c => {
        maxCount = Number(c.dataset.cod) > maxCount ? Number(c.dataset.cod) : maxCount;
    });

    return maxCount + 1;
}
function configureContainersFromPlantilla(plantilla, cod) {
    let contentPlantilla = document.getElementById('content_plantilla');
    let div = contentPlantilla.querySelector(`div[data-type="${plantilla}"][data-cod="${cod}"]`);

    if (plantilla == "title") {
        let optionButton = div.querySelector('.option_settings');
        let editHeader = div.querySelector('.asign_header');
        let boxOptions = div.querySelector('.box-options');
        let deleteButton = div.querySelector('.delete_container');
        configureOptions(optionButton, boxOptions, div);
        configureDeleteContainer(deleteButton, div);
        configureEditHeader(editHeader, div);
    }

    if (plantilla == "paragraph") {
        let optionButton = div.querySelector('.option_settings');
        let editHeader = div.querySelector('.asign_header');
        let boxOptions = div.querySelector('.box-options');
        let deleteButton = div.querySelector('.delete_container');
        configureOptions(optionButton, boxOptions, div);
        configureDeleteContainer(deleteButton, div);
        configureEditHeader(editHeader, div);
    }

    if (plantilla == "container") {
        let optionButton = div.querySelector('.option_settings');
        let editHeader = div.querySelector('.asign_header');
        let boxOptions = div.querySelector('.box-options');
        let deleteButton = div.querySelector('.delete_container');
        let repeatButton = div.querySelector('.repeat_container');
        let containerElements = div.querySelector('.container_elements');
        configureOptions(optionButton, boxOptions, div);
        configureDeleteContainer(deleteButton, div);
        configureRepatContainer(repeatButton, containerElements);
        configureEditHeader(editHeader, div);
    }

    if (plantilla == "list") {
        let editHeader = div.querySelector('.asign_header');
        let izqCamp = div.querySelector(`[id^="list_conf_campo_izq_${cod}"]`);
        let derCamp = div.querySelector(`[id^="list_conf_campo_der_${cod}"]`);
        let ok = div.querySelector(`[id^="list_conf_camp_ok_${cod}"]`);
        let trash = div.querySelector(`[id^="list_conf_camp_trash_${cod}"]`);
        let deleteButton = div.querySelector('.delete_container');

        configureDeleteContainer(deleteButton, div);
        configureEditHeader(editHeader, div);

        trash.addEventListener('click', () => {
            clearListPlantilla(izqCamp, derCamp);
        });

        ok.addEventListener('click', () => {
            addListPlantilla(izqCamp, derCamp, div);
        });

        izqCamp.addEventListener('click', () => {
            if (izqCamp.classList.contains('empty'))
                showModalCampos(modalConfigurarCampo, izqCamp.id);
        });

        derCamp.addEventListener('click', () => {
            if (derCamp.classList.contains('empty'))
                showModalCampos(modalConfigurarCampo, derCamp.id);
        });
    }

    if (plantilla == "table") {
        let deleteButton = div.querySelector('.delete_container');
        let editHeader = div.querySelector('.asign_header');
        let options = div.querySelector('.table_options_container');
        let columnsHeaders = div.querySelectorAll('.table_container > table > thead th[data-col]:not(.col_actions)');
        let columnsValues = div.querySelectorAll('.table_container > table > tbody td[data-col].configure_col');
        let columnValuesActions = div.querySelector('.table_container > table > tbody td.row_actions');
        let containerElements = div.querySelector('table');
        let repeatButton = div.querySelector('.repeat_container');
        configureDeleteContainer(deleteButton, div);
        configureOptionsTable(options, div);
        configureActionsTable(columnValuesActions, div);
        configureRepatContainer(repeatButton, containerElements);
        configureEditHeader(editHeader, div);
        columnsHeaders.forEach(c => {
            configureActionsColumnTable(c);
        });
        columnsValues.forEach(c => {
            configureActionsRowTable(c);
        });
    }

    if (plantilla == "table_total") {
        let deleteButton = div.querySelector('.delete_container');
        let editHeader = div.querySelector('.asign_header');
        configureDeleteContainer(deleteButton, div);
        configureEditHeader(editHeader, div);
    }

    if (plantilla == "table_franco") {
        let deleteButton = div.querySelector('.delete_container');
        let editHeader = div.querySelector('.asign_header');
        configureDeleteContainer(deleteButton, div);
        configureEditHeader(editHeader, div);
    }

    if (plantilla == "image") {
        let deleteButton = div.querySelector('.delete_container');
        let containerImage = div.querySelector('.image_content');
        let inputImg = div.querySelector(`input[id="input_img_${div.dataset.cod}"]`);
        let editHeader = div.querySelector('.asign_header');
        configureDeleteContainer(deleteButton, div);
        addEventImage(containerImage, inputImg, div.dataset.cod);
        configureEditHeader(editHeader, div);
    }
}

function configureEditHeader(element, container) {
    element.addEventListener('click', () => {
        let text = document.getElementById(`txt_name-${nameModalAsignNameElement}`);
        elementAsigNameModifer = container;
        console.log(container);
        text.value = container.dataset.name_container;
        $(`#${nameModalAsignNameElement}`).modal('show');
    });
}

function configureOptions(element, boxOptions, container) {
    element.addEventListener('click', () => {
        enableDisabledOptions(boxOptions);
        resolveButtonContainersActions(boxOptions, container);
    });
}

function configureDeleteContainer(deleteButton, container) {
    deleteButton.addEventListener('click', () => {
        container.remove();
    });
}

function configureRepatContainer(repeatButton, container) {
    repeatButton.addEventListener('click', () => {
        if (repeatButton.style.color == "var(--repeat-color)") {
            container.dataset.repeat = "no";
            repeatButton.setAttribute("style", "");
        } else {
            container.dataset.repeat = "si";
            repeatButton.style.color = "var(--repeat-color)";
        }
    });
}

function enableDisabledOptions(option) {
    if (option.style.display == "none") {
        option.style.display = "block";
    } else {
        option.style.display = "none";
    }
}

function showModalCampos(modal, id) {
    initialState_modal_configurar_campo();
    setIdChooseModal_modal_configurar_campo(id);
    $(`#${modal.id}`).modal('show');
}
//------------------------------------------------------------

//Funciones Lista
function getPlantillaLista(cod) {
    return `
            <div class="list_container">
                <div class="row_list configure">
                    <div class="row_list_col empty" id="list_conf_campo_izq_${cod}" data-type>
                        <div class="replace_content">
                            <i class="fa fa-plus"></i> Agregar
                        </div>
                    </div>
                    <div class="row_list_col empty" id="list_conf_campo_der_${cod}" data-type>
                        <div class="replace_content">
                            <i class="fa fa-plus"></i> Agregar
                        </div>
                    </div>
                    <span class="configure_options">
                        <i class="fa fa-check" id="list_conf_camp_ok_${cod}" aria-hidden="true"></i>
                        <i class="fa fa-trash" id="list_conf_camp_trash_${cod}" aria-hidden="true"></i>
                    </span>
                </div>
            </div>
            <span class="box-options-icon box_move box_move--left drag-handle">
                <i class="fa fa-arrows" aria-hidden="true"></i>
            </span>
            <span class="box-options-icon box_move box_move--right">
                <i class="fa fa-pencil-square asign_header" aria-hidden="true"></i>
                <i class="fa fa-trash delete_container" aria-hidden="true"></i>
            </span>
    `;
}
function addListPlantilla(izqCamp, derCamp, container) {
    let listContainer = container.querySelector('.list_container');
    if (izqCamp.dataset.type == "" || derCamp.dataset.type == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Debe configurar los campos primero",
            position: "right",
            autohide: true,
            zindex: 99999
        });
        return;
    }

    let cont = readMaxTypeList(listContainer);
    let configureElement = listContainer.querySelector('.row_list.configure');
    let element = newRowListPlantilla(izqCamp, derCamp, cont);

    listContainer.insertBefore(element, configureElement);
    clearListPlantilla(izqCamp, derCamp);
    //TODO
}

function newRowListPlantilla(izqCamp, derCamp, cont) {
    const newElement = document.createElement('div');
    newElement.dataset.cod = cont;
    newElement.dataset.repeat = 'no';
    newElement.classList.add('row_list');
    newElement.classList.add('added');

    let izq = resolveValuesCampoList(izqCamp, 'izq');
    let der = resolveValuesCampoList(derCamp, 'der');

    newElement.innerHTML = `
        ${izq}
        ${der}
        <span class="configure_options">
            <i class="fa fa-repeat repeat" aria-hidden="true" data-cod="${cont}"></i>
            <i class="fa fa-trash remove" aria-hidden="true" data-cod="${cont}"></i>
        </span>
    `;

    addEventsnewRowLisPlantilla(newElement);

    return newElement;
}

function resolveValuesCampoList(div, orientation) {
    let value = "";
    if (div.dataset.type == "text") {
        value = `
        <div class="row_list_col ${orientation}" data-type="${div.dataset.type}" data-text="${div.dataset.text}">
            <p class="no_margin">${div.dataset.text.toUpperCase()}</p>
        </div>
        `;
    }
    if (div.dataset.type == "search") {
        value = `
        <div class="row_list_col ${orientation}" data-type="${div.dataset.type}" data-origin="${div.dataset.origin}" data-busq="${div.dataset.busq}" data-campo="${div.dataset.campo}" data-data="${div.dataset.data}">
            <span class="badge bg-secondary">AGENTE</span>
        </div>
        `;
    }
    return value;
}

function readMaxTypeList(container) {
    let containers = container.querySelectorAll(`div[data-cod]`);

    let maxCount = 0;

    containers.forEach(c => {
        maxCount = Number(c.dataset.cod) > maxCount ? Number(c.dataset.cod) : maxCount;
    });

    return maxCount + 1;
}

function addEventsnewRowLisPlantilla(container) {
    let remove = container.querySelector('i.remove');
    let repeat = container.querySelector('i.repeat');

    remove.addEventListener('click', () => {
        container.remove();
    });

    repeat.addEventListener('click', () => {
        if (container.dataset.repeat == 'no') {
            container.dataset.repeat = 'si';
            repeat.classList.add('repeat_color');
        } else {
            container.dataset.repeat = 'no';
            repeat.classList.remove('repeat_color');
        }
    });
}

function clearListPlantilla(izqCamp, derCamp) {
    izqCamp.dataset.type = "";
    derCamp.dataset.type = "";

    let replaceContent = izqCamp.querySelector('.replace_content');
    replaceContent.innerHTML = `<i class="fa fa-plus"></i> Agregar`;

    replaceContent = derCamp.querySelector('.replace_content');
    replaceContent.innerHTML = `<i class="fa fa-plus"></i> Agregar`;

    izqCamp.classList.add('empty');
    derCamp.classList.add('empty');
}
//------------------------------------------------------------
//Funciones para contenedor
function getContenedorPlantilla(titulo, styleText, styleBackground) {
    return `
        <div class="container_elements dropzone" data-repeat="no">
            <div class="container_elements_header background_color text_color" style="${styleBackground}">
                <p class="no_margin container_elements_header_text text_align bold_text" style="${styleText}">${titulo}</p>
                <span class="box-options-icon box_move box_move--right">
                    <i class="fa fa-cog option_settings" aria-hidden="true"></i>
                </span>
                <div class="box-options" style="display: none;">
                    <span class="box-options-icon" data-action="bold_text">
                        <i class="fa fa-bold"></i>
                    </span>
                    <span class="box-options-text_color" data-action="text_color">
                        <span>Texto:</span>
                        <select name="text_color">
                            <option value="black">Negro</option>
                            <option value="white">Blanco</option>
                        </select>
                    </span>
                    <span class="box-options-background_color" data-action="background_color">
                        <span>Fondo:</span>
                        <select name="background_color">
                            <option value="transparent">Transparente</option>
                            <option value="yellow">Amarillo</option>
                            <option value="blue">Azul</option>
                        </select>
                    </span>
                    <span class="box-options-icon" data-action="move_text_left">
                        <i class="fa fa-align-left"></i>
                    </span>
                    <span class="box-options-icon" data-action="move_text_center">
                        <i class="fa fa-align-center"></i>
                    </span>
                    <span class="box-options-icon" data-action="move_text_right">
                        <i class="fa fa-align-right"></i>
                    </span>
                </div>
            </div>
        </div>
        <span class="box-options-icon box_move box_move--left drag-handle">
            <i class="fa fa-arrows" aria-hidden="true"></i>
        </span>
        <span class="box-options-icon box_move box_move--right">
            <i class="fa fa-pencil-square asign_header" aria-hidden="true"></i>
            <i class="fa fa-repeat repeat_container" aria-hidden="true"></i>
            <i class="fa fa-trash delete_container" aria-hidden="true"></i>
        </span>
    `;
}
//------------------------------------------------------------
//Funciones para tabla
function getContenedorTabla(cod, nameCol1, styleCol1 = "font-weight: normal;", styleHeader = "text-align: center; font-weight:normal;") {
    return `
        <div class="table_options_container">
            <span class="table_options_container_button badge bg-secondary add_column" data-table="${cod}">
                <i class="fa fa-plus" aria-hidden="true"></i> Agregar columna
            </span>
            <span class="table_options_container_button badge bg-secondary bind_columns" data-table="${cod}">
                <i class="fa fa-columns" aria-hidden="true"></i> Unica columna
            </span>
            <span class="table_options_container_option">
                Background Color Header:
                <select name="background_header">
                    <option value="transparent">Transparente</option>
                    <option value="green">Verde</option>
                    <option value="blue">Azul</option>
                </select>
            </span>
            <span class="table_options_container_option">
                Color Texto Header:
                <select name="color_header">
                    <option value="black">Negro</option>
                    <option value="white">Blanco</option>
                </select>
            </span>
        </div>
        <div class="table_container">
            <table data-table="${cod}" data-repeat="no">
                <thead>
                    <tr>
                        <th class="col_1" data-col="1" colspan="1" style="${styleHeader}">
                            <p class="no_margin text_align bold_text" contenteditable="true" style="${styleCol1}">${nameCol1}</p>
                            <span class="box-options-icon box_move box_move--right">
                                <i class="fa fa-cog option_settings" aria-hidden="true"></i>
                                <i class="fa fa-trash delete_row" aria-hidden="true"></i>
                            </span>
                            <div class="box-options" style="display: none;">
                                <span class="box-options-icon" data-action="bold_text">
                                    <i class="fa fa-bold"></i>
                                </span>
                                <span class="box-options-icon" data-action="move_text_left">
                                    <i class="fa fa-align-left"></i>
                                </span>
                                <span class="box-options-icon" data-action="move_text_center">
                                    <i class="fa fa-align-center"></i>
                                </span>
                                <span class="box-options-icon" data-action="move_text_right">
                                    <i class="fa fa-align-right"></i>
                                </span>
                            </div>
                        </th>
                        <th class="fixed100 col_actions" data-col="-">
                            <p class="no_margin">Acciones</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="configure_row">
                        <td id="td_configure_tabla_${cod}_col_1" class="col_1 configure_col empty" data-col="1"  style="text-align: center;">
                            <div class="replace_content">
                                <i class="fa fa-plus"></i> Agregar
                            </div>
                        </td>
                        <td class="row_actions">
                            <i class="fa fa-check" id="conf_check_table_${cod}" aria-hidden="true"></i>
                            <i class="fa fa-trash" id="conf_trash_table_${cod}" aria-hidden="true"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <span class="box-options-icon box_move box_move--left drag-handle">
            <i class="fa fa-arrows" aria-hidden="true"></i>
        </span>
        <span class="box-options-icon box_move box_move--right">
            <i class="fa fa-pencil-square asign_header" aria-hidden="true"></i>
            <i class="fa fa-repeat repeat_container" aria-hidden="true"></i>
            <i class="fa fa-trash delete_container" aria-hidden="true"></i>
        </span>
    `;
}
function configureOptionsTable(options, container) {
    let backgroundHeader = container.querySelector('select[name="background_header"]');
    let colorHeader = container.querySelector('select[name="color_header"]');
    let addColumn = container.querySelector('.add_column');
    let bindColumns = container.querySelector('.bind_columns');

    backgroundHeader.addEventListener('change', e => {
        let headerTableElement = container.querySelector('.table_container > table > thead');
        if (e.target.value == "transparent") {
            headerTableElement.style.backgroundColor = "transparent";
        }
        if (e.target.value == "green") {
            headerTableElement.style.backgroundColor = "var(--header-green)";
        }
        if (e.target.value == "blue") {
            headerTableElement.style.backgroundColor = "var(--header-blue)";
        }
    });

    colorHeader.addEventListener('change', e => {
        let headerTableElement = container.querySelector('.table_container > table > thead');
        if (e.target.value == "black") {
            headerTableElement.style.color = "#222";
        }
        if (e.target.value == "white") {
            headerTableElement.style.color = "white";
        }
    });

    bindColumns.addEventListener('click', () => {
        let col1 = container.querySelector('th[data-col="1"]');
        let tdConfigures = container.querySelectorAll('tr.configure_row > td.configure_col');
        if (bindColumns.classList.contains('active')) {
            let table = container.querySelector('table[data-table]');
            let colActions = table.querySelector('th.col_actions');
            bindColumns.classList.remove('active');
            col1.colSpan = 1;
            tdConfigures.forEach(t => {
                if (t.dataset.col != 1) {
                    let newTh = addColumnTable(t.dataset.col);
                    colActions.parentNode.insertBefore(newTh, colActions);
                }
            });

        } else {
            bindColumns.classList.add('active');
            col1.colSpan = tdConfigures.length;
            tdConfigures.forEach(t => {
                if (t.dataset.col != 1) {
                    let col = container.querySelector(`th[data-col="${t.dataset.col}"]`);
                    col.remove();
                }
            });
        }
    });

    addColumn.addEventListener('click', () => {
        let table = container.querySelector('table[data-table]');
        let colActions = table.querySelector('th.col_actions');
        let rowActions = table.querySelector('td.row_actions');
        let numCol = calMaxColTable(table);
        let numColTd = calMaxColRowTable(table);
        let col1 = table.querySelector('th[data-col="1"]');
        numCol = +numCol + 1;
        numColTd = +numColTd + 1;

        if (!bindColumns.classList.contains('active')) {
            let newTh = addColumnTable(numCol);
            colActions.parentNode.insertBefore(newTh, colActions);
        } else {
            col1.colSpan = +col1.colSpan + 1;
        }

        let newTd = document.createElement('td');
        newTd.id = `td_configure_tabla_${table.dataset.table}_col_${numColTd}`;
        newTd.classList.add(`configure_col`);
        newTd.classList.add(`empty`);
        newTd.classList.add(`col_${numColTd}`);
        newTd.dataset.col = numColTd;
        newTd.style.textAlign = "center";

        newTd.innerHTML = `
            <div class="replace_content">
                <i class="fa fa-plus"></i> Agregar
            </div>
        `;

        configureActionsRowTable(newTd);

        rowActions.parentNode.insertBefore(newTd, rowActions);
    });
}

function addColumnTable(numCol) {
    let newTh = document.createElement('th');
    newTh.classList.add(`col_${numCol}`);
    newTh.dataset.col = numCol;
    newTh.style.textAlign = "center";
    newTh.innerHTML = `
            <p class="no_margin text_align bold_text" contenteditable="true" style="font-weight: normal;">Columna</p>
            <span class="box-options-icon box_move box_move--right">
                <i class="fa fa-cog option_settings" aria-hidden="true"></i>
                <i class="fa fa-trash delete_row" aria-hidden="true"></i>
            </span>
            <div class="box-options" style="display: none;">
                <span class="box-options-icon" data-action="bold_text">
                    <i class="fa fa-bold"></i>
                </span>
                <span class="box-options-icon" data-action="move_text_left">
                    <i class="fa fa-align-left"></i>
                </span>
                <span class="box-options-icon" data-action="move_text_center">
                    <i class="fa fa-align-center"></i>
                </span>
                <span class="box-options-icon" data-action="move_text_right">
                    <i class="fa fa-align-right"></i>
                </span>
            </div>
        `;
    configureActionsColumnTable(newTh);
    return newTh;
}

function calMaxColTable(table) {
    let ths = table.querySelectorAll('th[class^="col_"]:not(.col_actions)');
    return ths[ths.length - 1].dataset.col;
}

function calMaxColRowTable(table) {
    let tds = table.querySelectorAll('td[data-col]:not(.row_actions)');
    return tds[tds.length - 1].dataset.col;
}

function configureActionsColumnTable(column) {
    let optionButton = column.querySelector('.option_settings');
    let boxOptions = column.querySelector('.box-options');
    let deleteButton = column.querySelector('.delete_row');
    //let boldButton = column.querySelector('.bold_text');

    configureDeleteColumnTable(deleteButton, column);
    //configureBoldColumnTable(boldButton, column);

    optionButton.addEventListener('click', () => {
        enableDisabledOptions(boxOptions);
        resolveButtonContainersActions(boxOptions, column);
    });
}

function configureActionsRowTable(column) {
    column.addEventListener('click', () => {
        if (column.classList.contains('empty'))
            showModalCampos(modalConfigurarCampo, column.id);
    });
}

function configureDeleteColumnTable(deleteButton, container) {
    if (container.dataset.col != "1") {
        deleteButton.addEventListener('click', () => {
            let table = container.parentNode.parentNode.parentNode;
            let td = table.querySelector(`td[id="td_configure_tabla_${table.dataset.table}_col_${container.dataset.col}"]`);
            td.remove();
            container.remove();
        });
    }
}

function configureBoldColumnTable(boldButton, container) {
    console.log(boldButton)
    boldButton.addEventListener('click', e => {
        if (e.target.classList.contains('active')) {
            let texts = container.querySelectorAll('.bold_text_change');
            e.target.classList.remove('active');
            texts.forEach(t => {
                t.style.fontWeight = "normal";
            });
        } else {
            e.target.classList.add('active');
            let texts = container.querySelectorAll('.bold_text_change');
            texts.forEach(t => {
                t.style.fontWeight = "bold";
            });
        }
    });
}

function configureActionsTable(column, container) {
    let table = container.querySelector('table');
    let padreAction = column.parentNode;
    let ok = column.querySelector('i[id^="conf_check_table_"]');
    let trash = column.querySelector('i[id^="conf_trash_table_"]');

    ok.addEventListener('click', () => {
        let tds = table.querySelectorAll(`td[id^="td_configure_tabla_${table.dataset.table}_col_"]`);
        let tdsEmpty = table.querySelectorAll(`td[id^="td_configure_tabla_${table.dataset.table}_col_"].empty`);
        let newRow = document.createElement('tr');
        let trCont = calMaxRowTable(table);
        trCont++;
        newRow.dataset.row = trCont;
        newRow.classList.add(`row_${trCont}`);

        let tdsContainer = "";

        if (tdsEmpty.length > 0) {
            notif({
                type: "warning",
                msg: "<b>Aviso: </b>Debe configurar los campos primero",
                position: "right",
                autohide: true,
                zindex: 99999
            });
            return;
        }



        tds.forEach(t => {
            let value = t.querySelector('.value');
            tdsContainer += `
                <td id="td_tabla_${table.dataset.table}_row_${trCont}_col_${t.dataset.col}" 
                class="row_${trCont}_col_${t.dataset.col}" 
                data-row="${trCont}" 
                data-col="${t.dataset.col}"
                data-type="${t.dataset.type}"
                data-text="${t.dataset.text ?? ''}"
                data-origin="${t.dataset.origin ?? ''}"
                data-busq="${t.dataset.busq ?? ''}"
                data-campo="${t.dataset.campo ?? ''}"
                data-data="${t.dataset.data ?? ''}"
                data-nameCol="${t.dataset.nameCol ?? ''}"
                data-weigth="normal"
                data-repeat="no"
                style="text-align: center;">
                    <p class="no_margin bold_text">${value.innerHTML}</p>
                    <span class="box-options-icon box_move box_move--right">
                        <i class="fa fa-bold" data-action="bold_text" aria-hidden="true"></i>
                        <i class="fa fa-repeat" data-action="repeat_cell" aria-hidden="true"></i>
                    </span>
                </td>
            `;
        });

        tdsContainer += `
            <td class="row_action">
                <i class="fa fa-trash" id="conf_trash_table_${table.dataset.table}_row_${trCont}" data-table="${table.dataset.table}" data-row="${trCont}" aria-hidden="true"></i>
            </td>
        `;

        newRow.innerHTML = tdsContainer;

        padreAction.parentNode.insertBefore(newRow, padreAction);
        deleteRowTable(table, `conf_trash_table_${table.dataset.table}_row_${trCont}`);
        clearTableConfigureRow(table, table.dataset.table);
        asignActionsNewRow(newRow);
    });

    trash.addEventListener('click', () => {
        clearTableConfigureRow(table, table.dataset.table);
    });
}

function asignActionsNewRow(row) {
    let negrillas = row.querySelectorAll('i[data-action="bold_text"]');
    let repeats = row.querySelectorAll('i[data-action="repeat_cell"]');

    negrillas.forEach(n => {
        n.addEventListener('click', () => {
            let parent = n.parentNode.parentNode;
            let changeTexts = parent.querySelectorAll('.bold_text');
            if (n.style.opacity != "") {
                n.setAttribute("style", "");
                parent.dataset.fontWeight = "normal";
                changeTexts.forEach(t => {
                    t.setAttribute("style", "");
                });
            } else {
                n.style.opacity = "1"
                n.style.color = "var(--hover-color)";
                parent.dataset.fontWeight = "bold";
                changeTexts.forEach(t => {
                    t.style.fontWeight = "bold";
                });
            }

        });
    });

    repeats.forEach(r => {
        r.addEventListener('click', () => {
            let parent = r.parentNode.parentNode;
            if (r.style.opacity != "") {
                r.setAttribute("style", "");
                parent.dataset.repeat = "no";
            } else {
                r.style.opacity = "1"
                r.style.color = "var(--repeat-color)";
                parent.dataset.repeat = "si";
            }
        });
    });
}

function clearTableConfigureRow(table, tableCont) {
    let tds = table.querySelectorAll(`td[id^="td_configure_tabla_${tableCont}_col_"]`);
    tds.forEach(t => {
        t.classList.add('empty');
        t.innerHTML = `
            <div class="replace_content">
                <i class="fa fa-plus"></i> Agregar
            </div>
        `;
    });
}

function deleteRowTable(table, id) {
    let row = document.getElementById(id);
    row.addEventListener('click', () => {
        let tr = table.querySelector(`tr[data-row="${row.dataset.row}"]`);
        tr.remove();
    });
}

function calMaxRowTable(table) {
    let tds = table.querySelectorAll('tr[class^="row_"]:not(.row_actions)');
    return tds.length == 0 ? 0 : tds[tds.length - 1].dataset.row;
}
//------------------------------------------------------------
//Funciones tabla total
function getContenedorTabla_Totales(cod) {
    return `
        <div class="table_container">
            <table data-table_total="${cod}">
                <thead>
                    <tr>
                        <th class="col_1" colSpan="2" style="text-align: center;">
                            <p class="no_margin text_align bold_text">TOTAL PERSONAL</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">
                            PERSONAL PRIMERO TURNO
                        </td>
                        <td id="td_table_total_${cod}_personal_primer_turno" style="text-align: center;">
                            0
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            PERSONAL SEGUNDO TURNO
                        </td>
                        <td id="td_table_total_${cod}_personal_segundo_turno" style="text-align: center;">
                            0
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            PERSONAL ADMINISTRATIVO
                        </td>
                        <td id="td_table_total_${cod}_personal_administrativo" style="text-align: center;">
                            0
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            PERSONAL DESCANDO MEDICO
                        </td>
                        <td id="td_table_total_${cod}_personal_descanso_medico" style="text-align: center;">
                            0
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            PERSONAL CON VACACIONES - PERMISOS
                        </td>
                        <td id="td_table_total_${cod}_personal_vacaciones_permisos" style="text-align: center;">
                            0
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            PERSONAL OPERATIVO
                        </td>
                        <td id="td_table_total_${cod}_personal_operativo" style="text-align: center;">
                            0
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            PERSONAL NOCTURNA ENTRANTE
                        </td>
                        <td id="td_table_total_${cod}_personal_nocturna_entrante" style="text-align: center;">
                            0
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            PERSONAL TERMINAL TERRESTRE
                        </td>
                        <td id="td_table_total_${cod}_personal_terminal_terrestre" style="text-align: center;">
                            0
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            PERSONAL FRANCO
                        </td>
                        <td id="td_table_total_${cod}_personal_franco" style="text-align: center;">
                            0
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            TOTAL
                        </td>
                        <td id="td_table_total_${cod}_personal_total" style="text-align: center;">
                            0
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <span class="box-options-icon box_move box_move--left drag-handle">
            <i class="fa fa-arrows" aria-hidden="true"></i>
        </span>
        <span class="box-options-icon box_move box_move--right">
            <i class="fa fa-pencil-square asign_header" aria-hidden="true"></i>
            <i class="fa fa-trash delete_container" aria-hidden="true"></i>
        </span>
    `;
}
//-------------------------------------------------------------

//Functiones tabla franco
function getContenedorTabla_Franco(cod) {
    return `
        <div class="table_container_total">
            <table data-table_total="${cod}">
                <tbody>
                    <tr>
                        <td style="text-align: center;">
                            
                        </td>
                        <td style="text-align: center;">
                        
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <span class="box-options-icon box_move box_move--left drag-handle">
            <i class="fa fa-arrows" aria-hidden="true"></i>
        </span>
        <span class="box-options-icon box_move box_move--right">
            <i class="fa fa-pencil-square asign_header" aria-hidden="true"></i>
            <i class="fa fa-trash delete_container" aria-hidden="true"></i>
        </span>
    `;
}
//---------------------------------------------------------------
//Funciones para image
function getPlantillaImage(cont) {
    return `
            <div class="image_content">
                <i class="fa fa-picture-o image_content_img"></i>
                <span id="btn_delete_image-${cont}" style="display: none;" class="btn_delete_img">
                    <i class="btn_delete_image--icon fa fa-trash"></i>
                </span>
            </div>
            <input type="file" id="input_img_${cont}" accept="image/*" style="display: none;">
            <span class="box-options-icon box_move box_move--left drag-handle">
                <i class="fa fa-arrows" aria-hidden="true"></i>
            </span>
            <span class="box-options-icon box_move box_move--right">
                <i class="fa fa-pencil-square asign_header" aria-hidden="true"></i>
                <i class="fa fa-trash delete_container" aria-hidden="true"></i>
            </span>
    `;
}
function addEventImage(imageContent, input, cod) {
    let btnDeleteImage = imageContent.querySelector(`span[id="btn_delete_image-${cod}"]`);
    imageContent.addEventListener('click', () => {
        if (!imageContent.classList.contains('loaded')) {
            input.click();
        }
    });

    input.addEventListener('change', (event) => {
        let file = event.target.files[0];
        let reader = new FileReader();

        reader.onload = function (e) {
            imageContent.style.backgroundImage = "url('" + e.target.result + "')";
            imageContent.querySelector('.image_content_img').style.display = 'none';
            //divImagen.querySelector('.img_preview--text').style.display = 'none';
            imageContent.classList.add('loaded')
            btnDeleteImage.style.display = 'flex';
        };

        reader.readAsDataURL(file);
    });

    btnDeleteImage.addEventListener('click', (e) => {
        e.stopPropagation();
        btnDeleteImage.style.display = 'none';
        input.value = '';
        imageContent.style.backgroundImage = "";
        imageContent.querySelector('.image_content_img').style.display = 'block';
        imageContent.classList.remove('loaded');
    });
}
//------------------------------------------------------------