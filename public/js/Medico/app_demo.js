function _AJAX_(ruta, tipo, token, datos, p) {
    if (tipo == "POST") {
        $.ajax({
            url: ruta,
            type: tipo,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": token,
            },
            data: datos,
            success: function (res) {
                if (p == 0) {
                    if (res.respuesta) {
                        _AJAX_("/GET_tipos_enf", "GET", "", "", 0);
                        notif({
                            msg: "<b>Correcto:</b> La categoria se creo de manera correcta!",
                            type: "success",
                        });
                        onload_btn("btn_add", "Guardar categoria");
                        $("#ip_categoria").val("");
                        close_modal("modal-create");
                    }
                } else if (p == 1) {
                    if (res.res) {
                        _AJAX_("/GET_tipos_enf", "GET", "", "", 0);
                        notif({
                            msg: "<b>Correcto:</b> La categoria elimino manera correcta!",
                            type: "success",
                        });
                        onload_btn("btn_delete", "Si, eliminar!");
                        $("#ip_id_ca").val("");
                        close_modal("modal-delete");
                    }
                } else if (p == 2) {
                    if (res.res) {
                        _AJAX_("/GET_tipos_enf", "GET", "", "", 0);
                        notif({
                            msg: "<b>Correcto:</b> La categoria se actualizo de manera correcta!",
                            type: "success",
                        });
                        onload_btn("btn_edit", "Editar categoria");
                        $("#ip_idcate").val("");
                        $("#categoria").val("");
                        close_modal("modal-edit");
                    }
                } else if (p == 3) {
                    _AJAX_("/GET_enf", "GET", "", "", 1);
                    notif({
                        msg: "<b>Correcto:</b> Dato guardado de manera correcta!",
                        type: "success",
                    });
                    onload_btn("btn_add", "Guardar enfermedad");
                    $("#cmb_categoria").val(0);
                    $("#ip_enfermedad").val("");
                    close_modal("modal-create");
                }else if(p==4){
                    //console.log(res.data);
                    onload_btn("btn_buscar_p", '<i class="fa-solid fa-hospital-user"></i> Buscar paciente');
                    if(res.respuesta){  
                        let html =''
                        $(res.data).each(function (i, data) {
                            html += '<tr>'
                            html += '<td>'+data.emp_nombre+'</td>'
                            html += '<td>'+data.emp_apellido+'</td>'
                            html += '<td>'+data.per_perfil+'</td>'
                            html += '<td>'+data.ca_cargo+'</td>'
                            html += '<td>'+data.correo+'</td>'
                            html += '<td name="bstable-actions"><div class="btn-list">'
                            html += '<a  href="consulta/'+data.emp_cedula+'" id="bEdit" type="button" class="btn btn-sm btn-primary"><i class="fa-solid fa-hand-holding-medical"></i> Atender</a>'
                         //   html += '<button id="bDel" type="button" class="btn  btn-sm btn-danger"><span class="fe fe-trash-2"> </span></button>'
                            /*    <button id="bAcep" type="button" class="btn  btn-sm btn-primary">
                                    <span class="fe fe-check-circle"> </span>
                                </button>
                                <button id="bCanc" type="button" class="btn  btn-sm btn-danger" style="display:none;">
                                    <span class="fe fe-x-circle"> </span>
                                </button>
                            </div>*/
                            html +='</td></tr>'
                        })
               
                        $("#tpaciente").html(html);
                    }

                }
            },
        }).fail(function (jqXHR, textStatus, errorthrown) {
            if (jqXHR.status === 0) {
                alert("Not connect: Verify Network.");
            } else if (jqXHR.status == 404) {
                alert("Requested page not found [404]");
            } else if (jqXHR.status == 500) {
                alert("Internal Server Error [500].");
            } else if (textStatus === "parsererror") {
                alert("Requested JSON parse failed.");
            } else if (textStatus === "timeout") {
                alert("Time out error.");
            } else if (textStatus === "abort") {
                alert("Ajax request aborted.");
            } else {
                alert("Uncaught Error: " + jqXHR.responseText);
            }
        });
    } else if (tipo == "GET") {
        $.ajax({
            url: ruta,
            type: tipo,
            dataType: "json",
            success: function (res) {
                let html_ = "";

                if (p == 0) {
                    if (res.respuesta == true) {
                        var ht = "";
                        ht +=
                            '  <table id="table_re" border="2" class="table dataTable no-footer">';
                        ht += '	    <thead class="background-thead">';
                        ht += '		    <tr align="center">';
                        ht +=
                            '				<th align="center" class="border-bottom-0 color-th">ID</th>';
                        ht +=
                            '			    <th align="center" class="border-bottom-0 color-th">CATEGORIA</th>';
                        ht +=
                            '			    <th align="center" class="border-bottom-0 color-th">ESTADO</th>';
                        ht +=
                            '			    <th align="center" class="border-bottom-0 color-th">OPCION</th>';
                        ht += "			</tr>";
                        ht += "		</thead>";
                        ht += "		<tbody>";
                        $(res.data).each(function (i, data) {
                            ht += "			<tr>";
                            ht +=
                                '			    <td class="color-td" align="center">' +
                                data.id +
                                "</td>";
                            ht +=
                                '				<td class="color-td" align="center">' +
                                data.categoria +
                                "</td>";
                            if (data.estado) {
                                ht +=
                                    '<td class="color-td" align="center"><span class="badge bg-success me-1">Activo</span></td>';
                            } else {
                                ht +=
                                    '<td class="color-td" align="center"><span class="badge bg-danger me-1">Inactivo</span></td>';
                            }

                            if (data.estado) {
                                let cat = "'" + data.categoria + "'";
                                ht +=
                                    ' <td><a href="javascript:void(0)" onclick="editar_data(' +
                                    data.id +
                                    "," +
                                    cat +
                                    ')"><i class="fa fa-edit"></i> Editar</a>';
                                ht +=
                                    '<a href="javascript:void(0)" onclick="delete_data(' +
                                    data.id +
                                    "," +
                                    cat +
                                    ')"><i class="fa fa-trash-o"></i> Eliminar</a></td>';
                            } else {
                                ht +=
                                    ' <td> <a href="#"><i class="fa fa-reply" aria-hidden="true"></i> recuperar</a></td>';
                            }

                            ht += "	</tr>";
                        });
                        ht += "		</tbody>";
                        ht += "  </table>";
                        $("#div-table").html(ht);
                    }
                    table_responsive("#table_re");
                } else if (p == 1) {
                    if (res.respuesta == true) {
                        var ht = "";
                        ht +=
                            '  <table id="table_re" border="2" class="table dataTable no-footer">';
                        ht += '	    <thead class="background-thead">';
                        ht += '		    <tr align="center">';
                        ht +=
                            '				<th align="center" class="border-bottom-0 color-th">ID</th>';
                        ht +=
                            '			    <th align="center" class="border-bottom-0 color-th">CATEGORIA</th>';
                        ht +=
                            '			    <th align="center" class="border-bottom-0 color-th">ENFERMEDAD</th>';
                        ht +=
                            '			    <th align="center" class="border-bottom-0 color-th">ESTADO</th>';
                        ht +=
                            '			    <th align="center" class="border-bottom-0 color-th">OPCION</th>';
                        ht += "			</tr>";
                        ht += "		</thead>";
                        ht += "		<tbody>";
                        $(res.data).each(function (i, data) {
                            ht += "			<tr>";
                            ht +=
                                '			    <td class="color-td" align="center">' +
                                data.id +
                                "</td>";
                            ht +=
                                '				<td class="color-td" align="center">' +
                                data.id_categoria +
                                "</td>";
                            ht +=
                                '				<td class="color-td" align="center">' +
                                data.enfermedad +
                                "</td>";
                            if (data.estado) {
                                ht +=
                                    '<td class="color-td" align="center"><span class="badge bg-success me-1">Activo</span></td>';
                            } else {
                                ht +=
                                    '<td class="color-td" align="center"><span class="badge bg-danger me-1">Inactivo</span></td>';
                            }

                            if (data.estado) {
                                let enf = "'" + data.enfermedad + "'";
                                ht +=
                                    ' <td><a href="javascript:void(0)" onclick="editar_enfermedad(' +
                                    data.id +
                                    "," +
                                    enf +
                                    ')"><i class="fa fa-edit"></i> Editar</a>';
                                ht +=
                                    '<a href="javascript:void(0)" onclick="delete_enfermedad(' +
                                    data.id +
                                    "," +
                                    enf +
                                    ')"><i class="fa fa-trash-o"></i> Eliminar</a></td>';
                            } else {
                                ht +=
                                    ' <td> <a href="#"><i class="fa fa-reply" aria-hidden="true"></i> recuperar</a></td>';
                            }

                            ht += "	</tr>";
                        });
                        ht += "		</tbody>";
                        ht += "  </table>";
                        $("#div-table").html(ht);
                    }
                    table_responsive("#table_re");
                } 
            },
        }).fail(function (jqXHR, textStatus, errorthrown) {
            $("#btn_add").html(
                '<i class="fa fa-plus-square color-btn-nuevo"></i><strong class="color-btn-nuevo">Añadir</strong>'
            );
            $("#btn_add").removeClass("disable_a");
            $("#load_m").hide();
            if (jqXHR.status === 0) {
                alert("Not connect: Verify Network.");
            } else if (jqXHR.status == 404) {
                alert("Requested page not found [404]");
            } else if (jqXHR.status == 500) {
                alert("Internal Server Error [500].");
            } else if (textStatus === "parsererror") {
                alert("Requested JSON parse failed.");
            } else if (textStatus === "timeout") {
                alert("Time out error.");
            } else if (textStatus === "abort") {
                alert("Ajax request aborted.");
            } else {
                alert("Uncaught Error: " + jqXHR.responseText);
            }
        });
    }
}
const table_responsive = (tabla) => {
    $(tabla).DataTable();
};
const load_btn = (btn) => {
    $("#" + btn).attr("disabled", true);
    $("#" + btn).html(
        "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span> Espere por favor..</span>"
    );
};

const onload_btn = (btn, text) => {
    $("#" + btn).html(text);
    $("#" + btn).removeAttr("disabled");
};

const open_modal = (modal) => {
    $("#" + modal).modal("show");
};

const close_modal = (modal) => {
    $("#" + modal).modal("hide");
};
const alert_error = () => {
    Toastify({
        text: "El campo categoria se encuentra vacio!",
        style: {
            background: "linear-gradient(to right, #F44336, #d31b0e)",
        },
        offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 10, // vertical axis - can be a number or a string indicating unity. eg: '2em'
        },
    }).showToast();
};
