<style>
    .activeRow{
        background-color: #009ee2 !important;
        color: #fff !important;
    }
    .activeRow .color-td{
        color: #fff !important;
    }
</style>
<div class="modal" id="{{$idModal}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">{{$title}}</h1>
                <button
                    aria-label="Close"
                    class="close"
                    data-bs-dismiss="modal"
                    type="button"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input
                    type="hidden"
                    name="csrf-token"
                    value="{{csrf_token()}}"
                    id="csrf-token-{{$idModal}}"
                >
                <form
                    class="form"
                    novalidate
                    id="{{$idFormulario}}"
                    method="POST"
                >
                    <div class="row">
                        <div class="{{trim($btnAgregar) != "" ? 'col-xs-12 col-md-8 col-lg-10' : 'col-xs-12'}}">
                            <strong>Buscar:</strong>
                            <input
                                class="form-control"
                                name="txt-search-{{$idModal}}"
                                id="txt-search-{{$idModal}}"
                                placeholder="Ingresar su busqueda"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                        @if(trim($btnAgregar) != "")
                            <div class="col-md-4 col-lg-2 text-center" style="line-height: 70px;">
                                <button class="btn btn-success-gradient btn-movi" id="{{$btnAgregar}}" type="button">
                                    <i class="fa fa-plus"></i> Añadir
                                </button>
                            </div>
                        @endif
                        <div class="mg-t-30" id="div-table-{{$idModal}}" style="max-height: 400px; overflow-y:scroll;">
                            <table border="2" class="table">
                                <thead class="background-thead">
                                    <tr align="center">
                                        @foreach($columns as $column)
                                            <th align="center" class="border-bottom-0 color-th">{{$column}}</th>
                                        @endforeach
                                        <th align="center" class="border-bottom-0 color-th">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-table-{{$idModal}}">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="{{$buttonSelect}}" type="button">
                    <i class="fa fa-check"></i> Seleccionar
                </button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function selectFirstTr_{{$idModal}}(){
        let oldSelectTr = document.querySelector('#tbody-table-modal_administrar_causas > tr.tr-selects.activeRow');
        let firstSelectTr = document.querySelector('#tbody-table-modal_administrar_causas > tr.tr-selects');
        oldSelectTr.classList.remove('activeRow');
        firstSelectTr.classList.add('activeRow');
    }
    
    function selectTrs_{{$idModal}}(){
        let trsTableHorario = document.querySelectorAll('#tbody-table-{{$idModal}} > tr.tr-selects');

        [...trsTableHorario].map( t =>{
            t.addEventListener('click', (e) => {
                let oldSelectTr = document.querySelector('#tbody-table-{{$idModal}} > tr.tr-selects.activeRow');
                oldSelectTr.classList.remove('activeRow');
                e.target.parentNode.classList.add('activeRow');
            });
        });
    }

    function LoadDataModal_{{$idModal}}(text = document.getElementById('txt-search-{{$idModal}}').value, ajaxPrev = null){
        let token = document.getElementById("csrf-token-{{$idModal}}").value;
        let bodyTableHorario = document.getElementById('tbody-table-{{$idModal}}');

        if (ajaxPrev != null)
            ajaxPrev.abort();

        bodyTableHorario.innerHTML = `<tr>
                <td colspan="{{count($columnsData)}}">Cargando información...</td>
            </tr>`;
        let ajax = $.ajax({
            url: '{{$url}}'.replace("{text}", text.trim()),
            type: 'GET',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            success: function (response) {
                if(response['{{$nodeData}}'].length > 0){
                    bodyTableHorario.innerHTML = '';
                    response['{{$nodeData}}'].forEach( (r, i) => {
                            <?php 
                                echo "let searchTr = '';";
                                if(count($columnsSearchData) > 0){
                                    echo "searchTr += `data-search='`;";
                                }
                                foreach($columnsSearchData as $column){ 
                                    echo "searchTr += r['$column'] + ` `;";
                                }
                                if(count($columnsSearchData) > 0){
                                    echo "searchTr += `'`;";
                                }
                            ?>
                            <?php 
                                echo "let dataDatasets = '';";
                                foreach($columnsDataset as $column){ 
                                    echo "dataDatasets += `data-$column='` + r['$column'] + `' `;";
                                }
                            ?>
                            <?= "bodyTableHorario.innerHTML += `<tr class='tr-selects` + (i == 0 ? ` activeRow'` : `'`)  + searchTr + `` + dataDatasets + `>" ?>
                            <?php foreach($columnsData as $column){ 
                                if (array_key_exists($column, $columnsDataTransform)) {
                                    echo "<td align='center' class='color-td'>` + ({$columnsDataTransform[$column]}) + `</td>";
                                }else{
                                    echo "<td align='center' class='color-td'>` + r['$column'] + `</td>";
                                }
                            }?>
                            <?php
                            if($actionUpdate != ""){
                                echo "<td class='color-td' align='center'>";
                                    if($actionUpdate != ""){
                                        echo "<button type='button' class='tam-btn btn btn-warning' onClick='event.stopPropagation();$actionUpdate;'><i class='fa fa-edit tam-icono'></i></button>";
                                    }   
                                    if($actionDelete != ""){
                                        echo "<button type='button' class='tam-btn btn btn-danger' onClick='event.stopPropagation();$actionDelete;'><i class='fa fa-trash tam-icono'></i></button>";
                                    }                                
                                    echo "</td>";
                            }
                            ?>                                     
                            <?= "</tr>`" ?> 
                    });
                    selectTrs_{{$idModal}}();
                }else{
                    bodyTableHorario.innerHTML = `<tr>
                        <td colspan="{{count($columnsData)}}">No se encontraron resultados...</td>
                    </tr>`;
                }
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
             if (jqXHR.status == 404) {
                alert('Requested page not found [404]');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error [500]. Intente nuevamente');
            } else if (textStatus === 'timeout') {
                alert('Time out error.');
            }
        });

        return ajax;
    }
    
    window.addEventListener("load", function (event) {

        let asyncronous = '{{$asyncronous}}';

        let txtSearch = document.getElementById('txt-search-{{$idModal}}');
        let ajaxBusqueda = null;

        txtSearch.addEventListener('keyup', (e) =>{
            if(!asyncronous){
                let trFounds = document.querySelectorAll('#tbody-table-{{$idModal}} tr[data-search]');
                [...trFounds].map( t =>{
                        t.style.display = "table-row";
                        if(!t.dataset.search.toUpperCase().includes(e.target.value.trim().toUpperCase())){
                            t.style.display = "none";
                        }
                });
            }else{
                let value = e.target.value.trim();
                setTimeout(() => {
                    if (e.target.value.trim() == value.trim()) {
                        ajaxBusqueda = LoadDataModal_{{$idModal}}(e.target.value.trim(), ajaxBusqueda);
                    }
                }, 750);
            }
        });

        let btnSelect = document.getElementById('{{$buttonSelect}}');

        btnSelect.addEventListener('click', (e) =>{
            let activeTr = document.querySelector('#tbody-table-{{$idModal}} > tr.tr-selects.activeRow');
            {{$actionSelect}}(activeTr);
        });

        if('{{$actionAgregar}}' != ''){
            let btnAgregar = document.getElementById('{{$btnAgregar}}');
            btnAgregar.addEventListener('click', (e) =>{
                {{$actionAgregar}}();
            });
        }

        ajaxBusqueda = LoadDataModal_{{$idModal}}('', ajaxBusqueda);
    });
</script>