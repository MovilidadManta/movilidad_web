//INICIO LOGIN DE API
function login() {

    const data = {
        "username": 'MOVWS',
        "password": 'M0vilid@d!'
    };


    $.ajax({
        url: 'https://api.movilidadmanta.gob.ec:8015/api/v1/login',
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json', // Asegúrate de que Content-Type esté correctamente configurado
        data: JSON.stringify(data), // Usamos 'data' en lugar de 'body'
        success: function (response) {
            if (response.message === "OK") {
                //Si recibo el token lo guardo en memoria en este caso el local storage
                localStorage.setItem("authToken", response.data.token);
                //ahora solo me queda comprobar cada cierto tiempo si es token cambia
                setTimeout(comprobarToken, 60 * 1000);
            }
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        // Manejo de errores
        if (jqXHR.status === 0) {
            alert('Not connect: Verify Network.');
        } else if (jqXHR.status === 404) {
            alert('Requested page not found [404]');
        } else if (jqXHR.status === 500) {
            alert('Internal Server Error [500]. Intente nuevamente');
        } else if (textStatus === 'timeout') {
            alert('Time out error.');
        } else if (textStatus === 'abort') {
            alert('Ajax request aborted.');
        } else {
            alert('Error: ' + textStatus); // Manejo de otros posibles errores
        }
    });
}
//FIN LOGIN DE API

//INICIO COMPROBAR TOKEN DE API
function comprobarToken() {
    const savedToken = localStorage.getItem("authToken");

    const url = "https://api.movilidadmanta.gob.ec:8015/api/v1/verify";
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${savedToken}`
    };

    const data = {}; // Los datos que enviarás

    // Realizar la solicitud con AJAX (jQuery)
    $.ajax({
        url: url,
        type: 'POST',
        headers: headers,
        data: JSON.stringify(data), // Convierte el objeto a JSON
        contentType: 'application/json',
        success: function (response) {
            console.log(response);
            // Solo si devuelve un nuevo token lo actualizo
            if (response.new_token) {
                token.value = response.new_token;
                localStorage.setItem("authToken", response.new_token);
            }
            setTimeout(comprobarToken, 60 * 1000); // Cada 60 segundos
        },
        error: function (xhr, status, error) {
            // Manejo de errores
            if (xhr.status === 0) {
                alert('Not connect: Verify Network.');
            } else if (xhr.status === 404) {
                alert('Requested page not found [404]');
            } else if (xhr.status === 500) {
                alert('Internal Server Error [500]. Intente nuevamente');
            } else {
                alert(`Error: ${xhr.responseText}`);
            }
        }
    });

}
//FIN COMPROBAR TOKEN DE API

export { login };