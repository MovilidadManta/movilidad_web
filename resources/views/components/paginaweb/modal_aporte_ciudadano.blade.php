<div class="modal" id="modal_aporte_ciudadano">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">INGRESO DE APORTE CIUDADANO</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token-modal_aporte_ciudadano">
                <form class="form" novalidate id="form_modal_aporte_ciudadano" method="POST" enctype="multipart/form-data">
                    <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block bus-emp-bo">
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                APELLIDOS Y NOMBRES
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="txt_apellidos_nombres" 
                                name="txt_apellidos_nombres" 
                                placeholder="INGRESAR APELLIDOS Y NOMBRES"
                                data-label='Apellidos y Nombres'
                                style="text-transform: uppercase;">
                                <span class="badge bg-danger" data-for="txt_apellidos_nombres"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                CÉDULA DE CIUDADANIA
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="txt_cedula" 
                                name="txt_cedula" 
                                placeholder="INGRESE CÉDULA DE CIUDADANIA"
                                data-label='Cédula de ciudadania'
                                style="text-transform: uppercase;">
                                <span class="badge bg-danger" data-for="txt_cedula"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                ORGANIZACION A LA QUE REPRESENTA
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="txt_organizacion_representa" 
                                name="txt_organizacion_representa" 
                                placeholder="INGRESE ORGANIZACIÓN A LA QUE REPRESENTA"
                                data-label='Organización a la que representa'
                                style="text-transform: uppercase;">
                                <span class="badge bg-danger" data-for="txt_organizacion_representa"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                DIRECCIÓN DOMICILIARIA
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="txt_direccion_domiciliaria" 
                                name="txt_direccion_domiciliaria" 
                                placeholder="DIRECCIÓN DOMICILIARIA"
                                data-label='Dirección Domiciliaria'
                                style="text-transform: uppercase;">
                                <span class="badge bg-danger" data-for="txt_direccion_domiciliaria"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                DIRECCIÓN CORREO ELECTRONICO
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="email" id="txt_correo_electronico" 
                                name="txt_correo_electronico" 
                                placeholder="Correo eletronico"
                                data-label='Correo electronico'>
                                <span class="badge bg-danger" data-for="txt_correo_electronico"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                NÚMERO CELULAR
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="txt_celular" 
                                name="txt_celular" 
                                placeholder="NÚMERO DE CELULAR"
                                data-label='Número de celular'
                                style="text-transform: uppercase;">
                                <span class="badge bg-danger" data-for="txt_celular"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                APORTE CIUDADANO
                            </label>
                            <div class="pos-relative">
                                <textarea class="form-control" 
                                placeholder="INGRESE SU APORTE CIUDADANO"
                                data-label='Aporte ciudadano'
                                name="txt_aporte_ciudadano" 
                                id="txt_aporte_ciudadano" 
                                rows="3"
                                style="text-transform: uppercase;"
                                ></textarea>
                                <span class="badge bg-danger" data-for="txt_aporte_ciudadano"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="btn_guardar_aporte_ciudadano" type="button"><i class="fa fa-paper-plane"></i> Enviar</button>
                <button class="btn btn-light" data-bs-dismiss="modal" type="button"><i class="fa fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>