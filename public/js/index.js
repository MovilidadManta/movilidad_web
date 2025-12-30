let btnAporteCiudadano = document.getElementById('btn-enviar-solicitud-lotaip');
let btnGuardarAporte = document.getElementById('btn_guardar_aporte_ciudadano');

$(document).ready(function () {
    setInputValidations('txt_apellidos_nombres', ['notEmpty'], []);
    setInputValidations('txt_cedula', ['notEmpty'], []);
    set_type_input('txt_cedula', 'number');
    setInputValidations('txt_organizacion_representa', ['notEmpty'], []);
    setInputValidations('txt_direccion_domiciliaria', ['notEmpty'], []);
    setInputValidations('txt_correo_electronico', ['notEmpty'], [{
        function: function (item) {
            return !item.value.match(
                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            );
        },
        message: "Correo electronico no es valido"
    }]);
    setInputValidations('txt_celular', ['notEmpty'], []);
    setInputValidations('txt_aporte_ciudadano', ['notEmpty'], []);
});

btnGuardarAporte.addEventListener('click', () => {
    let apellidosNombresE = document.getElementById('txt_apellidos_nombres');
    let cedulaE = document.getElementById('txt_cedula');
    let organizacionRepresentaE = document.getElementById('txt_organizacion_representa');
    let direccionDomiciliariaE = document.getElementById('txt_direccion_domiciliaria');
    let correoElectronicoE = document.getElementById('txt_correo_electronico');
    let celularE = document.getElementById('txt_celular');
    let aporteCiudadanoE = document.getElementById('txt_aporte_ciudadano');

    let errores = "";

    errores += apellidosNombresE.validateInput();
    errores += cedulaE.validateInput();
    errores += organizacionRepresentaE.validateInput();
    errores += direccionDomiciliariaE.validateInput();
    errores += correoElectronicoE.validateInput();
    errores += celularE.validateInput();
    errores += aporteCiudadanoE.validateInput();

    if (errores.trim() != "") {
        Swal.fire(
            "Alerta!",
            "No se puede registrar su aporte, favor verifique el formulario",
            "error"
        );
    } else {
        let token = $("#csrf-token-modal_aporte_ciudadano").val();
        let datos = new FormData($("#form_modal_aporte_ciudadano")[0]);

        $("#modal_aporte_ciudadano").modal('hide');

        $.ajax({
            url: '/aporte_ciudadano/store',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    Swal.fire(
                        "Mensaje!",
                        "Se registro su aporte ciudadano correctamente!",
                        "success"
                    );
                    clearModalMedioAlmacenamiento();
                    $("#modal_agregar_medio_almacenamiento").modal('hide');
                    apellidosNombresE.value = "";
                    cedulaE.value = "";
                    organizacionRepresentaE.value = "";
                    direccionDomiciliariaE.value = "";
                    correoElectronicoE.value = "";
                    celularE.value = "";
                    aporteCiudadanoE.value = "";
                } else {
                    Swal.fire(
                        "Alerta!",
                        "No se puede registrar su aporte ciudadano!",
                        "error"
                    );
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
});

btnAporteCiudadano.addEventListener('click', () => {
    $("#modal_aporte_ciudadano").modal("show");
});