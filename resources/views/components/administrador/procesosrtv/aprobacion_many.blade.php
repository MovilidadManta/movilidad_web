<div class="table-responsive">
    <div class="row detalle_placa">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="txt_placas">Tipo:</label>
                <select name="comment" id="cmb_comment_many" class="form-control">
                    <option value="RTV">RTV</option>
                    <!--<option value="EMPRESA PRIVADA" selected>EMPRESA PRIVADA</option>-->
                    <option value="TAXIS">TAXIS</option>
                    <option value="CAIDO">CAIDO</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-lg-6">
            <div class="form-group">
                <label for="txt_placas">Placas</label>
                <textarea 
                class="form-control" 
                id="txt_placas" 
                rows="8"
                cols="10"
                name="textarea" 
                style="text-transform: uppercase;"
                ></textarea>
            </div>
        </div>
        <div class="col-xs-12 col-lg-6">
            <div class="form-group">
                <label for="txt_placas_mano">Placas realizar a mano</label>
                <textarea 
                class="form-control"
                id="txt_placas_mano"
                rows="8"
                cols="10"
                name="textarea"
                style="text-transform: uppercase;"
                ></textarea>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <label for="txt_placas_errores">Placas con errores</label>
                <textarea 
                class="form-control" 
                id="txt_placas_errores" 
                rows="8"
                cols="10"
                name="textarea" 
                ></textarea>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <label for="txt_placas_ok">Placas OK</label>
                <textarea 
                class="form-control" 
                id="txt_placas_ok" 
                rows="8"
                cols="10"
                name="textarea" 
                ></textarea>
            </div>
        </div>
        <div class="d-flex justify-content-center btn_aprobar">
            <button class="btn btn-success" id="btn_aprobar_many">
                <i class="fa fa-check"></i>
                Aprobar placas
            </button>
        </div>
    </div>
</div>