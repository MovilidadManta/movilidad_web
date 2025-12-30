<div class="modal" id="{{$idModalConfiguracionCampos}}">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{$titulo}}</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block bus-emp-bo">
                    <div class="form-group">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            Icono
                        </label>
                        <div id="options-{{$idModalConfiguracionCampos}}" class="icons_actions">
                            <div class="icons_actions_icon" data-value="clear">
                                <i class="fa fa-comment"></i>
                                <span class="icons_actions_text">Sin Texto</span>
                            </div>
                            <div class="icons_actions_icon" data-value="text">
                                <i class="fa fa-font"></i>
                                <span class="icons_actions_text">Texto</span>
                            </div>
                            <div class="icons_actions_icon" data-value="search">
                                <i class="fa fa-search"></i>
                                <span class="icons_actions_text">Busqueda</span>
                            </div>
                            <div class="icons_actions_icon" data-value="dataset">
                                <i class="fa fa-list-alt"></i>
                                <span class="icons_actions_text">Dataset Campo</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="clear-{{$idModalConfiguracionCampos}}" style="display: none;">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            SIN TEXTO
                        </label>
                    </div>
                    <div class="form-group" id="text-{{$idModalConfiguracionCampos}}" style="display: none;">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            TEXTO
                        </label>
                        <div class="pos-relative">
                            <input class="form-control pd-r-80" type="text" id="txt_text-{{$idModalConfiguracionCampos}}" 
                            name="txt_text" 
                            placeholder="INGRESE EL TEXTO PARA EL CAMPO"
                            data-label='Texto'
                            style="text-transform: uppercase;">
                            <span class="badge bg-danger" data-for="txt_text-{{$idModalConfiguracionCampos}}"></span>
                        </div>
                    </div>
                    <div class="form-group" id="search-{{$idModalConfiguracionCampos}}" style="display: none;">
                        <div class="search_choose">
                            <span class="badge bg-secondary option_choose active" data-value="agente">AGENTE</span>
                        </div>
                        <div>
                            <span class="search_choose_text_option">
                                Use &agente
                           </span>
                        </div>
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            NOMBRE DE COLUMNA
                        </label>
                        <div class="pos-relative">
                            <input class="form-control pd-r-80" type="text" id="txt_name_col-{{$idModalConfiguracionCampos}}" 
                            name="txt_name_col" 
                            placeholder="NOMBRE DE COLUMNA"
                            data-label='Nombre'>
                            <span class="badge bg-danger" data-for="txt_name_col-{{$idModalConfiguracionCampos}}"></span>
                        </div>
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            VALOR BUSQUEDA
                        </label>
                        <div class="pos-relative">
                            <input class="form-control pd-r-80" type="text" id="txt_search_busq-{{$idModalConfiguracionCampos}}" 
                            name="txt_search_busq" 
                            placeholder="FORMATO PARA VISUALIZAR LA BUSQUEDA"
                            data-label='Busqueda'>
                            <span class="badge bg-danger" data-for="txt_search_busq-{{$idModalConfiguracionCampos}}"></span>
                        </div>
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            VALOR CAMPO
                        </label>
                        <div class="pos-relative">
                            <input class="form-control pd-r-80" type="text" id="txt_search_campo-{{$idModalConfiguracionCampos}}" 
                            name="txt_search_campo" 
                            placeholder="FORMATO PARA VISUALIZAR EN EL CAMPO"
                            data-label='Campo'>
                            <span class="badge bg-danger" data-for="txt_search_campo-{{$idModalConfiguracionCampos}}"></span>
                        </div>
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            DATASETS
                        </label>
                        <span class="main-content-label tx-11 tx-medium tx-gray-600">
                            (Use , para separar los datasets (atributo1, atributo2))
                        </span>
                        <div class="pos-relative">
                            <input class="form-control pd-r-80" type="text" id="txt_search_datasets-{{$idModalConfiguracionCampos}}" 
                            name="txt_search_datasets" 
                            placeholder="INGRESE LOS DATASET"
                            data-label='Dataset'>
                            <span class="badge bg-danger" data-for="txt_search_datasets-{{$idModalConfiguracionCampos}}"></span>
                        </div>
                    </div>
                    <div class="form-group" id="dataset-{{$idModalConfiguracionCampos}}" style="display: none;">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            DATASET ENLACE
                        </label>
                        <div class="pos-relative">
                            <input class="form-control pd-r-80" type="text" id="txt_dataset-{{$idModalConfiguracionCampos}}" 
                            name="txt_dataset" 
                            placeholder="INGRESE EL TEXTO ENLAZADO CON EL DATASET"
                            data-label='Dataset'>
                            <span class="badge bg-danger" data-for="txt_dataset-{{$idModalConfiguracionCampos}}"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_campo-{{$idModalConfiguracionCampos}}" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<script>
    let id_choose_modal = "";
    window.addEventListener("load", function (event) {
        let btnSave = document.getElementById('btn_guardar_campo-{{$idModalConfiguracionCampos}}');
        let searchControl = document.getElementById('search-{{$idModalConfiguracionCampos}}');
        let searchOption = searchControl.querySelector('.search_choose')

        initialState_{{$idModalConfiguracionCampos}}();
        changeOptionsCampos_{{$idModalConfiguracionCampos}}();
        btnSave.addEventListener('click', ()=>{
            Event_Save_{{$idModalConfiguracionCampos}}();
        });
        changeSearchOption_{{$idModalConfiguracionCampos}}(searchOption);
    });

    function changeOptionsCampos_{{$idModalConfiguracionCampos}}(){
        let options = document.getElementById('options-{{$idModalConfiguracionCampos}}');
        let listOptions = options.querySelectorAll('div[data-value]');
        listOptions.forEach(l =>{
            l.addEventListener('click', ()=>{
                let actionChoose = options.querySelector('div[data-value].active');
                actionChoose.classList.remove('active');
                l.classList.add('active');
                changeOption_{{$idModalConfiguracionCampos}}();
            });
        });
    }

    function changeOption_{{$idModalConfiguracionCampos}}(){
        let options = document.getElementById('options-{{$idModalConfiguracionCampos}}');
        let actionChoose = options.querySelector('div[data-value].active');

        let textControl = document.getElementById('text-{{$idModalConfiguracionCampos}}');
        let searchControl = document.getElementById('search-{{$idModalConfiguracionCampos}}');
        let datasetControl = document.getElementById('dataset-{{$idModalConfiguracionCampos}}');
        textControl.style.display = "none";
        searchControl.style.display = "none";
        datasetControl.style.display = "none";

        if(actionChoose.dataset.value == "text"){
            let textElement = document.getElementById('txt_text-{{$idModalConfiguracionCampos}}');
            textControl.style.display = "block";
            textElement.value = "";
        }
        if(actionChoose.dataset.value == "search"){
            let textBusq = document.getElementById('txt_search_busq-{{$idModalConfiguracionCampos}}');
            let textCampo = document.getElementById('txt_search_campo-{{$idModalConfiguracionCampos}}');
            let textDataset = document.getElementById('txt_search_datasets-{{$idModalConfiguracionCampos}}');
            searchControl.style.display = "block";
            textCampo.value = "";
            textBusq.value = "";
            textDataset.value = "";
        }
        if(actionChoose.dataset.value == "dataset"){
            let textDataset = document.getElementById('txt_dataset-{{$idModalConfiguracionCampos}}');
            datasetControl.style.display = "block";
            textDataset.value = "";
        }
    }

    function changeSearchOption_{{$idModalConfiguracionCampos}}(container){
        let options = container.querySelectorAll('.option_choose');
        let span = container.querySelector('search_choose_text_option');

        options.forEach( o =>{
            o.addEventListener('click', ()=>{
                let optionActive = container.querySelector('span.option_choose.active');
                optionActive.classList.remove('active');
                o.classList.add('active');
                span.innerHTML = `Use &${o.dataset.value}`;
            });
        });
    }

    function setIdChooseModal_{{$idModalConfiguracionCampos}}(id){
        id_choose_modal = id;
    }

    function initialState_{{$idModalConfiguracionCampos}}(){
        let options = document.getElementById('options-{{$idModalConfiguracionCampos}}');
        let listOptions = options.querySelectorAll('div[data-value]');
        let initialOption = options.querySelector('div[data-value="clear"]');
        
        listOptions.forEach(l => {
            l.classList.remove('active');
        });

        initialOption.classList.add('active');
        changeOption_{{$idModalConfiguracionCampos}}();
    }

    function Event_Save_{{$idModalConfiguracionCampos}}(){
        let options = document.getElementById('options-{{$idModalConfiguracionCampos}}');
        let actionChoose = options.querySelector('div[data-value].active');
        let text = document.getElementById('txt_text-{{$idModalConfiguracionCampos}}');
        let textNombreColumna = document.getElementById('txt_name_col-{{$idModalConfiguracionCampos}}');
        let textSearchBusq = document.getElementById('txt_search_busq-{{$idModalConfiguracionCampos}}');
        let textSearchCampo = document.getElementById('txt_search_campo-{{$idModalConfiguracionCampos}}');
        let textDataset = document.getElementById('txt_dataset-{{$idModalConfiguracionCampos}}');
        let errores = "";

        if(actionChoose.dataset.value == "text"){
            errores += text.validateInput();
        }

        if(actionChoose.dataset.value == "search"){
            errores += textSearchBusq.validateInput();
            errores += textSearchCampo.validateInput();
            errores += textNombreColumna.validateInput();
        }

        if(actionChoose.dataset.value == "dataset"){
            errores += textDataset.validateInput();
        }

        if (errores.trim() == "")
            sendValuesToElement_{{$idModalConfiguracionCampos}}();
    }

    function sendValuesToElement_{{$idModalConfiguracionCampos}}(){
        let options = document.getElementById('options-{{$idModalConfiguracionCampos}}');
        let actionChoose = options.querySelector('div[data-value].active');
        let element = document.getElementById(id_choose_modal);
        let changeHtmlElement = element.querySelector('.replace_content');

        let text = document.getElementById('txt_text-{{$idModalConfiguracionCampos}}');
        let textNombreColumna = document.getElementById('txt_name_col-{{$idModalConfiguracionCampos}}');
        let textSearchBusq = document.getElementById('txt_search_busq-{{$idModalConfiguracionCampos}}');
        let textSearchCampo = document.getElementById('txt_search_campo-{{$idModalConfiguracionCampos}}');
        let textSearchDataset = document.getElementById('txt_search_datasets-{{$idModalConfiguracionCampos}}');
        let textDataset = document.getElementById('txt_dataset-{{$idModalConfiguracionCampos}}');
        let searchControl = document.getElementById('search-{{$idModalConfiguracionCampos}}');
        let optionActive = searchControl.querySelector('span.option_choose.active');

        if(actionChoose.dataset.value == "clear"){
            element.dataset.type = "clear";
            element.classList.remove('empty');
            changeHtmlElement.innerHTML = `<p class="no_margin value">[NO TEXTO]</p>`;
        }
        
        if(actionChoose.dataset.value == "text"){
            element.dataset.type = "text";
            element.dataset.text = text.value.toUpperCase();
            element.classList.remove('empty');
            changeHtmlElement.innerHTML = `<p class="no_margin value">${text.value.toUpperCase()}</p>`;
        }

        if(actionChoose.dataset.value == "search"){
            element.dataset.type = "search";
            element.dataset.origin = optionActive.dataset.value;
            element.dataset.busq = textSearchBusq.value;
            element.dataset.campo = textSearchCampo.value;
            element.dataset.data = textSearchDataset.value;
            element.dataset.nameCol = textNombreColumna.value;
            element.classList.remove('empty');
            changeHtmlElement.innerHTML = `<span class="badge bg-secondary value">AGENTE</span>`;
        }

        if(actionChoose.dataset.value == "dataset"){
            element.dataset.type = "dataset";
            element.dataset.data = textDataset.value;
            element.classList.remove('empty');
            changeHtmlElement.innerHTML = `<p class="no_margin value">Dataset: [${textDataset.value}]</p>`;
        }

        $('#{{$idModalConfiguracionCampos}}').modal('hide');
    }
</script>