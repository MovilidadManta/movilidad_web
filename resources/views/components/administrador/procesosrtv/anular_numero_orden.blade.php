<div class="table-responsive">
    <div class="row detalle_placa">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="txt_placas">Tipo:</label>
                <select name="comment" id="cmb_comment_anular" class="form-control">
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
                <input class="form-control" type="text" id="txt_numero_orden_anular" 
                placeholder="Número de Orden"
                style="text-transform: uppercase;"
                >
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <label for="txt_placas">ID Institución</label>
                <input class="form-control" type="text" id="txt_id_institucion_anular" 
                placeholder="ID Institución"
                style="text-transform: uppercase;"
                value="76MAN"
                >
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <label for="txt_placas">Motivo Anulación</label>
                <input class="form-control" type="text" id="txt_motivo_anular" 
                placeholder="Número de Orden"
                style="text-transform: uppercase;"
                >
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <label for="txt_placas_mano">Mensaje ANT Anulación</label>
                <input class="form-control" type="text" id="txt_mensaje_ant_anular" 
                placeholder=""
                style="text-transform: uppercase;"
                >
            </div>
        </div>
        <div class="d-flex justify-content-center btn_aprobar">
            <button class="btn btn-success" id="btn_anular_numero_orden">
                <i class="fa fa-check"></i>
                Anular Orden
            </button>
        </div>
    </div>
</div>