<div class="row">
    <div class="col-xs-4 col-md-1 mg-t-10">
        <strong>Fecha Inicio</strong>
    </div>
    <div class="col-xs-8 col-md-2">
        <input class="form-control" name="select_fecha_inicio" id="select_fecha_inicio_api"
            type="date">
    </div>
    <div class="col-xs-4 col-md-1 mg-t-10">
        <strong>Fecha Fin</strong>
    </div>
    <div class="col-xs-8 col-md-2 mg-b-10">
        <input class="form-control" name="select_fecha_fin" id="select_fecha_fin_api"
            type="date">
    </div>
    <div class="col-xs-12 col-md-2 text-end">
        <a class="btn background-btn-nuevo pad-nu btn_buscar_oc" id="btn_reporte_aprobados_api">
            <i class="fa fa-search color-btn-nuevo"></i>
            <strong class="color-btn-nuevo">Buscar</strong>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 marg" id="optionsDownload_api" style="display: none">
        <a id="downloadExcelApi" target="_blank" href="">
            <i class="far fa-file-excel tam-excell"></i>
        </a>
    </div>
</div>
<div class="table-responsive">
    <div id="div_table_reporte_api"></div>
</div>