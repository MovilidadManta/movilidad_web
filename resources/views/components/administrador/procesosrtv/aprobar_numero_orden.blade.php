<div class="table-responsive">
    <div class="row detalle_placa">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="txt_placas">Tipo:</label>
                <select name="comment" id="cmb_comment_numero_orden" class="form-control">
                    <option value="RTV" selected>RTV</option>
                    <!--<option value="EMPRESA PRIVADA">EMPRESA PRIVADA</option>-->
                    <option value="TAXIS">TAXIS</option>
                    <option value="CAIDO">CAIDO</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <label for="txt_placas">Número de Orden</label>
                <input class="form-control" type="text" id="txt_numero_orden_aprobar" 
                placeholder="Número de Orden"
                style="text-transform: uppercase;"
                >
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <label for="txt_placas_mano">Mensaje ANT</label>
                <input class="form-control" type="text" id="txt_mensaje_ant_aprobar" 
                placeholder=""
                style="text-transform: uppercase;"
                >
            </div>
        </div>
        <div class="d-flex justify-content-center btn_aprobar">
            <button class="btn btn-success" id="btn_aprobar_numero_orden">
                <i class="fa fa-check"></i>
                Aprobar Orden
            </button>
        </div>
    </div>
</div>