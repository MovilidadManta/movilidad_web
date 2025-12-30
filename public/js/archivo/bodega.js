//Pagina Principal de Bodega
let breadcumContainer = document.getElementById('breadcum_menu_archivo'); //Menu tab de medios
let principalItemBreadcum = document.getElementById('principal_item_breadcum');//Item de pagina principal de BreadCum
let containerListaUnidadesAlmacenamiento = document.getElementById('container_unidad_almacenamiento'); //Contenedor donde estan los medios de almacenamiento creados
let tableDocumentos = document.getElementById('div_table_documentos_stored'); //Tabla de documentos subidos
let containerUnidadAlmacenamiento = document.getElementById('container_actions_unidad_almacenamiento'); //Contenedor donde estan los botones para agregar un medio de almacenamiento
let listaMenuLateral = document.getElementById('lista_archivos_lateral');//Listado de arbol para los contenedores o medios de almacenamiento
let bodegaBadge = document.getElementById('bodega_badge');//Item principal del menu lateral
let btnDeleteMedioAlmacenamiento = document.getElementById('btn_delete_medio_almacenamiento');//Boton del modal para confirmar eliminacion del medio de almacenamiento
let ma_id_charge = document.getElementById('ma_id_charge');

//Modal de agregar medio almacenamiento
let capacidadMedioAlmacenamiento = document.getElementById('capacidad-modal_agregar_medio_almacenamiento'); //Span de Capacidad del medio de almacenamiento
let caracteristicasMedioAlmacenamiento = document.getElementById('caracteristicas-modal_agregar_medio_almacenamiento');//Span de Caracteristicas del medio de almacenamiento 
let medioAlmacenamientoPadreAgregar = document.getElementById('ma_id_padre-modal_agregar_medio_almacenamiento'); //id padre de la unidad de almacenamiento 0 es principal de la bodega
let configurarMedioAlmacenamientoAgregar = document.getElementById('id_configuracion_unidad_almacenamiento-modal_agregar_medio_almacenamiento');//ID de Tipo de unidad de almacenamiento
let bodegaMedioAlmacenamientoAgregar = document.getElementById('id_bodega-modal_agregar_medio_almacenamiento');//Id de Bodega seleccionada
let txtCodigoMedioAlmacenamientoAgregar = document.getElementById('txt_codigo-modal_agregar_medio_almacenamiento');//Texto de Codigo del medio de almacenamiento
let selectMedioAlmacenamientoUnidadProductoraAgregar = document.getElementById('cup_id-modal_agregar_medio_almacenamiento');//Select de configuracion unidad productora
let selectMedioAlmacenamientoUnidadProductoraSerieAgregar = document.getElementById('cups_id-modal_agregar_medio_almacenamiento');//Select de configuracion unidad productora serie
let selectMedioAlmacenamientoDocumentoAgregar = document.getElementById('cd_id-modal_agregar_medio_almacenamiento');//Select de configuracion de documento
let accionMedioAlmacenamiento = document.getElementById('accion-modal_agregar_medio_almacenamiento');//accion medio almacenamiento Indica si es para agregar o modificar
let btnGuardarMedioAlmacenamiento = document.getElementById('btn_guardar_unidad_almacenamiento-modal_agregar_medio_almacenamiento');//Boton de guardar medio de almacenamiento - del modal
let estadoFechaMedioAlmacenamientoDocumentoAgregar = document.getElementById('chk_estado_fechas-modal_agregar_medio_almacenamiento');
let fechaInicioMedioAlmacenamientoDocumentoAgregar = document.getElementById('fecha_inicio-modal_agregar_medio_almacenamiento');

let codigoUnidad = "";
let codigoMedio = "";
let codigoAnio = "";
let codigoSecuencial = "";

let cups_id_mod = 0; //Configuracion de unidad productora Serie de item a Modificar
let cd_id_mod = 0;//Configuracion de documento de item a Modificar

//Modal para agregar documentos
let idMedioAlmacenamientoDocumento = document.getElementById('id_medio_almacenamiento-modal_agregar_documento'); //Id del medio de almacenamiento al que pertenece el documento
let accionDocumento = document.getElementById('accion-modal_agregar_documento'); //Accion del formulario Modal para Documento = AGREGAR | MODIFICAR
let selectUnidadProductoraDocumento = document.getElementById('cup_id-modal_agregar_documento');//Select configuracion unidad productora
let selectUnidadProductoraSerieDocumento = document.getElementById('cups_id-modal_agregar_documento');//Selectconfiguracion unidad productora serie
let selectConfiguracionDocumento = document.getElementById('cd_id-modal_agregar_documento');//Select configuracion de documento
let divCamposDocumento = document.getElementById('campos-modal_agregar_documento');//Div para los campos dependiendo del tipo de documento
let btnGuardarDocumento = document.getElementById('btn_guardar_documento-modal_agregar_documento');//Boton para guardar o modificar un documento
let deleteDocumentoModal = document.getElementById('btn_delete_documento');//Confirmacion para eliminar un documento

let cup_id_doc_mod = 0; //Configuracion de unidad Productora para documento
let cups_id_doc_mod = 0;//Configuracion de unidad Productora Serie para documento
let cd_id_doc_mod = 0;//Configuracion de documento para modal documento
let campos_documento = [];//Campos para registro u modificacion
let cup_codigo = ""; //Codigo para completar el codigo del documento
let cup_descripcion = "";

//Pagina Principal de Bodega
let listConfiguracionUnidadesAlmacenamiento = []; //Configuracion de unidades de almacenamiento
let listMediosAlmacenamiento = []; //Lista completa de los medios de almacenamiento
let listMediosAlmacenamientoBody = []; //Lista actual de medio de almacenamiento

//Modal de agregar medio almacenamiento
let idMedioAlmacenamiento = 0; //Configuracion de medios de almacenameinto actual
let cup_id = 0; //Configuracion de la unidad productora
let cups_id = 0;//Configuracion de la unidad productora serie
let cd_id = 0;//Configuracion de documento
let upload_archive = false; //Subir archivo en este medio de almacenamiento

//Carga inicial
$(document).ready(function () {
    getConfiguracionMediosAlmacenamiento();
    configure_select_two_dates('fecha_inicio-modal_agregar_medio_almacenamiento', 'fecha_final-modal_agregar_medio_almacenamiento');
    medioAlmacenamientoPadreAgregar.value = 0;
    idMedioAlmacenamientoDocumento.value = 0;

    //Agregar
    setInputValidations('txt_codigo-modal_agregar_medio_almacenamiento', ['notEmpty'], []);
    setInputValidations('txt_codigo-modal_agregar_documento', ['notEmpty'], []);
    setInputValidations('cup_id-modal_agregar_documento', [], [
        {
            function: function (item) {
                return item.value.trim() == "0";
            },
            message: "Debe Seleccionar una Unidad Productora"
        }
    ]);
    setInputValidations('cups_id-modal_agregar_documento', [], [
        {
            function: function (item) {
                return item.value.trim() == "0";
            },
            message: "Debe Seleccionar una Unidad Productora Serie"
        }
    ]);
    setInputValidations('cd_id-modal_agregar_documento', [], [
        {
            function: function (item) {
                return item.value.trim() == "0";
            },
            message: "Debe Seleccionar un Documento"
        }
    ]);

    $('#txt_codigo-modal_agregar_medio_almacenamiento').on('keypress', function (e) {
        // Verificamos si la tecla presionada es "Enter"
        if (e.which === 13) {
            // Cancelamos el envío del formulario
            e.preventDefault();
        }
    });

    set_type_input('txt_nro_folio-modal_agregar_documento', 'number');
    setInputValidations('txt_nro_folio-modal_agregar_documento', ['notEmpty'], [{
        function: function (item) {
            let valorNum = +item.value.trim();
            return item.value.trim() != "" && valorNum == 0;
        },
        message: "Debe digitar un numero mayor que 0"
    }]);

    btnGuardarMedioAlmacenamiento.addEventListener('click', agregarMedioAlmacenamiento);
    btnGuardarDocumento.addEventListener('click', agregarDocumento);

    getMediosAlmacenamiento(bodegaMedioAlmacenamientoAgregar.value, 0);
    addEventClickLiBreadCum(breadcumContainer);

});

selectMedioAlmacenamientoUnidadProductoraAgregar.addEventListener('change', e => {
    let optionSelect = selectMedioAlmacenamientoUnidadProductoraAgregar.querySelector(`option[value="${selectMedioAlmacenamientoUnidadProductoraAgregar.value}"]`);
    codigoUnidad = optionSelect ? optionSelect.dataset.codigo : "";

    setCodigoValueMaxMedioAlmacenamiento();
});

estadoFechaMedioAlmacenamientoDocumentoAgregar.addEventListener('click', () => {
    fechaInicioMedioAlmacenamientoDocumentoAgregar.dispatchEvent(new Event('change'));
});

fechaInicioMedioAlmacenamientoDocumentoAgregar.addEventListener('change', () => {

    codigoAnio = estadoFechaMedioAlmacenamientoDocumentoAgregar.checked ? fechaInicioMedioAlmacenamientoDocumentoAgregar.value.substring(0, 4) : new Date().getFullYear();

    setCodigoValueMaxMedioAlmacenamiento();
});

function clearDateFechas(inputDateInit, inputDateEnd) {
    const fecha = new Date();
    let mes = fecha.getMonth() + 1; //obteniendo mes
    let dia = fecha.getDate(); //obteniendo dia
    const ano = fecha.getFullYear(); //obteniendo año
    if (dia < 10)
        dia = '0' + dia; //agrega cero si el menor de 10
    if (mes < 10)
        mes = '0' + mes //agrega cero si el menor de 10

    inputDateInit.value = ano + "-" + mes + "-" + dia;
    inputDateEnd.value = ano + "-" + mes + "-" + dia;
}

//Pagina Principal de Bodega

//funciones para cargar los medios de almacenamiento
function getConfiguracionMediosAlmacenamiento() {
    $.ajax({
        url: '/lista-bodegas/getMediosAlmacenamiento',
        type: "GET",
        dataType: "json",
        success: function (response) {
            listConfiguracionUnidadesAlmacenamiento = response;
            renderBotonesAddMediosAlmacenamiento(idMedioAlmacenamiento);
        }
    });
}

function renderBotonesAddMediosAlmacenamiento(idUnidad) {
    let listActiveUnidadAlmacenamiento = [];
    let keys = [];
    containerUnidadAlmacenamiento.innerHTML = "";
    if (idUnidad == 0) {
        listActiveUnidadAlmacenamiento = listConfiguracionUnidadesAlmacenamiento.filter(item => !listConfiguracionUnidadesAlmacenamiento.some(({ cma_id_hijo }) => cma_id_hijo === item.cma_id));
        upload_archive = false;
    } else {
        let unidadActual = listConfiguracionUnidadesAlmacenamiento.filter(item => item.cma_id == idUnidad);
        upload_archive = unidadActual[0].cma_upload_archive;
        let hijosUnidades = unidadActual.map(i => i.cma_id_hijo);
        listActiveUnidadAlmacenamiento = listConfiguracionUnidadesAlmacenamiento.filter(item => hijosUnidades.includes(item.cma_id));
    }
    listActiveUnidadAlmacenamiento.forEach(u => {
        if (!keys.includes(u.cma_id))
            containerUnidadAlmacenamiento.innerHTML += `
            <div id="unidad_almacenamiento-${u.cma_id}" data-codigo="${u.cma_codigo}" data-capacidad="${u.cma_capacidad}" data-caracteristicas="${u.cma_caracteristicas}" class="control-card" data-upload_archive="false" data-value="${u.cma_id}">
                <i class="control-card__icon ${u.cma_icono}"></i>
                <span class="control-card__text">AGREGAR ${u.cma_tipo}</span>
                <i class="icon-agregar fa fa-plus-circle"></i>
            </div>
            `;
        keys.push(u.cma_id);
    });
    if (upload_archive) {
        containerUnidadAlmacenamiento.innerHTML += `
            <div id="unidad_almacenamiento-${medioAlmacenamientoPadreAgregar.value}" class="control-card" data-upload_archive="true" data-value="${medioAlmacenamientoPadreAgregar.value}">
                <i class="control-card__icon fa fa-file-pdf-o"></i>
                <span class="control-card__text">AGREGAR ARCHIVO</span>
                <i class="icon-agregar fa fa-plus-circle"></i>
            </div>
            `;
    }
    $("#container_actions_unidad_almacenamiento_charge").fadeOut();
    $("#container_actions_unidad_almacenamiento").fadeIn();
    addEventClickMediosAlmacenamientoBtnsAdd(containerUnidadAlmacenamiento);
}

function addEventClickMediosAlmacenamientoBtnsAdd(listaUnidadAlmacenamiento) {
    let unidades = listaUnidadAlmacenamiento.querySelectorAll('div[id^="unidad_almacenamiento-"]');
    unidades.forEach(u => {
        u.addEventListener('click', () => {
            if (u.dataset.upload_archive == "true") {
                getUnidadProductoraDoc(selectUnidadProductoraDocumento, cup_id);
                clearModalDocumentos();
                accionDocumento.value = "AGREGAR";
                cup_id_doc_mod = 0;
                cups_id_doc_mod = 0;
                cd_id_doc_mod = 0;
                campos_documento = [];

                $("#modal_agregar_documento").modal("show");
            } else {
                let codigoE = document.getElementById('txt_codigo-modal_agregar_medio_almacenamiento');
                let descripcionE = document.getElementById('txt_descripcion-modal_agregar_medio_almacenamiento');
                let estadoFechaE = document.getElementById('chk_estado_fechas-modal_agregar_medio_almacenamiento');
                let fechaInicioE = document.getElementById('fecha_inicio-modal_agregar_medio_almacenamiento');
                let fechaFinE = document.getElementById('fecha_final-modal_agregar_medio_almacenamiento');
                let btnDeleteImagenMedioAlmacenamiento = document.getElementById('btn_delete_image-modal_agregar_medio_almacenamiento');
                let codigo = u.dataset.codigo;
                configurarMedioAlmacenamientoAgregar.value = u.dataset.value;
                capacidadMedioAlmacenamiento.innerHTML = u.dataset.capacidad;
                caracteristicasMedioAlmacenamiento.innerHTML = u.dataset.caracteristicas;
                codigoE.value = "";
                descripcionE.value = "";
                estadoFechaE.checked = false;
                estadoFechaE.dispatchEvent(new Event('change'));
                btnDeleteImagenMedioAlmacenamiento.dispatchEvent(new Event('click'));
                clearDateFechas(fechaInicioE, fechaFinE);
                accionMedioAlmacenamiento.value = "AGREGAR";
                cups_id_mod = 0;
                cd_id_mod = 0;
                $("#btn_guardar_unidad_almacenamiento-modal_agregar_medio_almacenamiento").fadeIn();
                $("#modal_agregar_medio_almacenamiento").modal("show");
                getUnidadProductora(selectMedioAlmacenamientoUnidadProductoraAgregar);
                getSecuencialMaxMedioAlmacenamiento(codigo, configurarMedioAlmacenamientoAgregar, medioAlmacenamientoPadreAgregar, bodegaMedioAlmacenamientoAgregar, "modal_agregar_medio_almacenamiento", txtCodigoMedioAlmacenamientoAgregar);
            }
        });
    });
}
//------------------------------------------------------------

//Funciones para los medios de almacenamiento creados
function getMediosAlmacenamiento(idBodega, idPadre) {
    $.ajax({
        url: `/lista-bodegas/get_medios_almacenamiento/0/${idBodega}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            listMediosAlmacenamiento = response;
            setListActualMedioAlmacenamiento(listMediosAlmacenamiento, idPadre);
            cargarMenuLateral(listMediosAlmacenamiento);
            renderMediosAlmacenamientoStored();
            getDocumentos(idMedioAlmacenamientoDocumento.value);
            if (ma_id_charge.value != 0) {
                let li_active = listaMenuLateral.querySelector(`li[data-ma_id="${ma_id_charge.value}"]`);
                ma_id_charge.value = 0;
                li_active.dispatchEvent(new Event('click'));
            }
        }
    });
}

function cargarMenuLateral(listaMediosAlmacenamiento) {
    renderMenu(listaMenuLateral, listaMediosAlmacenamiento);
    $("#lista_archivos_lateral_charge").fadeOut();
    $("#lista_archivos_lateral").fadeIn();
    addEventClickMenuLateralLi(listaMenuLateral);
}

function renderMenu(listaDiv, items) {
    items.forEach(h => {
        let containerlista = listaDiv.querySelector(`ul[data-id_padre="${h.ma_id_padre}"]`);
        let liFound = listaDiv.querySelector(`li[data-ma_id="${h.ma_id}"]`);
        if (!containerlista) {
            let li = listaDiv.querySelector(`li[data-ma_id="${h.ma_id_padre}"]`);
            containerlista = document.createElement("ul");
            containerlista.classList.add("menu-list");
            containerlista.classList.add("contract");
            containerlista.setAttribute("data-id_padre", `${h.ma_id_padre}`);
            li.appendChild(containerlista);
        }

        if (liFound) {
            let p = liFound.querySelector(`.menu-list__li[data-ma_id="${liFound.dataset.ma_id}"]`);
            liFound.cma_icono = h.cma_icono;
            liFound.ma_codigo = h.ma_codigo;
            liFound.cma_tipo = h.cma_tipo;
            p.innerHTML = `<span class="expandButtonMedio" data-ma_id="${h.ma_id}"><i class="fa fa-angle-right"></i> <i class="${h.cma_icono}"></i></span> ${h.cma_tipo}(${h.ma_codigo})`;
        } else {
            containerlista.innerHTML += `
            <li data-ma_id="${h.ma_id}" data-cma_icono="${h.cma_icono}" data-ma_codigo="${h.ma_codigo}" data-cma_tipo="${h.cma_tipo}">
                <p class="menu-list__li" data-ma_id="${h.ma_id}"><span class="expandButtonMedio" data-ma_id="${h.ma_id}"><i class="fa fa-angle-right"></i> <i class="${h.cma_icono}"></i></span> ${h.cma_tipo}(${h.ma_codigo})</p>
            </li>
        `;
        }

        if (h.medios_almacenamiento.length > 0)
            renderMenu(listaDiv, h.medios_almacenamiento);
    });
}

function addEventClickMenuLateralLi(listaDiv) {
    let lis = listaDiv.querySelectorAll('li[data-ma_id]');
    let btnsExpand = listaDiv.querySelectorAll('.expandButtonMedio[data-ma_id]');
    btnsExpand.forEach(b => {
        b.addEventListener('click', e => {
            e.stopPropagation();
            let liClicked = listaDiv.querySelector(`li[data-ma_id="${b.dataset.ma_id}"]`);
            let parr = liClicked.querySelector(`p[data-ma_id="${b.dataset.ma_id}"]`);
            if (liClicked.classList.contains('active')) {
                liClicked.classList.remove('active');
                parr.classList.remove('active');
                let ul = liClicked.querySelector(`ul[data-id_padre="${b.dataset.ma_id}"]`);
                if (ul) {
                    ul.classList.add('contract');
                }
            } else {
                liClicked.classList.add('active');
                parr.classList.add('active');
                let ul = liClicked.querySelector(`ul[data-id_padre="${b.dataset.ma_id}"]`);
                if (ul) {
                    ul.classList.remove('contract');
                }
            }
        });
    });

    lis.forEach(l => {
        l.addEventListener('click', e => {
            e.stopPropagation();
            createBreadCumClickLiMenuLateral(listaDiv, l);
            setListActualMedioAlmacenamiento(listMediosAlmacenamiento, l.dataset.ma_id);
            renderBotonesAddMediosAlmacenamiento(idMedioAlmacenamiento);
            renderMediosAlmacenamientoStored();
            getDocumentos(idMedioAlmacenamientoDocumento.value);
        });
    });
}

//Funciones Menu BreadCum
function createBreadCumClickLiMenuLateral(listaDiv, li) {
    let itemsOpens = [];
    let ulPadre = li.parentNode;
    itemsOpens.push({
        ma_id: li.dataset.ma_id,
        name: `<i class="${li.dataset.cma_icono}"></i> ${li.dataset.cma_tipo}(${li.dataset.ma_codigo})`
    });

    while (ulPadre.dataset.id_padre != 0) {
        li = listaDiv.querySelector(`li[data-ma_id="${ulPadre.dataset.id_padre}"]`);
        ulPadre = li.parentNode;
        itemsOpens.push({
            ma_id: li.dataset.ma_id,
            name: `<i class="${li.dataset.cma_icono}"></i> ${li.dataset.cma_tipo}(${li.dataset.ma_codigo})`
        });
    }

    principalItemBreadcum.dispatchEvent(new Event('click'));

    itemsOpens.reverse().forEach(i => {
        addItemBreadcum(i.ma_id, i.name);
    });
}

function addItemBreadcum(ma_id, nameUnidad) {
    let items = breadcumContainer.querySelectorAll('.breadcrumb-item');
    let ultimoId = items[items.length - 1];
    ultimoId.classList.remove('active');

    breadcumContainer.innerHTML += `
        <li class="breadcrumb-item active" data-padre="${ma_id}" data-id="${parseInt(ultimoId.dataset.id) + 1}" aria-current="page">${nameUnidad}</li>
    `;

    addEventClickLiBreadCum(breadcumContainer);
}

function addEventClickLiBreadCum(container) {
    let items = container.querySelectorAll('.breadcrumb-item');
    items.forEach(i => {
        i.addEventListener('click', e => {
            items = container.querySelectorAll('.breadcrumb-item');
            let ultimoId = items[items.length - 1];
            i.classList.add('active');
            if (i.dataset.id != ultimoId.dataset.id) {
                for (let index = parseInt(i.dataset.id) + 1; index <= parseInt(ultimoId.dataset.id); index++) {
                    items[index - 1].remove();
                }
            }
            setListActualMedioAlmacenamiento(listMediosAlmacenamiento, i.dataset.padre);
            renderBotonesAddMediosAlmacenamiento(idMedioAlmacenamiento);
            renderMediosAlmacenamientoStored();
            getDocumentos(idMedioAlmacenamientoDocumento.value);
        })
    });
}

bodegaBadge.addEventListener('click', () => {
    principalItemBreadcum.dispatchEvent(new Event('click'));
    setListActualMedioAlmacenamiento(listMediosAlmacenamiento, 0);
    renderBotonesAddMediosAlmacenamiento(idMedioAlmacenamiento);
    renderMediosAlmacenamientoStored();
    getDocumentos(idMedioAlmacenamientoDocumento.value);
});

//Funciones renderiza Medio de almacenamiento actual
function renderMediosAlmacenamientoStored() {
    containerListaUnidadesAlmacenamiento.innerHTML = "";
    if (cup_descripcion != "") {
        containerListaUnidadesAlmacenamiento.innerHTML += `
        <div class="alert alert-primary w-100" role="alert">
            ${cup_descripcion}
        </div>
        `;
    }
    listMediosAlmacenamientoBody.forEach(l => {
        let imagen = l.ma_ruta_imagen;
        let imagen_container = "";
        let descripcion = "";
        if (imagen) {
            imagen_container = `<img class="card-img-top w-100 card_unidad_productora__img border_dashed" src="${l.ma_ruta_imagen}" alt="${l.ma_codigo}">`;
        } else {
            imagen_container = `<div class="card_unidad_productora__img border_dashed"><i class="control-card__icon ${l.cma_icono}"></i></div>`;
        }

        if (l.ma_descripcion.trim() != "") {
            descripcion = `<p class="card-text card-text__bold">Descripción: <span class="card-text">${l.ma_descripcion}</span></p>`;
        }

        containerListaUnidadesAlmacenamiento.innerHTML += `
            <div class="card h-100 card_unidad_productora text-center card_medio_almacenamiento">
                ${imagen_container}
                <div class="card-body d-flex flex-column justify-content-between">
                    <h4 class="card-title mb-3">${l.cma_tipo}(${l.ma_codigo})</h4>
                    ${descripcion}
                    <p class="card-text card-text__bold">Fecha Desde: <span class="card-text">${l.ma_estado_fecha ? l.ma_fecha_desde : '-'}</span></p>
                    <p class="card-text card-text__bold mb-2">Fecha Hasta: <span class="card-text">${l.ma_estado_fecha ? l.ma_fecha_hasta : '-'}</span></p>
                    <a class="btn btn-primary" 
                    id="btn_ingresar_medio_almacenamiento-${l.ma_id}" 
                    data-id="${l.ma_id}"
                    data-cma_icono="${l.cma_icono}"
                    data-ma_codigo="${l.ma_codigo}"
                    data-cma_tipo="${l.cma_tipo}"
                    href="#"><i class="fa fa-eye"></i> Ingresar</a>
                </div>
                <span id="btn_more_actions_medio_almacenamiento-${l.ma_id}" data-id="${l.ma_id}" class="card_medio_almacenamiento--container_btn_config">
                    <i class="card_medio_almacenamiento--icon_btn_config fa fa-cog"></i>
                </span>
                <span id="btn_info_medio_almacenamiento-${l.ma_id}" data-id="${l.ma_id}" class="card_medio_almacenamiento--container_btn_icons card_medio_almacenamiento--container_btn_icons--info">
                    <i class="card_medio_almacenamiento--icon_btn_icons fa fa-info"></i>
                </span>
                <span id="btn_update_medio_almacenamiento-${l.ma_id}" 
                data-id="${l.ma_id}"
                data-cma_id="${l.cma_id}" 
                data-capacidad="${l.cma_capacidad}" 
                data-caracteristicas="${l.cma_caracteristicas}" 
                data-ma_codigo="${l.ma_codigo}" 
                data-ma_descripcion="${l.ma_descripcion}" 
                data-cup_id="${l.cup_id}" 
                data-cups_id="${l.cups_id}" 
                data-cd_id="${l.cd_id}" 
                data-ma_ruta_imagen="${l.ma_ruta_imagen}" 
                data-ma_estado_fecha="${l.ma_estado_fecha}" 
                data-ma_fecha_desde="${l.ma_fecha_desde}" 
                data-ma_fecha_hasta="${l.ma_fecha_hasta}"
                data-ma_secuencial="${l.ma_secuencial}"
                data-cma_codigo="${l.cma_codigo}"
                class="card_medio_almacenamiento--container_btn_icons card_medio_almacenamiento--container_btn_icons--edit">
                    <i class="card_medio_almacenamiento--icon_btn_icons fa fa-pencil"></i>
                </span>
                <span id="btn_delete_medio_almacenamiento-${l.ma_id}" data-id="${l.ma_id}" class="card_medio_almacenamiento--container_btn_icons card_medio_almacenamiento--container_btn_icons--delete">
                    <i class="card_medio_almacenamiento--icon_btn_icons fa fa-trash"></i>
                </span>
            </div>
        `;
    });
    if (listMediosAlmacenamientoBody.length == 0 && !upload_archive) {
        containerListaUnidadesAlmacenamiento.innerHTML += `
            <div class="empty_medio_almacenamiento">
                <i class="fa fa-dropbox icon_empty" aria-hidden="true"></i>
                <p>CONTENEDOR VACÍO</p>
            </div>
            
        `;
    }
    $("#container_unidad_almacenamiento_charge").fadeOut();
    $("#container_unidad_almacenamiento").fadeIn();
    eventClickMedioAlmacenamiento(containerListaUnidadesAlmacenamiento);
    eventClickActionsMedioAlmacenamiento(containerListaUnidadesAlmacenamiento);
}

selectMedioAlmacenamientoUnidadProductoraAgregar.addEventListener('change', (e) => {
    let valuesSerie = selectMedioAlmacenamientoUnidadProductoraAgregar.querySelector(`option[value^="${e.target.value}"]`);
    let values = cups_id == 0 ? JSON.parse(valuesSerie.dataset.serie) : JSON.parse(valuesSerie.dataset.serie).filter(f => f.cups_id == cups_id);
    selectMedioAlmacenamientoUnidadProductoraSerieAgregar.setValueCombo(values, cups_id);
    if (cups_id_mod != 0)
        selectMedioAlmacenamientoUnidadProductoraSerieAgregar.value = cups_id_mod;
    if (selectMedioAlmacenamientoUnidadProductoraSerieAgregar.value == '')
        selectMedioAlmacenamientoUnidadProductoraSerieAgregar.value = 0;
    selectMedioAlmacenamientoUnidadProductoraSerieAgregar.dispatchEvent(new Event('change'));
});

selectMedioAlmacenamientoUnidadProductoraSerieAgregar.addEventListener('change', (e) => {
    $("#body_medio_almacenamiento-modal_agregar_medio_almacenamiento").fadeOut();
    $("#footer_medio_almacenamiento-modal_agregar_medio_almacenamiento").fadeOut();
    $("#body_charge_medio_almacenamiento-modal_agregar_medio_almacenamiento").fadeIn();
    $("#footer_charge_medio_almacenamiento-modal_agregar_medio_almacenamiento").fadeIn();
    getUnidadProductoraDocumento(selectMedioAlmacenamientoDocumentoAgregar, e.target.value, cd_id_mod);
});


function getUnidadProductora(selectUnidadProductora, id) {
    $("#body_medio_almacenamiento-modal_agregar_medio_almacenamiento").fadeOut();
    $("#footer_medio_almacenamiento-modal_agregar_medio_almacenamiento").fadeOut();
    $("#body_charge_medio_almacenamiento-modal_agregar_medio_almacenamiento").fadeIn();
    $("#footer_charge_medio_almacenamiento-modal_agregar_medio_almacenamiento").fadeIn();
    $("#container_actions_unidad_almacenamiento_charge").fadeOut();
    $.ajax({
        url: `/lista-bodegas/getUnidadProductora/${cup_id}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            selectUnidadProductora.setValueCombo(response, cup_id);
            if (id) {
                selectUnidadProductora.value = id;
            }
            selectUnidadProductora.dispatchEvent(new Event('change'));
        }
    });
}

function getUnidadProductoraDocumento(selectDocumento, id, cd_id_r) {
    $.ajax({
        url: `/lista-bodegas/getUnidadProductoraSerieDocumento/${id}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            selectDocumento.setValueCombo(cd_id == 0 ? response : response.filter(f => f.cd_id == cd_id), cd_id);
            if (cd_id_r != 0)
                selectDocumento.value = cd_id_r;
            if (selectDocumento.value == '')
                selectDocumento.value = 0;
            $("#body_medio_almacenamiento-modal_agregar_medio_almacenamiento").fadeIn();
            $("#footer_medio_almacenamiento-modal_agregar_medio_almacenamiento").fadeIn();
            $("#body_charge_medio_almacenamiento-modal_agregar_medio_almacenamiento").fadeOut();
            $("#footer_charge_medio_almacenamiento-modal_agregar_medio_almacenamiento").fadeOut();
        }
    });
}

function eventClickMedioAlmacenamiento(container) {
    let containerBtn = container.querySelectorAll('a[id^="btn_ingresar_medio_almacenamiento-"]');
    containerBtn.forEach(b => {
        b.addEventListener('click', (e) => {
            e.preventDefault();
            setListActualMedioAlmacenamiento(listMediosAlmacenamiento, b.dataset.id);
            renderBotonesAddMediosAlmacenamiento(idMedioAlmacenamiento);
            renderMediosAlmacenamientoStored();
            getDocumentos(idMedioAlmacenamientoDocumento.value);
            addItemBreadcum(b.dataset.id, `<i class="${b.dataset.cma_icono}"></i> ${b.dataset.cma_tipo}(${b.dataset.ma_codigo})`)
        });
    });
}

function eventClickActionsMedioAlmacenamiento(container) {
    let configBtns = container.querySelectorAll('span[id^="btn_more_actions_medio_almacenamiento-"]');
    configBtns.forEach(c => {
        c.addEventListener('click', (e) => {
            let activeBtns = container.querySelectorAll(`span[id^="btn_more_actions_medio_almacenamiento-"].active`);
            let btnInfo = container.querySelector(`span[id="btn_info_medio_almacenamiento-${c.dataset.id}"]`);
            let btnUpdate = container.querySelector(`span[id="btn_update_medio_almacenamiento-${c.dataset.id}"]`);
            let btnDelete = container.querySelector(`span[id="btn_delete_medio_almacenamiento-${c.dataset.id}"]`);
            activeBtns.forEach(a => {
                if (c.id != a.id) {
                    a.dispatchEvent(new Event('click'));
                }
            })
            if (c.classList.contains('active')) {
                c.classList.remove('active');
                btnInfo.classList.remove('active');
                btnUpdate.classList.remove('active');
                btnDelete.classList.remove('active');

            } else {
                c.classList.add('active');
                btnInfo.classList.add('active');
                btnUpdate.classList.add('active');
                btnDelete.classList.add('active');
                btnInfo.addEventListener('click', () => { showMedioAlmacenamientoBtnEventClick(btnUpdate) });
                btnUpdate.addEventListener('click', () => { updateMedioAlmacenamientoBtnEventClick(btnUpdate) });
                btnDelete.addEventListener('click', () => { deleteMedioAlmacenamientoBtnEventClick(btnDelete) });
            }
        });
    });
}

function updateMedioAlmacenamientoBtnEventClick(b) {
    let idE = document.getElementById('id_unidad_almacenamiento-modal_agregar_medio_almacenamiento');
    let codigoE = document.getElementById('txt_codigo-modal_agregar_medio_almacenamiento');
    let descripcionE = document.getElementById('txt_descripcion-modal_agregar_medio_almacenamiento');
    let estadoFechaE = document.getElementById('chk_estado_fechas-modal_agregar_medio_almacenamiento');
    let fechaInicioE = document.getElementById('fecha_inicio-modal_agregar_medio_almacenamiento');
    let fechaFinE = document.getElementById('fecha_final-modal_agregar_medio_almacenamiento');
    let input_img = document.getElementById('imagen-modal_agregar_medio_almacenamiento');
    let btnDeleteImagenMedioAlmacenamiento = document.getElementById('btn_delete_image-modal_agregar_medio_almacenamiento');
    let img_mod = new Image();
    idE.value = b.dataset.id;
    configurarMedioAlmacenamientoAgregar.value = b.dataset.cma_id;
    accionMedioAlmacenamiento.value = "MODIFICAR";
    btnDeleteImagenMedioAlmacenamiento.dispatchEvent(new Event('click'));
    codigoE.value = b.dataset.ma_codigo;
    descripcionE.value = b.dataset.ma_descripcion;
    estadoFechaE.checked = b.dataset.ma_estado_fecha == 'true';
    estadoFechaE.dispatchEvent(new Event('change'));
    cups_id_mod = b.dataset.cups_id;
    cd_id_mod = b.dataset.cd_id;
    capacidadMedioAlmacenamiento.innerHTML = b.dataset.capacidad;
    caracteristicasMedioAlmacenamiento.innerHTML = b.dataset.caracteristicas;
    codigoSecuencial = b.dataset.ma_secuencial.toString().padStart(3, '0');
    codigoMedio = b.dataset.cma_codigo;
    if (b.dataset.ma_ruta_imagen != "") {
        img_mod.src = b.dataset.ma_ruta_imagen;
    }
    clearDateFechas(fechaInicioE, fechaFinE);
    fechaInicioE.value = b.dataset.ma_fecha_desde;
    fechaFinE.value = b.dataset.ma_fecha_hasta;
    fechaInicioE.dispatchEvent(new Event('change'));
    getUnidadProductora(selectMedioAlmacenamientoUnidadProductoraAgregar, b.dataset.cup_id);
    img_mod.onload = function () {
        // Crear un objeto File con la imagen cargada
        fetch(b.dataset.ma_ruta_imagen)
            .then(res => res.blob())
            .then(blob => {
                let file = new File([blob], "imagen.jpg", { type: "image/jpg" });

                let input = document.createElement("input");
                input.type = "file";

                let fileList = new DataTransfer();
                fileList.items.add(file);

                input_img.files = fileList.files;
                input_img.dispatchEvent(new Event('change'));
            });
    };

    $("#btn_guardar_unidad_almacenamiento-modal_agregar_medio_almacenamiento").fadeIn();
    $("#modal_agregar_medio_almacenamiento").modal("show");
}

function showMedioAlmacenamientoBtnEventClick(b) {
    let idE = document.getElementById('id_unidad_almacenamiento-modal_agregar_medio_almacenamiento');
    let codigoE = document.getElementById('txt_codigo-modal_agregar_medio_almacenamiento');
    let descripcionE = document.getElementById('txt_descripcion-modal_agregar_medio_almacenamiento');
    let estadoFechaE = document.getElementById('chk_estado_fechas-modal_agregar_medio_almacenamiento');
    let fechaInicioE = document.getElementById('fecha_inicio-modal_agregar_medio_almacenamiento');
    let fechaFinE = document.getElementById('fecha_final-modal_agregar_medio_almacenamiento');
    let input_img = document.getElementById('imagen-modal_agregar_medio_almacenamiento');
    let btnDeleteImagenMedioAlmacenamiento = document.getElementById('btn_delete_image-modal_agregar_medio_almacenamiento');
    let img_mod = new Image();
    idE.value = b.dataset.id;
    configurarMedioAlmacenamientoAgregar.value = b.dataset.cma_id;
    accionMedioAlmacenamiento.value = "MODIFICAR";
    btnDeleteImagenMedioAlmacenamiento.dispatchEvent(new Event('click'));
    getUnidadProductora(selectMedioAlmacenamientoUnidadProductoraAgregar, b.dataset.cup_id);
    codigoE.value = b.dataset.ma_codigo;
    descripcionE.value = b.dataset.ma_descripcion;
    estadoFechaE.checked = b.dataset.ma_estado_fecha == 'true';
    estadoFechaE.dispatchEvent(new Event('change'));
    cups_id_mod = b.dataset.cups_id;
    cd_id_mod = b.dataset.cd_id;
    capacidadMedioAlmacenamiento.innerHTML = b.dataset.capacidad;
    caracteristicasMedioAlmacenamiento.innerHTML = b.dataset.caracteristicas;
    if (b.dataset.ma_ruta_imagen != "") {
        img_mod.src = b.dataset.ma_ruta_imagen;
    }
    clearDateFechas(fechaInicioE, fechaFinE);
    if (estadoFechaE.checked) {
        fechaInicioE.value = b.dataset.ma_fecha_desde;
        fechaFinE.value = b.dataset.ma_fecha_hasta;
    }

    img_mod.onload = function () {
        // Crear un objeto File con la imagen cargada
        fetch(b.dataset.ma_ruta_imagen)
            .then(res => res.blob())
            .then(blob => {
                let file = new File([blob], "imagen.jpg", { type: "image/jpg" });

                let input = document.createElement("input");
                input.type = "file";

                let fileList = new DataTransfer();
                fileList.items.add(file);

                input_img.files = fileList.files;
                input_img.dispatchEvent(new Event('change'));
            });
    };

    $("#btn_guardar_unidad_almacenamiento-modal_agregar_medio_almacenamiento").fadeOut();
    $("#modal_agregar_medio_almacenamiento").modal("show");
}

function deleteMedioAlmacenamientoBtnEventClick(b) {
    $('#txt_id_delete_medio_almacenamiento').val(b.dataset.id);
    $("#modal_confirm_delete_medio_almacenamiento").modal("show");
}

function setListActualMedioAlmacenamiento(lista, ma_id) {
    if (lista == undefined) {
        return false;
    }

    if (ma_id == 0) {
        idMedioAlmacenamiento = 0;
        medioAlmacenamientoPadreAgregar.value = 0;
        idMedioAlmacenamientoDocumento.value = 0;
        cup_id = 0;
        cups_id = 0;
        cd_id = 0;
        cup_descripcion = "";

        listMediosAlmacenamientoBody = lista;
        return true;
    };

    lista.forEach(l => {
        if (l.ma_id == ma_id) {
            idMedioAlmacenamiento = l.cma_id;
            medioAlmacenamientoPadreAgregar.value = l.ma_id;
            idMedioAlmacenamientoDocumento.value = l.ma_id;
            cup_id = l.cup_id;
            cups_id = l.cups_id;
            cd_id = l.cd_id;
            cup_descripcion = l.ma_descripcion;
            listMediosAlmacenamientoBody = l.medios_almacenamiento;
            console.log(cd_id)
            return true;
        }
        let response = setListActualMedioAlmacenamiento(l.medios_almacenamiento, ma_id);
        if (response) {
            return response;
        }
    });

    return false;
}

function getSecuencialMaxMedioAlmacenamiento(codigo, confUnidadAlmacenamiento, UnidadAlmacenamientoPadre, Bodega, modal, txtCodigo) {
    let token = $(`#csrf-token-${modal}`).val();
    let datos = new FormData();
    //datos.append('id_bodega', Bodega.value);
    //datos.append('ma_id_padre', UnidadAlmacenamientoPadre.value);
    datos.append('cma_id', confUnidadAlmacenamiento.value);
    $.ajax({
        url: '/lista-bodegas/getSecuencialMaxUnidadProductora',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            let secuencial = response.secuencial + 1;

            let optionSelect = selectMedioAlmacenamientoUnidadProductoraAgregar.querySelector(`option[value="${selectMedioAlmacenamientoUnidadProductoraAgregar.value}"]`);
            codigoUnidad = optionSelect ? optionSelect.dataset.codigo : "";
            codigoMedio = codigo;
            codigoAnio = estadoFechaMedioAlmacenamientoDocumentoAgregar.checked ? new Date(fechaInicioMedioAlmacenamientoDocumentoAgregar.value).getFullYear() : new Date().getFullYear();
            codigoSecuencial = secuencial.toString().padStart(3, '0');

            setCodigoValueMaxMedioAlmacenamiento();
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

function setCodigoValueMaxMedioAlmacenamiento() {
    let acronimoInstitucion = document.getElementById('acronimo_institucion');
    let acronimoDepartamento = document.getElementById('acronimo_departamento');
    codigoUnidad = codigoUnidad == "" ? acronimoDepartamento.value : codigoUnidad;
    txtCodigoMedioAlmacenamientoAgregar.value = `${acronimoInstitucion.value}-${codigoUnidad}-${codigoMedio}-${codigoAnio}-${codigoSecuencial}`;
}

function agregarMedioAlmacenamiento() {
    let codigoE = document.getElementById('txt_codigo-modal_agregar_medio_almacenamiento');
    let estadoFechaE = document.getElementById('chk_estado_fechas-modal_agregar_medio_almacenamiento');

    let errores = "";

    errores += codigoE.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede registrar la unidad productora, favor verifique los datos ingresados",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $("#btn_guardar_unidad_almacenamiento-modal_agregar_medio_almacenamiento").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");

        let token = $("#csrf-token-modal_agregar_medio_almacenamiento").val();
        let datos = new FormData($("#form_agregar_medio_almacenamiento")[0]);
        datos.append('ma_estado_fecha', estadoFechaE.checked);
        if (accionMedioAlmacenamiento.value == "AGREGAR") {

            $("#container_unidad_almacenamiento").fadeOut();
            $("#container_unidad_almacenamiento_charge").fadeIn();

            $.ajax({
                url: '/lista-bodegas/storeUnidadAlmacenamiento',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        notif({
                            msg: "<b>Correcto:</b> Unidad de Almacenamiento Registrada!",
                            type: "success",
                            zindex: 99999
                        });
                        clearModalMedioAlmacenamiento();
                        $("#modal_agregar_medio_almacenamiento").modal('hide');
                        getMediosAlmacenamiento(bodegaMedioAlmacenamientoAgregar.value, medioAlmacenamientoPadreAgregar.value);
                        $("#btn_guardar_unidad_almacenamiento-modal_agregar_medio_almacenamiento").html("<i class='fa fa-save'></i> Guardar");
                    } else {
                        notif({
                            type: "warning",
                            msg: "<b>Aviso: </b>No se ha podido registrar la Unidad de Almacenamiento!",
                            position: "right",
                            autohide: false,
                            zindex: 99999
                        });
                        $("#btn_guardar_unidad_almacenamiento-modal_agregar_medio_almacenamiento").html("<i class='fa fa-save'></i> Guardar");
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
        } else {
            $("#container_unidad_almacenamiento").fadeOut();
            $("#container_unidad_almacenamiento_charge").fadeIn();

            $.ajax({
                url: '/lista-bodegas/updateUnidadAlmacenamiento',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        notif({
                            msg: "<b>Correcto:</b> Unidad de Almacenamiento Modificada!",
                            type: "success",
                            zindex: 99999
                        });
                        clearModalMedioAlmacenamiento();
                        $("#modal_agregar_medio_almacenamiento").modal('hide');
                        getMediosAlmacenamiento(bodegaMedioAlmacenamientoAgregar.value, medioAlmacenamientoPadreAgregar.value);
                        $("#btn_guardar_unidad_almacenamiento-modal_agregar_medio_almacenamiento").html("<i class='fa fa-save'></i> Guardar");
                    } else {
                        notif({
                            type: "warning",
                            msg: "<b>Aviso: </b>No se ha podido modificar la Unidad de Almacenamiento!",
                            position: "right",
                            autohide: false,
                            zindex: 99999
                        });
                        $("#btn_guardar_unidad_almacenamiento-modal_agregar_medio_almacenamiento").html("<i class='fa fa-save'></i> Guardar");
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
    }
}

function clearModalMedioAlmacenamiento() {
    let codigoE = document.getElementById('txt_codigo-modal_agregar_medio_almacenamiento');
    let descripcionE = document.getElementById('txt_descripcion-modal_agregar_medio_almacenamiento');
    let estadoFechaE = document.getElementById('chk_estado_fechas-modal_agregar_medio_almacenamiento');
    let fechaInicioE = document.getElementById('fecha_inicio-modal_agregar_medio_almacenamiento');
    let fechaFinE = document.getElementById('fecha_final-modal_agregar_medio_almacenamiento');
    let btnDeleteImagenMedioAlmacenamiento = document.getElementById('btn_delete_image-modal_agregar_medio_almacenamiento');

    codigoE.value = "";
    descripcionE.value = "";
    estadoFechaE.checked = false;
    btnDeleteImagenMedioAlmacenamiento.dispatchEvent(new Event('click'));
    estadoFechaE.dispatchEvent(new Event('change'));
    clearDateFechas(fechaInicioE, fechaFinE);
}


btnDeleteMedioAlmacenamiento.addEventListener('click', () => {
    let token = $("#csrf-token-modal_confirm_delete_medio_almacenamiento").val();
    let id = $('#txt_id_delete_medio_almacenamiento').val();
    $("#container_unidad_almacenamiento").fadeOut();
    $("#container_unidad_almacenamiento_charge").fadeIn();
    $("#modal_confirm_delete_medio_almacenamiento").modal("hide");
    $.ajax({
        url: `/lista-bodegas/deleteUnidadAlmacenamiento/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b>Unidad de almacenamiento eliminada!",
                    type: "success",
                    zindex: 99999
                });
                let containerlista = listaMenuLateral.querySelector(`ul[data-id_padre="0"]`);
                containerlista.innerHTML = "";
                getMediosAlmacenamiento(bodegaMedioAlmacenamientoAgregar.value, medioAlmacenamientoPadreAgregar.value);
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar ela unidad de almacenamiento!",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
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

//Funciones para documentos
function getDocumentos(ma_id) {
    if (upload_archive) {
        tableDocumentos.style.display = "block";
        $("#container_unidad_almacenamiento_charge").fadeIn();
        $("#div_table_documentos_stored").fadeOut();
        $.ajax({
            url: `/lista-bodegas/getDocumentos/${ma_id}`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let html = configureTableHtml("table_documentos_stored",
                    ['#', 'UNIDAD PRODUCTORA', 'SERIE', 'DOCUMENTO', 'CÓDIGO', 'NRO FOLIOS', 'COMENTARIOS', 'CAMPOS', 'PDF', 'OPCIONES'],
                    ['d_id', 'cup_nombre', 'cups_nombre', 'cd_nombre', 'd_codigo', 'd_nro_folio', 'd_comentario',
                        {
                            align: 'center',
                            class: 'color-td',
                            functionValue: function (item) {
                                let value = '<p style="white-space: pre-line;">';
                                JSON.parse(item.campos_unidades).forEach(c => {
                                    value += `[${c.dc_nombre},${c.dc_valor}] \n`;
                                });
                                value += '</p>'
                                return value;
                            }
                        },
                        {
                            align: 'center',
                            class: 'color-td',
                            functionValue: function (item) {
                                let value = "";
                                if (item.d_ruta_archivo != "") {
                                    value = `<button type="button" onClick="view_documento_pdf('/lista-bodegas/getDocumento${item.d_ruta_archivo}')" class="tooltip"><i class="far fa-file-pdf tam-pdf"></i></button>'`;
                                }
                                return value;
                            }
                        },
                        {
                            align: 'center',
                            class: 'color-td',
                            functionValue: function (item) {
                                return `
                                <button type="button" class="tam-btn btn btn-warning btn-modal-editar" Onclick ='show_mod_documento(${item.d_id},${item.cup_id},${item.cups_id},${item.cd_id},"${item.d_codigo}",${item.d_nro_folio},"${item.d_comentario.replace(/(\r\n|\n|\r)/gm, "\\n")}","${item.d_nombre_archivo_original}","${item.d_ruta_archivo}",${JSON.stringify(JSON.parse(item.campos_unidades))})'><i class="fa fa-edit tam-icono"></i></button>
                                <button type="button" class="tam-btn btn btn-danger btn-modal-eliminar" Onclick ="show_delete_documento(${item.d_id})"><i class="fa fa-trash tam-icono"></i></button>
                                `;
                            }
                        },
                    ], response
                );

                $("#div_table_documentos_stored").html(html);

                $("#table_documentos_stored").DataTable({
                    "language": {
                        "emptyTable": "No existen documentos en este contenedor"
                    },
                    "searching": false,
                    "lengthChange": false,
                    "order": [[0, 'desc']]
                });

                $("#container_unidad_almacenamiento_charge").fadeOut();
                if (upload_archive) {
                    $("#div_table_documentos_stored").fadeIn();
                }

            }
        });
    } else {
        tableDocumentos.style.display = "none";
    }
}

function show_mod_documento(id, cup_id_r, cups_id_r, cd_id_r, d_codigo, d_nro_folio, d_comentario, d_nombre_archivo_original, d_ruta_archivo, campos) {
    let idE = document.getElementById('id_documento-modal_agregar_documento');
    let codigoE = document.getElementById('txt_codigo-modal_agregar_documento');
    let nroFolioE = document.getElementById('txt_nro_folio-modal_agregar_documento');
    let comentarioE = document.getElementById('txt_comentario-modal_agregar_documento');
    let divPdf = document.getElementById('pdf_preview-modal_agregar_documento');
    let inputFile = document.getElementById('file_pdf-modal_agregar_documento');
    let iframePDF = document.getElementById('iframe_pdf_preview-modal_agregar_documento');
    let deleteImagen = document.getElementById('btn_delete_imagen-modal_agregar_documento');
    clearModalDocumentos();
    idE.value = id;
    cup_id_doc_mod = cup_id_r;
    cups_id_doc_mod = cups_id_r;
    cd_id_doc_mod = cd_id_r;
    codigoE.value = d_codigo;
    nroFolioE.value = d_nro_folio;
    comentarioE.value = d_comentario;
    campos_documento = campos;
    accionDocumento.value = "MODIFICAR";

    getUnidadProductoraDoc(selectUnidadProductoraDocumento, cup_id);

    deleteImagen.dispatchEvent(new Event('click'));

    if (d_ruta_archivo == "") {
        divPdf.style.display = 'flex';
        iframePDF.style.display = 'none';
        deleteImagen.style.display = 'none';
    } else {
        divPdf.style.display = 'none';
        iframePDF.style.display = 'block';
        deleteImagen.style.display = 'inline-block';

        // Fetch para obtener el archivo PDF como Blob
        fetch(`/lista-bodegas/getDocumento${d_ruta_archivo}`)
            .then(response => response.blob())
            .then(blob => {
                // Crear un objeto File a partir del Blob
                let file = new File([blob], d_nombre_archivo_original, { type: "application/pdf" });

                // Crear un objeto DataTransfer para simular la selección del archivo
                let dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                // Establecer los archivos seleccionados en el input
                inputFile.files = dataTransfer.files;

                // Disparar el evento change en el input para simular la selección del archivo
                inputFile.dispatchEvent(new Event("change"));
            });
    }

    $("#modal_agregar_documento").modal("show");
}

function show_delete_documento(id) {
    $('#txt_id_delete_documento').val(id);
    $("#modal_confirm_delete_documento").modal("show");
}

deleteDocumentoModal.addEventListener('click', () => {
    let id = $('#txt_id_delete_documento').val();
    let token = $("#csrf-token-modal_confirm_delete_documento").val();
    $.ajax({
        url: `/lista-bodegas/deleteDocumento/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Documento Eliminado!",
                    type: "success",
                    zindex: 99999
                });
                $('#txt_id_delete_documento').val('');
                $("#modal_confirm_delete_documento").modal('hide');
                getDocumentos(idMedioAlmacenamientoDocumento.value);
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar el documento",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirm_delete_documento").modal('hide');
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

function view_documento_pdf(ruta) {
    let iframe = document.getElementById('iframe_documento_pdf');
    iframe.style.display = "none";
    iframe.src = ruta;
    $("#modal_view_pdf_certificado").modal("show");

    iframe.addEventListener('load', () => {
        iframe.style.display = "block";
    });
}

function getUnidadProductoraDoc(selectUnidadProductora, id) {
    $("#body_documento-modal_agregar_documento").fadeOut();
    $("#body_charge_documento-modal_agregar_documento").fadeIn();
    $("#footer_documento-modal_agregar_documento").fadeOut();
    $("#footer_charge_documento-modal_agregar_documento").fadeIn();
    $.ajax({
        url: `/lista-bodegas/getUnidadProductora/${id}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            selectUnidadProductora.setValueCombo(response, id);
            if (cup_id_doc_mod != 0)
                selectUnidadProductora.value = cup_id_doc_mod;
            selectUnidadProductora.dispatchEvent(new Event('change'));
        }
    });
}

function getUnidadProductoraDocumentoDoc(selectDocumento, id, cd_id) {
    $("#body_documento-modal_agregar_documento").fadeOut();
    $("#body_charge_documento-modal_agregar_documento").fadeIn();
    $("#footer_documento-modal_agregar_documento").fadeOut();
    $("#footer_charge_documento-modal_agregar_documento").fadeIn();
    $.ajax({
        url: `/lista-bodegas/getUnidadProductoraSerieDocumento/${id}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            selectDocumento.setValueCombo(cd_id == 0 ? response : response.filter(r => r.cd_id == cd_id), cd_id);
            selectDocumento.value = cd_id;
            if (cd_id_doc_mod != 0)
                selectDocumento.value = cd_id_doc_mod;
            if (selectDocumento.value == "")
                selectDocumento.value = cd_id;
            selectDocumento.dispatchEvent(new Event('change'));
        }
    });
}
selectUnidadProductoraDocumento.addEventListener('change', (e) => {
    let optionSelected = selectUnidadProductoraDocumento.querySelector(`option[value^="${e.target.value}"]`);
    let values = JSON.parse(optionSelected.dataset.serie);
    cup_codigo = optionSelected.dataset.codigo;
    selectUnidadProductoraSerieDocumento.setValueCombo(cups_id == 0 ? values : values.filter(v => v.cups_id == cups_id), cups_id);
    if (cups_id_doc_mod != 0)
        selectUnidadProductoraSerieDocumento.value = cups_id_doc_mod;
    if (selectUnidadProductoraSerieDocumento.value == "")
        selectUnidadProductoraSerieDocumento.value = cups_id;
    selectUnidadProductoraSerieDocumento.dispatchEvent(new Event('change'));
});

selectUnidadProductoraSerieDocumento.addEventListener('change', (e) => {
    getUnidadProductoraDocumentoDoc(selectConfiguracionDocumento, e.target.value, cd_id);
});

selectConfiguracionDocumento.addEventListener('change', (e) => {
    let codigo = document.getElementById('txt_codigo-modal_agregar_documento');
    if (accionDocumento.value == "AGREGAR")
        codigo.value = "";
    divCamposDocumento.innerHTML = "";
    let cont = 0;

    if (e.target.value != 0) {

        $.ajax({
            url: `/lista-bodegas/getUnidadProductoraDocumento/${e.target.value}`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let campos = JSON.parse(response.campos_unidades);
                campos.forEach(c => {
                    cont++;
                    let value = "";
                    let campoFind = campos_documento.find(d => d.dc_nombre == c.cdc_nombre);
                    if (campoFind)
                        value = campoFind.dc_valor;


                    if (c.cdc_tipo == "TEXTO") {
                        divCamposDocumento.innerHTML += `
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                ${c.cdc_nombre}
                            </label>
                            <div class="pos-relative">
                                <input class="form-control" type="text" id="campo_documento-modal_agregar_documento_${cont}" 
                                name="campo_texto" 
                                placeholder="INGRESE ${c.cdc_nombre}"
                                data-label="${c.cdc_nombre}"
                                data-nombre="${c.cdc_nombre}"
                                data-tipo="${c.cdc_tipo}"
                                value="${value}"
                                style="text-transform: uppercase;">
                                <span class="badge bg-danger" data-for="campo_documento-modal_agregar_documento_${cont}"></span>
                            </div>
                        </div>
                        `;
                    }
                    if (c.cdc_tipo == "AÑO") {
                        divCamposDocumento.innerHTML += `
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                ${c.cdc_nombre}
                            </label>
                            <div class="pos-relative">
                                <input class="form-control" type="text" id="campo_documento-modal_agregar_documento_${cont}" 
                                name="campo_texto"
                                data-label="${c.cdc_nombre}"
                                data-nombre="${c.cdc_nombre}"
                                data-tipo="${c.cdc_tipo}"
                                value="${value}"
                                placeholder="YYYY">
                                <span class="badge bg-danger" data-for="campo_documento-modal_agregar_documento_${cont}"></span>
                            </div>
                        </div>
                        `;
                    }

                    if (c.cdc_tipo == "MES/AÑO") {
                        divCamposDocumento.innerHTML += `
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                ${c.cdc_nombre}
                            </label>
                            <div class="pos-relative">
                                <input class="form-control" type="text" id="campo_documento-modal_agregar_documento_${cont}" data-label="${c.cdc_nombre}" name="campo_texto" data-nombre="${c.cdc_nombre}" data-tipo="${c.cdc_tipo}" placeholder="YYYY-MM" value="${value}">
                                <span class="badge bg-danger" data-for="campo_documento-modal_agregar_documento_${cont}"></span>
                            </div>
                        </div>
                        `;
                    }

                    if (c.cdc_tipo == "FECHA") {
                        divCamposDocumento.innerHTML += `
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                ${c.cdc_nombre}
                            </label>
                            <div class="pos-relative">
                                <input class="form-control" type="text" data-label="${c.cdc_nombre}" id="campo_documento-modal_agregar_documento_${cont}" name="campo_texto" data-nombre="${c.cdc_nombre}" data-tipo="${c.cdc_tipo}" placeholder="YYYY-MM-DD" value="${value}">
                                <span class="badge bg-danger" data-for="campo_documento-modal_agregar_documento_${cont}"></span>
                            </div>
                        </div>
                        `;
                    }

                });

                let textos = divCamposDocumento.querySelectorAll('input[data-tipo="TEXTO"]');
                textos.forEach(d => {
                    setInputValidations(`${d.id}`, ['notEmpty'], []);
                });

                let dates = divCamposDocumento.querySelectorAll('input[data-tipo="FECHA"]');
                dates.forEach(d => {
                    $(`#${d.id}`).bootstrapdatepicker({
                        format: "yyyy-mm-dd",
                        viewMode: "date",
                        multidate: false
                    });
                    setInputValidations(`${d.id}`, ['notEmpty'], []);
                });

                let dateAnios = divCamposDocumento.querySelectorAll('input[data-tipo="AÑO"]');
                dateAnios.forEach(d => {
                    $(`#${d.id}`).bootstrapdatepicker({
                        format: "yyyy",
                        viewMode: "year",
                        minViewMode: "years",
                        maxViewMode: "years",
                        multidate: false
                    });
                    setInputValidations(`${d.id}`, ['notEmpty'], []);
                });

                let dateMonths = divCamposDocumento.querySelectorAll('input[data-tipo="MES/AÑO"]');
                dateMonths.forEach(d => {
                    $(`#${d.id}`).bootstrapdatepicker({
                        format: "yyyy-mm",
                        viewMode: "months",
                        minViewMode: "months",
                        maxViewMode: "years",
                        multidate: false,
                    });
                    setInputValidations(`${d.id}`, ['notEmpty'], []);
                });

                $("#body_documento-modal_agregar_documento").fadeIn();
                $("#body_charge_documento-modal_agregar_documento").fadeOut();
                $("#footer_documento-modal_agregar_documento").fadeIn();
                $("#footer_charge_documento-modal_agregar_documento").fadeOut();
            }
        });
        getSecuencialMaxDocumento(idMedioAlmacenamientoDocumento.value);
    } else {
        $("#body_documento-modal_agregar_documento").fadeIn();
        $("#body_charge_documento-modal_agregar_documento").fadeOut();
        $("#footer_documento-modal_agregar_documento").fadeIn();
        $("#footer_charge_documento-modal_agregar_documento").fadeOut();
    }
});

function clearModalDocumentos() {
    let codigoE = document.getElementById('txt_codigo-modal_agregar_documento');
    let nroFolioE = document.getElementById('txt_nro_folio-modal_agregar_documento');
    let comentarioE = document.getElementById('txt_comentario-modal_agregar_documento');

    let btnDeleteImagenMedioAlmacenamiento = document.getElementById('btn_delete_imagen-modal_agregar_documento');
    btnDeleteImagenMedioAlmacenamiento.dispatchEvent(new Event('click'));

    codigoE.value = "";
    nroFolioE.value = "1";
    comentarioE.value = "";
    divCamposDocumento.innerHTML = "";
}

function agregarDocumento() {
    let codigoE = document.getElementById('txt_codigo-modal_agregar_documento');
    let nroFolioE = document.getElementById('txt_nro_folio-modal_agregar_documento');
    let inputsCampos = divCamposDocumento.querySelectorAll('input[id^="campo_documento-modal_agregar_documento_"]');
    let camposDocumentos = [];

    let errores = "";

    errores += selectUnidadProductoraDocumento.validateInput();
    errores += selectUnidadProductoraSerieDocumento.validateInput();
    errores += selectConfiguracionDocumento.validateInput();
    errores += codigoE.validateInput();
    errores += nroFolioE.validateInput();

    inputsCampos.forEach(i => {
        errores += i.validateInput();
        camposDocumentos.push({
            nombre: i.dataset.nombre,
            tipo: i.dataset.tipo,
            valor: i.value.toUpperCase()
        });
    });

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede registrar el documento, favor verifique los datos ingresados",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $("#btn_guardar_documento-modal_agregar_documento").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");

        let token = $("#csrf-token-modal_agregar_documento").val();
        let datos = new FormData($("#form_agregar_documento")[0]);
        datos.append('campos', JSON.stringify(camposDocumentos));
        if (accionDocumento.value == "AGREGAR") {
            //$("#container_unidad_almacenamiento").fadeOut();
            //$("#container_unidad_almacenamiento_charge").fadeIn();
            $.ajax({
                url: '/lista-bodegas/storeDocumento',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        notif({
                            msg: "<b>Correcto:</b> Documento Registrado!",
                            type: "success",
                            zindex: 99999
                        });
                        $("#modal_agregar_documento").modal('hide');
                        getDocumentos(idMedioAlmacenamientoDocumento.value);
                        clearModalDocumentos();
                        cup_id_doc_mod = 0;
                        cups_id_doc_mod = 0;
                        cd_id_doc_mod = 0;
                        $("#btn_guardar_documento-modal_agregar_documento").html("<i class='fa fa-save'></i> Guardar");
                    } else {
                        notif({
                            type: "warning",
                            msg: "<b>Aviso: </b>No se ha podido registrar el documento!",
                            position: "right",
                            autohide: false,
                            zindex: 99999
                        });
                        $("#btn_guardar_unidad_almacenamiento-modal_agregar_medio_almacenamiento").html("<i class='fa fa-save'></i> Guardar");
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
        } else {
            //$("#container_unidad_almacenamiento").fadeOut();
            //$("#container_unidad_almacenamiento_charge").fadeIn();

            $.ajax({
                url: '/lista-bodegas/updateDocumento',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        notif({
                            msg: "<b>Correcto:</b> Documento Actualizado!",
                            type: "success",
                            zindex: 99999
                        });
                        $("#modal_agregar_documento").modal('hide');
                        getDocumentos(idMedioAlmacenamientoDocumento.value);
                        clearModalDocumentos();
                        cup_id_doc_mod = 0;
                        cups_id_doc_mod = 0;
                        cd_id_doc_mod = 0;
                        $("#btn_guardar_documento-modal_agregar_documento").html("<i class='fa fa-save'></i> Guardar");
                    } else {
                        notif({
                            type: "warning",
                            msg: "<b>Aviso: </b>No se ha podido actualizar el documento!",
                            position: "right",
                            autohide: false,
                            zindex: 99999
                        });
                        $("#btn_guardar_unidad_almacenamiento-modal_agregar_medio_almacenamiento").html("<i class='fa fa-save'></i> Guardar");
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
    }
}

function getSecuencialMaxDocumento(ma_id) {
    if (accionDocumento.value == "AGREGAR") {
        $("#body_documento-modal_agregar_documento").fadeOut();
        $("#body_charge_documento-modal_agregar_documento").fadeIn();
        $("#footer_documento-modal_agregar_documento").fadeOut();
        $("#footer_charge_documento-modal_agregar_documento").fadeIn();
        $.ajax({
            url: `/lista-bodegas/getSecuencialMaxDocumento/${selectConfiguracionDocumento.value}`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let acronimo_institucion = document.getElementById('acronimo_institucion');
                let codigo = document.getElementById('txt_codigo-modal_agregar_documento');
                let option = selectConfiguracionDocumento.querySelector(`option[value="${selectConfiguracionDocumento.value}"]`);
                codigo.value = `${acronimo_institucion.value}${cup_codigo == "" ? "" : "-"}${cup_codigo}-${response.anio_actual}-${response.siguiente_secuencial.toString().padStart(3, '0')}${option.dataset.codigo == "" ? "" : "-"}${option.dataset.codigo}`;
                $("#body_documento-modal_agregar_documento").fadeIn();
                $("#body_charge_documento-modal_agregar_documento").fadeOut();
                $("#footer_documento-modal_agregar_documento").fadeIn();
                $("#footer_charge_documento-modal_agregar_documento").fadeOut();
            }
        });
    }
}