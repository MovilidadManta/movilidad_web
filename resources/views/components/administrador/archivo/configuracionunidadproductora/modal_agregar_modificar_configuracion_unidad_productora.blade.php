<div class="modal" id="{{$idModalConfiguracionUnidadProductora}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{$titulo}}</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token-{{$idModalConfiguracionUnidadProductora}}">
                <form class="form" novalidate id="{{$idFormModalConfiguracionUnidadProductora}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id_configuracion_unidad_productora-{{$idModalConfiguracionUnidadProductora}}" name="id">
                    <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block bus-emp-bo">
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                Nombre
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="txt_nombre-{{$idModalConfiguracionUnidadProductora}}" 
                                name="txt_nombre" 
                                placeholder="INGRESE NOMBRE DE LA UNIDAD PRODUCTORA"
                                data-label='Nombre'
                                style="text-transform: uppercase;">
                                <span class="badge bg-danger" data-for="txt_nombre-{{$idModalConfiguracionUnidadProductora}}"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                Código
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="txt_codigo-{{$idModalConfiguracionUnidadProductora}}" 
                                name="txt_codigo" 
                                placeholder="INGRESE CÓDIGO DE LA UNIDAD PRODUCTORA"
                                data-label='Código'
                                style="text-transform: uppercase;">
                                <span class="badge bg-danger" data-for="txt_codigo-{{$idModalConfiguracionUnidadProductora}}"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                DESCRIPCIÓN
                            </label>
                            <div class="pos-relative">
                                <textarea class="form-control" 
                                placeholder="INGRESE LA DESCRIPCIÓN DE LA UNIDAD PRODUCTORA"
                                data-label='Descripción'
                                name="txt_descripcion" 
                                id="txt_descripcion-{{$idModalConfiguracionUnidadProductora}}" 
                                rows="3"
                                style="text-transform: uppercase;"
                                ></textarea>
                                <span class="badge bg-danger" data-for="txt_descripcion-{{$idModalConfiguracionUnidadProductora}}"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <strong>Series</strong>
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <input class="form-control pd-r-80" type="text" id="txt_nombre_serie-{{$idModalConfiguracionUnidadProductora}}" 
                                    name="txt_nombre_serie" 
                                    placeholder="INGRESE NOMBRE DE LA SERIE"
                                    data-label='Nombre de Serie'
                                    style="text-transform: uppercase;">
                                    <span class="badge bg-danger" data-for="txt_nombre_serie-{{$idModalConfiguracionUnidadProductora}}"></span>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <input class="form-control pd-r-80" type="text" id="txt_codigo_serie-{{$idModalConfiguracionUnidadProductora}}" 
                                    name="txt_codigo_serie" 
                                    placeholder="INGRESE CÓDIGO DE LA SERIE"
                                    data-label='Código de Serie'
                                    style="text-transform: uppercase;">
                                    <span class="badge bg-danger" data-for="txt_codigo_serie-{{$idModalConfiguracionUnidadProductora}}"></span>
                                </div>
                                <div class="col-xs-12 mt-3">
                                    <textarea class="form-control" 
                                    placeholder="INGRESE LA DESCRIPCIÓN DE LA SERIE"
                                    data-label='Descripción de Serie'
                                    name="txt_descripcion_serie" 
                                    id="txt_descripcion_serie-{{$idModalConfiguracionUnidadProductora}}" 
                                    rows="3"
                                    style="text-transform: uppercase;"
                                    ></textarea>
                                    <span class="badge bg-danger" data-for="txt_descripcion_serie-{{$idModalConfiguracionUnidadProductora}}"></span>
                                </div>
                                <div class="col-xs-12 mt-3">
                                    <button class="btn background-btn-nuevo pad-nu w-100" id="btn_guardar_unidad_productora_serie-{{$idModalConfiguracionUnidadProductora}}">
                                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                                        <strong class="color-btn-nuevo" id="text_btn_añadir_unidad_productora_serie-{{$idModalConfiguracionUnidadProductora}}">Añadir</strong>
                                    </button>
                                </div>
                                <div class="mg-t-30" id="div_table_unidad_productora_serie-{{$idModalConfiguracionUnidadProductora}}">
                                    <table border="2" class="table">
                                        <thead class="background-thead">
                                            <tr align="center">
                                                <th align="center" class="border-bottom-0 color-th">Nombre</th>
                                                <th align="center" class="border-bottom-0 color-th">Código</th>
                                                <th align="center" class="border-bottom-0 color-th">Descripción</th>
                                                <th align="center" class="border-bottom-0 color-th">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_unidad_productora_serie-{{$idModalConfiguracionUnidadProductora}}" data-id='0'>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-switch">
                                <div style="margin-left: 35px;">
                                    <input class="form-check-input" type="checkbox" id="chk_estado-{{$idModalConfiguracionUnidadProductora}}" name="check_estado" checked>
                                    <label for="">Estado: <span id="text_check_estado-{{$idModalConfiguracionUnidadProductora}}">Activo</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_configuracion_unidad_productora-{{$idModalConfiguracionUnidadProductora}}" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", function (event) {
        let checkEstado = document.getElementById('chk_estado-{{$idModalConfiguracionUnidadProductora}}');
        let textCheckEstado = document.getElementById('text_check_estado-{{$idModalConfiguracionUnidadProductora}}');
        checkEstado.addEventListener('change', (e)=>{
            textCheckEstado.innerHTML = "Inactivo";
            if(e.target.checked)
                textCheckEstado.innerHTML = "Activo";
        });
    });
</script>