<!DOCTYPE html>
<html lang="en">
<head>
    <title>ORDEN DE CUERPO</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root{
            --repeat-color:#198754;
            --header-green: #E2EFDA;
            --border-color:#007bff;
            --hover-color: #007bff;
            --header-yellow: #0F4C88;
            --header-blue: #00AFEF;
            --hover-blue: #00AFEF;
            --hover-color-secondary: #B0AAD280 ;
        }
        .logo_alcaldia{
            width: 240px;
        }
        .logo_agentes{
            width: 70px;
            float: right;
        }
        .info_oc{
            position: absolute;
            top: 1000px;
            right: 17px;
        }
        .img_info_oc{
            
        }
        .container_elements{
            border: 1px solid black;
            min-height: 150px;
            margin-top: 5px;
        }
        .container_elements_header{
            border: 1px solid black;
            padding: 5px;
            position: relative;
        }
        .container_elements_header_text{
            font-size: 12px;
        }
        .row_list_col{
            width: 49.5%;
            float: left;
        }
        .title{
            font-size: 14px;
        }
        .paragraph{
            font-size: 12px;
        }

        .title
        ,.paragraph{
            font-weight: bold;
        }
        .izq{
            font-weight: bold;
        }
        .text_list{
            font-size: 12px;
            margin: 0;
        }
        .no_margin{
            margin: 0;
        }
        .table_container{
            margin-top: 5px;
            border-collapse: collapse;
            width: 100%;
        }
        .container_elements .table_container{
            margin-top: 0;
        }
        .table_container th, .table_container td {
            border: 1px solid black; /* Borde de 1 píxel de ancho y color negro */
            padding: 3px 2px; /* Espacio interior de 8 píxeles */
            text-align: left; /* Alinear texto a la izquierda */
        }
        .table_container th{
            font-size: 12px;
        }
        .table_container td{
            font-size: 10px;
        }
        .text_table{
            font-size: 10px;
        }
        .container_image{
            margin-top: 5px;
        }
        .container_count{
            margin-top: 5px;
            width: 100%;
            text-align: center;
        }
        .div_count{
            margin-left: auto;
            margin-right: auto;
            padding: 10px;
            font-size: 12px;
            width: 50%;
            border: 1px solid black;
        }
        .container_total{
            width: 100%;
            border: 0px;
            margin-top: 10px;
        }
        .table_total{
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }
        .title_total{
            width: 80%;
        }
        .count_total{
            width: 20%;
        }

        .row_franco_num{
            width: 20%;
        }
        .row_franco_name{
            width: 60%;
        }
        .firma_container{
            text-align: center;
        }
        .firma_subtitle{
            font-weight: bold;
        }
        .img_container_firma{
            text-align: center; 
            width:50%; 
            margin: auto;
        }
    </style>
</head>
<body>
    <?php
        
        if (!function_exists('renderMoreTabla')) {
            function renderMoreTabla($ids, $original_items){
                $moreHtml = '';
                //Añadir tablas extras
                if($ids[0] == 0){
                        $moreHtml .= "";
                    }
                    //-------------------------------------
                return $moreHtml;
            }
        }
        
        if (!function_exists('resolveData')) {
            function resolveData($items, $ids, $distrito, $turno, $original_items){
                $html = "";

                foreach ($items as $item) {
                    $html .= createElement($item, $ids, $distrito, $turno, $original_items);
                }

                return $html;
            }
        }

        if (!function_exists('createElement')) {
            function createElement($item, $ids, $distrito, $turno, $original_items){
                $element = "";
                $render_some = false;
                switch ($item->type) {
                    case 'title':
                        $element = generateTitle($item->text, $item->style);
                        $render_some = true;
                        break;
                    case 'paragraph':
                        $element = generateParagraph($item->text, $item->style);
                        $render_some = true;
                        break;
                    case 'container':
                        $element = generateContainer($item->name, $item->textHeader, $item->styleHeader, $item->styleParrafo, $item->items, $ids, $original_items, $distrito, $turno);
                        $render_some = true;
                        break;
                    case 'list':
                        $element = generateList($item->items, $ids);
                        $render_some = true;
                        break;
                    case 'table':
                        $tableResult = generateTable($item->name, $item->styleThead, $item->headerColumns, $item->filas, $ids, $distrito, $turno);
                        $element = $tableResult['table'];
                        $render_some = $tableResult['render_table'];
                        break;
                    case 'table_total':
                        $tableTotalResult = generateTableTotal($item->name, $item->items, $ids);
                        $element = $tableTotalResult['table'];
                        $render_some = $tableTotalResult['render_table'];
                        break;
                    case 'table_franco':
                        $tableFrancoResult = generateTableFranco($item->name, $item->items, $ids);
                        $element = $tableFrancoResult['table'];
                        $render_some = $tableFrancoResult['render_table'];
                        break;
                    case 'image':
                        $element = generateImage($item->image);
                        $render_some = true;
                        break;
                    default:
                        # code...
                        break;
                }

                return $render_some ? $element : "";
            }
        }

        if (!function_exists('generateImage')) {
            function generateImage($image){

                return "
                    <div class='container_image'>
                        <img src='". "imagenes_orden_cuerpo/{$image}" ."' class='img_image'>
                    </div>
                ";
            }
        }

        if (!function_exists('generateTitle')) {
            function generateTitle($title, $style){
                return "
                    <h1 class='text_align title' style='{$style}' >{$title}</h1>
                ";
            }
        }

        if (!function_exists('generateParagraph')) {
            function generateParagraph($paragraph, $style){
                return "
                <p class='text_align paragraph' style='{$style}'>{$paragraph}</p>
                ";
            }
        }

        if (!function_exists('listAgentsFromContainer')) {
            function listAgentsFromContainer($arrayNames, $items, $containerActual = ""){
                $containerPrevious = $containerActual;
                $list = [];
                foreach ($items as $item) {
                    
                    $containerActual = in_array($item->name, $arrayNames)? $item->name : $containerPrevious;

                    if(!in_array($containerActual, $arrayNames))
                        continue;

                    switch ($item->type) {
                        case 'container':
                            $list = array_merge($list, listAgentsFromContainer($arrayNames, $item->items, $containerActual));
                            break;
                        case 'table':
                            foreach ($item->filas as $fila) {
                                foreach ($fila->columns as $column) {
                                    if($column->type == "search"){
                                        array_push($list, $column->at_id);
                                    }
                                }
                            }
                            break;
                        case 'list':
                            foreach ($item->items as $item) {
                                foreach ($fila->columns as $column) {
                                    if($column->type == "search"){
                                        array_push($list, $column->at_id);
                                    }
                                }
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                }

                return $list;
            }
        }

        if (!function_exists('generateContainer')) {
            function generateContainer($name, $titulo, $styleBackground, $styleText, $items, $ids, $original_items, $distrito, $turno){
                $htmlContainer = resolveData($items, $ids, $distrito, $turno, $original_items);
                $styleBackground = changeValuesBackground($styleBackground);
                $content_container = $htmlContainer != "" 
                ? $htmlContainer
                :"
                <p style='text-align: center;'>No hay información disponible</p>
                ";
                $container = "
                <div class='container_elements'>
                    <div class='container_elements_header background_color text_color' style='{$styleBackground}'>
                        <p class='no_margin container_elements_header_text text_align bold_text' style='{$styleText}'>{$titulo}</p>
                    </div>
                    {$content_container}
                </div>
                ";

                
                if($ids[0] == 0){
                    if($name == "ciclistas_primer_turno"){
                        $array_primer_turno = listAgentsFromContainer(['patrulleros_primer_turno','puntos_fijos_primer_turno','motorizados_primer_turno', 'ciclistas_primer_turno'], $original_items);
                        $array_primer_turno = array_unique($array_primer_turno);
                        $count_primer_turno = count($array_primer_turno);
                        $container .= "
                            <div class='container_count'>
                                <div class='div_count'>
                                    TOTAL DE AGENTES DE TRÀNSITO PRIMER TURNO: {$count_primer_turno}
                                </div>
                            </div>
                        ";
                    }

                    if($name == "ciclistas_segundo_turno"){
                        $array_segundo_turno = listAgentsFromContainer(['patrulleros_segundo_turno','puntos_fijos_segundo_turno','motorizados_segundo_turno', 'ciclistas_segundo_turno'], $original_items);
                        $array_segundo_turno = array_unique($array_segundo_turno);
                        $count_segundo_turno = count($array_segundo_turno);
                        $container .= "
                            <div class='container_count'>
                                <div class='div_count'>
                                    TOTAL DE AGENTES DE TRÀNSITO SEGUNDO TURNO: {$count_segundo_turno}
                                </div>
                            </div>
                        ";
                    }
                }

                return $container;
            }
        }

        if (!function_exists('generateList')) {
            function generateList($items, $ids){
                $filas = "";

                foreach ($items as $item) {
                    $showRow = $ids[0] == 0;
                    $izq = cellRenderList($item->izq);
                    $der = cellRenderList($item->der);
                    if($ids[0] != 0 && isset($item->der->at_id) && in_array($item->der->at_id,$ids)){
                        $showRow = true;
                    }
                    if($ids[0] != 0 && isset($item->izq->at_id) && in_array($item->izq->at_id,$ids)){
                        $showRow = true;
                    }
                    $filas .= $showRow ?"
                    <div class='row_list'>
                        <div class='row_list_col izq'>
                            {$izq}
                        </div>
                        <div class='row_list_col der'>
                            {$der}
                        </div>
                    </div>
                    "
                    : "";
                }

                return "
                    <div class='list_container'>
                        {$filas}
                    </div>
                ";
            }
        }

        if (!function_exists('cellRenderList')) {
            function cellRenderList($data){
                $value = "";
                if(isset($data->type) && $data->type == "text"){
                    $value = "<p class='no_margin text_list'>{$data->value}</p>";
                }else{
                    $value = "<p class='no_margin text_list'>{$data->text}</p>";
                }
                return $value;
            }
        }

        if (!function_exists('changeValuesBackground')) {
            function changeValuesBackground($item){
                $item = str_replace("var(--header-yellow)", "#0F4C88", $item);
                $item = str_replace("var(--header-blue)", "#00AFEF", $item);
                $item = str_replace("var(--header-green)", "#E2EFDA", $item);
                return $item;
            }
        }

        if (!function_exists('generateTable')) {
            function generateTable($name, $styleThead, $headerColumns, $filasTable, $ids, $distrito, $turno){

                $always_render_table = false;
                $render_table_all_rows_is_found = false;
                $existFilas = false;
                
                $colSpan = count($headerColumns) == 1
                ? count($filasTable) > 0 ? count($filasTable[0]->columns) : 1 
                :1;
                $styleTheadValue = changeValuesBackground($styleThead);

                $headers = "";
                $filas = "";

                foreach ($headerColumns as $header) {
                    $headers .= "
                    <th style='{$styleTheadValue} {$header->styleTh} {$header->styleP}' colspan='$colSpan'>
                        <p class='no_margin text_align bold_text'>
                            {$header->text}
                        </p>
                    </th>
                    ";
                }

                foreach ($filasTable as $f) {
                    $count_agent_for_row = 0;
                    $count_agent_founds_for_row = 0;
                    $columns = "";
                    
                    foreach ($f->columns as $indexColumn => $c) {
                        $showCell = true;

                        if($c->type == "search"){
                            $count_agent_for_row += 1;
                        }

                        if($c->type == "search" && (in_array($c->at_id, $ids) || $ids[0] == 0)){
                            $count_agent_founds_for_row += 1;
                            $existFilas = true;
                        }

                        if($c->type == "search" && !in_array($c->at_id, $ids) && $ids[0] != 0){
                            $showCell = false;
                        }

                        if($name == "distribucion_supervisor" && $c->type == "search" && in_array($indexColumn == 1 ? "OESTE" : "ESTE",$distrito) && $turno == $f->columns[0]->data_text){
                            $count_agent_founds_for_row += 1;
                            $existFilas = true;
                            $showCell = true;
                        }

                        if($name == "horario_redactor"){
                            $count_agent_founds_for_row += 1;
                            $existFilas = true;
                            $showCell = true;
                        }

                        $valueP = $showCell 
                        ? cellRenderTable($c)
                        : "";
                        $columns .= "
                            <td style='text-align: center; {$c->style}'>
                                {$valueP}
                            </td>
                        ";
                    }

                    $showRow = $count_agent_for_row == 0 || $count_agent_founds_for_row > 0;

                    $filas .= $showRow ? "<tr>{$columns}</tr>" : "";
                }

                $table = "
                <table class='table_container'>
                    <thead>
                        <tr>
                            {$headers}
                        </tr>
                    </thead>
                    <tbody>
                        {$filas}
                    </tbody>
                </table>
                ";

                $renderTable = $existFilas;
                return ['table' => $renderTable 
                ? $table 
                : "",
                'render_table'=> $renderTable];
            }
        }

        if (!function_exists('generateTableTotal')) {
            function generateTableTotal($name, $items, $ids){
                $filas = "";

                foreach ($items as $f) {
                    $filas .= "<tr>
                                    <td class='title_total' style='text-align: center;'>
                                        {$f->name}
                                    </td>
                                    <td class='count_total' style='text-align: center;'>
                                        {$f->value}
                                    </td>
                                </tr>";
                }


                $table = "
                    <div class='container_total'>
                        <table class='table_container table_total'>
                            <thead>
                                <tr>
                                    <th style='text-align: center;' colspan='2'>
                                        <p class='no_margin text_align bold_text'>
                                            TOTAL PERSONAL
                                        </p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {$filas}
                            </tbody>
                        </table>
                    </div>
                ";

                $renderTable = count($items) > 0 && $ids[0] == 0;
                return ['table' => $renderTable 
                ? $table 
                : "",
                'render_table'=> $renderTable];
            }
        }

        if (!function_exists('generateTableFranco')) {
            function generateTableFranco($name, $items, $ids){
                $filas = "";

                if($ids[0] != 0){
                    $items = array_filter($items, function($item) use($ids) {
                        return in_array($item->id, $ids);;
                    });
                }

                foreach ($items as $f) {
                    $filas .= "<tr>
                                    <td class='row_franco_num' style='text-align: center;'>
                                        {$f->row}
                                    </td>
                                    <td class='row_franco_num' style='text-align: center;'>
                                        {$f->codigo}
                                    </td>
                                    <td class='row_franco_name' style='text-align: center;'>
                                        {$f->name}
                                    </td>
                                </tr>";
                }


                $table = "
                    <div class='container_total'>
                        <table class='table_container table_total'>
                            <tbody>
                                {$filas}
                            </tbody>
                        </table>
                    </div>
                ";

                $renderTable = count($items) > 0;
                return ['table' => $renderTable 
                ? $table 
                : "",
                'render_table'=> $renderTable];
            }
        }

        if (!function_exists('cellRenderTable')) {
            function cellRenderTable($data){
                $value = "";
                if($data->type == "text" || $data->type == "clear" || $data->type == "dataset"){
                    $cleanValue = str_replace(array("\r", "\n"), ' ', $data->value);
                    $cleanValue = str_replace("\r\n", "\n", $cleanValue);
                    $value = "<p class='no_margin text_table'>{$cleanValue}</p>";
                }
                if($data->type == "search"){
                    $value = "<p class='no_margin text_table'>{$data->text}</p>";
                }
                return $value;
            }
        }
    ?>
    {!! resolveData($data, $ids, $distrito, $turno, $data) !!}
    {!! renderMoreTabla($ids, $data) !!}
    @if(isset($oc_firma) && $oc_firma != "")
        <div class='container_total'>
            <div class="firma_container">
                <p class="firma_subtitle">ELABORADO POR:</p>
                <div class="img_container_firma">
                    {!!QrCode::generate("Orden de Cuerpo firmada por: " . $oc_firma);!!}
                </div>
                <p class="">{{$oc_firma}}</p>
                <p class="firma_subtitle">DEPARTAMENTO DE PERSONAL D1</p>
            </div>
        </div>
    @endif
</body>
</html>