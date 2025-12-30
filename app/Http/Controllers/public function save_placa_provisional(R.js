public function save_placa_provisional(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $data_json =  $request->data;
        $json[] = [
            'placa' => $data_json['data']['placaActual'],
            'nombre_propietario' => $data_json['data']['propietario'],
            'cedula_propietario' => $data_json['data']['docPropietario']
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql')->Select('select public.procedimiento_registrar_datos_placas_provisionales(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_placas_provisionales;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => true, "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }


    function guardar_placa_provisional() {
    /*$(data_json).each(function (i, data) {
        console.log(data.identBenef)
        alert(data.identBenef)
    })*/
    placa = $("#txt-placa").val()

    var token = $("#csrf-token").val();
    $.ajax({
        url: '/save-placa-provisional',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        data: {
            'data': data_json,
            'placa': placa
        },
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                notif({
                    msg: "<b>Correcto:</b>Placa provisional registrada",
                    type: "success"
                });
                Swal.fire({
                    title: "Correcto!",
                    text: "Placa provisional generada correctamente!",
                    icon: "success"
                });
                location.href = '/imprimir-vehiculo-placa-provisional/' + placa
                $("#btn-guardar-campo-tipo-permiso").html("<i class='fa fa-plus-square color-btn-nuevo'></i><strong class='color-btn-nuevo'> Añadir</strong>")
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