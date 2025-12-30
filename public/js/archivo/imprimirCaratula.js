let listaMenuLateral = document.getElementById('lista_archivos_lateral');//Listado de arbol para los contenedores o medios de almacenamiento
let bodegaBadge = document.getElementById('bodega_badge');//Item principal del menu lateral
let bodegaId = document.getElementById('id_bodega');
let btnGenerarCaratula = document.getElementById('btn_generar_caratula');
let iframeCaratula = document.getElementById('iframe_generate_caratula');
let selectCaratula = document.getElementById('tipo_caratura');

let listMediosAlmacenamiento = []; //Lista completa de los medios de almacenamiento

$(document).ready(function () {
    getMediosAlmacenamiento(bodegaId.value, 0);
});

function getMediosAlmacenamiento(idBodega, idPadre) {
    $.ajax({
        url: `/lista-bodegas/get_medios_almacenamiento/0/${idBodega}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            listMediosAlmacenamiento = response;
            cargarMenuLateral(listMediosAlmacenamiento);
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
                <p class="menu-list__li" 
                data-ma_id="${h.ma_id}">
                    <span class="expandButtonMedio" 
                        data-ma_id="${h.ma_id}">
                        <i class="fa fa-angle-right"></i> 
                            <i class="${h.cma_icono}"></i></span> ${h.cma_tipo}(${h.ma_codigo}) 
                            <input type="checkbox" id="check_${h.ma_id}" data-ma_id="${h.ma_id}" name="check_${h.ma_id}" value="${h.ma_id}">
                </p>
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
        });
    });
}

btnGenerarCaratula.addEventListener('click', () => {
    let checkboxList = listaMenuLateral.querySelectorAll('input[type="checkbox"][data-ma_id]');
    let ListCaratulas = "";
    checkboxList.forEach(c => {
        if (c.checked)
            ListCaratulas += `${c.dataset.ma_id},`;
    });

    if (ListCaratulas == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Debe seleccionar al menos un medio de almacenamiento de la lista",
            position: "right",
            autohide: true,
            zindex: 99999
        });
        return;
    }

    $("#iframe_generate_caratula").hide();
    $("#iframe_generate_caratula_charge").show();

    ListCaratulas = ListCaratulas.slice(0, -1);

    let token = $('#csrf_token').val();

    fetch('/imprimir_caratula_archivo/generatePDF', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            tipoCaratula: selectCaratula.value,
            medios_almacenamiento: ListCaratulas
        }),
    })
        .then(response => {
            // Verificar si la respuesta es exitosa (código 200)
            if (!response.ok) {
                throw new Error('Hubo un problema al descargar el PDF.');
            }
            // Devolver la respuesta como un Blob (archivo)
            return response.blob();
        })
        .then(blob => {
            // Crear una URL para el archivo Blob
            const url = URL.createObjectURL(blob);
            // Abrir la URL en una nueva ventana o iframe
            iframeCaratula.src = url;
            $("#iframe_generate_caratula").show();
            $("#iframe_generate_caratula_charge").hide();
        })
        .catch(error => {
            // Manejar cualquier error que pueda ocurrir durante la solicitud
            console.error('Error:', error);
        });
});