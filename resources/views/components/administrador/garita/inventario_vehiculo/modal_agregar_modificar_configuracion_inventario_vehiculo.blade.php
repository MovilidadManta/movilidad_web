<div class="modal" id="{{$idModalConfiguracionInventarioVehiculo}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{$titulo}}</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf_token_{{$idModalConfiguracionInventarioVehiculo}}">
                <form class="form" novalidate id="{{$idFormModalConfiguracionInventarioVehiculo}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id_inventario_vehiculo-{{$idModalConfiguracionInventarioVehiculo}}" name="id">
                    <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block bus-emp-bo">
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600" for="txt_titulo-{{$idModalConfiguracionInventarioVehiculo}}">
                                Titulo
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="txt_titulo-{{$idModalConfiguracionInventarioVehiculo}}" 
                                name="txt_titulo" 
                                placeholder="INGRESE TITULO"
                                data-label='Titulo'
                                maxlength="20"
                                style="text-transform: uppercase;">
                                <span class="badge bg-danger" data-for="txt_titulo-{{$idModalConfiguracionInventarioVehiculo}}"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600" for="txt_descripcion-{{$idModalConfiguracionInventarioVehiculo}}">
                                DESCRIPCIÓN
                            </label>
                            <div class="pos-relative">
                                <textarea class="form-control" 
                                placeholder="INGRESE LA DESCRIPCIÓN DEL INVENTARIO DE VEHICULO"
                                data-label='Descripción'
                                name="txt_descripcion" 
                                id="txt_descripcion-{{$idModalConfiguracionInventarioVehiculo}}" 
                                rows="3"
                                maxlength="200"
                                style="text-transform: uppercase;"
                                ></textarea>
                                <span class="badge bg-danger" data-for="txt_descripcion-{{$idModalConfiguracionInventarioVehiculo}}"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <strong>Items Inventario Vehiculo</strong>
                            <div class="row">
                                <div class="col-xs-12 col-md-5">
                                    <input class="form-control pd-r-80" type="text" id="txt_detalle_titulo-{{$idModalConfiguracionInventarioVehiculo}}" 
                                    name="txt_detalle_titulo" 
                                    placeholder="INGRESE DETALLE TITULO"
                                    data-label='Nombre de Titulo'
                                    maxlength="20"
                                    style="text-transform: uppercase;">
                                    <span class="badge bg-danger" data-for="txt_detalle_titulo-{{$idModalConfiguracionInventarioVehiculo}}"></span>
                                </div>
                                <div class="col-xs-12 col-md-5">
                                    <select name="select_detalle_tipo" id="select_detalle_tipo-{{$idModalConfiguracionInventarioVehiculo}}" class="form-control">
                                        <option value='1'>CHECKBOX</option>
                                        <option value='2'>NÚMERICO</option>
                                        <option value='3'>TEXTO</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-md-2">
                                    <button class="btn background-btn-nuevo pad-nu" id="btn_guardar_detalle_inventario_vehiculo-{{$idModalConfiguracionInventarioVehiculo}}">
                                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                                        <strong class="color-btn-nuevo" id="text_btn_guardar_detalle_inventario_vehiculo-{{$idModalConfiguracionInventarioVehiculo}}">Añadir</strong>
                                    </button>
                                </div>
                                <div class="mg-t-30" id="div_table_detalle_inventario-{{$idModalConfiguracionInventarioVehiculo}}">
                                    <table border="2" class="table">
                                        <thead class="background-thead">
                                            <tr align="center">
                                                <th align="center" class="border-bottom-0 color-th">Titulo</th>
                                                <th align="center" class="border-bottom-0 color-th">Tipo</th>
                                                <th align="center" class="border-bottom-0 color-th">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_detalle_inventario-{{$idModalConfiguracionInventarioVehiculo}}" data-id='0'>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_inventario_vehiculo-{{$idModalConfiguracionInventarioVehiculo}}" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>