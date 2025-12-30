<div class="modal" id="{{$idModalConfiguracionDocumentos}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{$titulo}}</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token-{{$idModalConfiguracionDocumentos}}">
                <form class="form" novalidate id="{{$idFormModalConfiguracionDocumento}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id-configuracion-documento-{{$idModalConfiguracionDocumentos}}" name="id">
                    <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block bus-emp-bo">
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                Nombre
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="txt_nombre-{{$idModalConfiguracionDocumentos}}" 
                                name="txt_nombre" 
                                placeholder="INGRESE NOMBRE DEL DOCUMENTO"
                                data-label='Nombre'
                                style="text-transform: uppercase;">
                                <span class="badge bg-danger" data-for="txt_nombre-{{$idModalConfiguracionDocumentos}}"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                Código
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="txt_codigo-{{$idModalConfiguracionDocumentos}}" 
                                name="txt_codigo" 
                                placeholder="INGRESE CÓDIGO DEL DOCUMENTO"
                                data-label='Código'
                                style="text-transform: uppercase;">
                                <span class="badge bg-danger" data-for="txt_codigo-{{$idModalConfiguracionDocumentos}}"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                DESCRIPCIÓN
                            </label>
                            <div class="pos-relative">
                                <textarea class="form-control" 
                                placeholder="INGRESE LA DESCRIPCIÓN DEL DOCUMENTO"
                                data-label='Descripción'
                                name="txt_descripcion" 
                                id="txt_descripcion-{{$idModalConfiguracionDocumentos}}" 
                                rows="3"
                                style="text-transform: uppercase;"
                                ></textarea>
                                <span class="badge bg-danger" data-for="txt_descripcion-{{$idModalConfiguracionDocumentos}}"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <strong>Campos Documento</strong>
                            <div class="row">
                                <div class="col-xs-12 col-md-5">
                                    <input class="form-control pd-r-80" type="text" id="txt_nombre_campo-{{$idModalConfiguracionDocumentos}}" 
                                    name="txt_nombre_campo" 
                                    placeholder="INGRESE NOMBRE DEL CAMPO"
                                    data-label='Nombre de Campo'
                                    style="text-transform: uppercase;">
                                    <span class="badge bg-danger" data-for="txt_nombre_campo-{{$idModalConfiguracionDocumentos}}"></span>
                                </div>
                                <div class="col-xs-12 col-md-5">
                                    <select name="select-empresa" id="select_tipo_campo-{{$idModalConfiguracionDocumentos}}" class="form-control">
                                        <option value='TEXTO'>TEXTO</option>
                                        <option value='FECHA'>FECHA</option>
                                        <option value='MES/AÑO'>MES/AÑO</option>
                                        <option value='AÑO'>AÑO</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-md-2">
                                    <button class="btn background-btn-nuevo pad-nu" id="btn-guardar-documento-campo-{{$idModalConfiguracionDocumentos}}">
                                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                                        <strong class="color-btn-nuevo" id="text-btn-añadir-documento-campo-{{$idModalConfiguracionDocumentos}}">Añadir</strong>
                                    </button>
                                </div>
                                <div class="mg-t-30" id="div-table-documentos-campos-{{$idModalConfiguracionDocumentos}}">
                                    <table border="2" class="table">
                                        <thead class="background-thead">
                                            <tr align="center">
                                                <th align="center" class="border-bottom-0 color-th">Nombre</th>
                                                <th align="center" class="border-bottom-0 color-th">Tipo</th>
                                                <th align="center" class="border-bottom-0 color-th">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-documentos-campos-{{$idModalConfiguracionDocumentos}}" data-id='0'>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-switch">
                                <div style="margin-left: 35px;">
                                    <input class="form-check-input" type="checkbox" id="chk_estado-{{$idModalConfiguracionDocumentos}}" name="check_estado" checked>
                                    <label for="">Estado: <span id="text-check-estado-{{$idModalConfiguracionDocumentos}}">Activo</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-configuracion-documento-{{$idModalConfiguracionDocumentos}}" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", function (event) {
        let checkEstado = document.getElementById('chk_estado-{{$idModalConfiguracionDocumentos}}');
        let textCheckEstado = document.getElementById('text-check-estado-{{$idModalConfiguracionDocumentos}}');
        checkEstado.addEventListener('change', (e)=>{
            textCheckEstado.innerHTML = "Inactivo";
            if(e.target.checked)
                textCheckEstado.innerHTML = "Activo";
        });
    });
</script>