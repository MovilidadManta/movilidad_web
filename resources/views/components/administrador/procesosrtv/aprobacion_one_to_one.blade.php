<div class="table-responsive">
    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-3">
            <strong># de placa:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_nro_placa" 
            placeholder="Placa"
            data-label='Placa'
            style="text-transform: uppercase;">
            <span class="badge bg-danger" data-for="txt_nro_placa"></span>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <button class="btn btn-info" style="margin-top: 15px;" id="btn_buscar_placa">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <strong>Tipo:</strong>
            <select name="comment" id="cmb_comment_one" class="form-control">
                <option value="RTV" selected>RTV</option>
                <!--<option value="EMPRESA PRIVADA">EMPRESA PRIVADA</option>-->
                <option value="TAXIS">TAXIS</option>
                <option value="CAIDO">CAIDO</option>
            </select>
        </div>
    </div>
    <div class="row detalle_placa">
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>Placa Actual:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_placa_actual" 
            placeholder="Placa Actual"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>Año matriculado:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_anio_matriculado" 
            placeholder="Año M"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>Color:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_color_1" 
            placeholder="Color"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>Chasis:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_chasis" 
            placeholder="Chasis"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>Motor:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_motor" 
            placeholder="Motor"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>RAMV/CPN:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_ramv" 
            placeholder="RAMV/CPN"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>Marca:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_marca" 
            placeholder="Marca"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>Modelo:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_modelo" 
            placeholder="Modelo"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>Año:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_anio" 
            placeholder="Año Matriculado"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>Propietario:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_nombre_propietario" 
            placeholder="PROPIETARIO"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>Cédula propietario:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_cedula_propietario" 
            placeholder="CEDULA PROPIETARIO"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>Cilindraje:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_cilindraje" 
            placeholder="CILINDRAJE"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>Tipo de Servicio:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_tipo_servicio" 
            placeholder="TIPO DE SERVICIO"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>Clase de servicio:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_clase_servicio" 
            placeholder="CLASE DE SERVICIO"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <strong>Clase de transporte:</strong>
            <input class="form-control pd-r-80" type="text" id="txt_clase_transporte" 
            placeholder="CLASE DE TRANSPORTE"
            style="text-transform: uppercase;"
            readonly>
        </div>
        <div class="d-flex justify-content-center btn_aprobar">
            <button class="btn btn-success" id="btn_aprobar">
                <i class="fa fa-check"></i>
                Aprobar
            </button>
        </div>
    </div>
</div>