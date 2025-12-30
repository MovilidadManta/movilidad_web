@extends('Administrador.Layout.app')

@section('css')
<style>
    .input-mayus{
        text-transform: uppercase;
    }
    .foto_empleado{
        min-height: 100%;
    }
    .container_foto_empleado{
        overflow: hidden;
    }
    .badge{
        margin-top: 5px;
        white-space: pre;
    }
    .bg-danger{
        font-size: 90%;
    }
</style>
@endsection

@section('content')
    <div class="main-container">
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto col-md-12">
                <div class="d-flex">
                    <div class="col-md-6">
                        <h2 class="content-title mb-0 my-auto color-titulo">Registrar Certificado</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                <form class="form" id="form-registrar-ficha-medica" method="POST">
                    <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                    <input type="hidden" value="{{isset($certificado) ? $certificado->emp_estado_ruta_foto : '' }}" id="estado_foto_empleado">
                    <input type="hidden" value="{{isset($certificado) ? $certificado->emp_ruta_foto : '' }}" id="url_foto_empleado">
                    <input type="hidden" value="{{isset($certificado) ? "{$certificado->emp_nombre} {$certificado->emp_apellido}" : '' }}" id="apellidos_nombres_empleado">
                    <input type="hidden" name="fm_id" id="fm_id" value="{{isset($certificado) ? $certificado->fm_id : '' }}">
                    <div class="card box-sha">
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="card-header top-linea">
                                    <h4 class="ti-color">Información del certificado</h4>
                                </div>
                                <div class="row row-sm card-body">
                                    <div class="col-lg">
                                        <strong>Fecha de Emisión</strong>
                                        <input class="form-control" type="date" name="txt-fecha-ficha" id="txt-fecha-ficha" value="{{isset($certificado) ? $certificado->fm_fecha_recepcion : '' }}" readonly/>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-xs-12 col-md-4 col-lg-2 text-center">
                                        <img id="foto_empleado" class="foto_empleado" src="Imagenes/utilitarios/usuario.png" alt="Foto del empleado">
                                    </div>
                                    <div class="col-xs-12 col-md-8 col-lg-10" id='div-datos-empleados'>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-6 mg-t-10 mg-lg-t-0">
                                                <strong>Empleado</strong>
                                                <input id="txt-search-emp" class="form-control input-mayus" data-label='Empleado' data-noresults_text="No se encontraron resultados" data-wait_search="Buscando Empleados..." type="text" autocomplete="off" placeholder="Buscar por cédula o nombre"
                                                value="{{isset($certificado) ? "[{$certificado->emp_cedula}] {$certificado->emp_apellido} {$certificado->emp_nombre}" : '' }}"
                                                data-value="{{isset($certificado) ? $certificado->emp_id : '' }}"
                                                data-text="{{isset($certificado) ? "[{$certificado->emp_cedula}] {$certificado->emp_apellido} {$certificado->emp_nombre}" : '' }}"
                                                {{isset($certificado) ? 'readonly' : '' }}
                                                >
                                                <span class="badge bg-danger" data-for="txt-search-emp"></span>
                                            </div>
                                            <div class="col-xs-12 col-md-6 mg-t-10 mg-lg-t-0">
                                                <strong>Edad</strong>
                                                <input class="form-control" name="txt-edad-empleado" id="txt-edad-empleado"
                                                value="{{isset($certificado) ? $certificado->emp_edad : '' }}"
                                                    type="text" readonly>
                                            </div>
                                            <div class="col-xs-12 col-md-6 mg-t-10 mg-lg-t-0">
                                                <strong>Departamento</strong>
                                                <input class="form-control" name="txt-departamento-empleado" id="txt-departamento-empleado"
                                                value="{{isset($certificado) ? $certificado->dep_departamento : '' }}"
                                                    type="text" readonly>
                                            </div>
                                            <div class="col-xs-12 col-md-6 mg-t-10 mg-lg-t-0">
                                                <strong>Puesto de trabajo</strong>
                                                <input class="form-control" name="txt-cargo-empleado" id="txt-cargo-empleado"
                                                value="{{isset($certificado) ? $certificado->ca_cargo : '' }}"
                                                    type="text" readonly>
                                            </div>
                                            <div class="col-xs-12 col-md-6 mg-t-10 mg-lg-t-0">
                                                <strong>F. Nacimiento</strong>
                                                <input class="form-control" name="txt-fecha-nacimiento-empleado" id="txt-fecha-nacimiento-empleado"
                                                value="{{isset($certificado) ? $certificado->emp_fecha_nacimiento : '' }}"
                                                    type="text" readonly>
                                            </div>
                                            <div class="col-xs-12 col-md-6 mg-t-10 mg-lg-t-0">
                                                <strong>Tipo Sangre</strong>
                                                <input class="form-control" name="txt-tipo-sangre-empleado" id="txt-tipo-sangre-empleado"
                                                value="{{isset($certificado) ? $certificado->emp_tipo_sangre : '' }}"
                                                    type="text" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>Certificado</strong>
                                        <select name="select-certificado-ficha" id="select-certificado-ficha" class="form-control"
                                        >
                                            <option value="0">Seleccione certificado</option>
                                            <option value="1" {{isset($certificado) ? ($certificado->fm_tipo_certificado == 1 ? 'selected' : '') : '' }}>CERTIFICADO POR DÍAS</option>
                                            <option value="2" {{isset($certificado) ? ($certificado->fm_tipo_certificado == 2 ? 'selected' : '') : '' }}>CERTIFICADO POR HORAS</option>
                                            <option value="3" {{isset($certificado) ? ($certificado->fm_tipo_certificado == 3 ? 'selected' : '') : '' }}>REVISIÓN MÉDICA</option>
                                        </select>
                                        <span class="badge bg-danger" data-for="select-certificado-ficha"></span>
                                    </div>
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>F. Inicio de certificado</strong>
                                        <input class="form-control" name="txt-fecha-inicio-certificado" id="txt-fecha-inicio-certificado"
                                        value="{{isset($certificado) ? $certificado->fm_fecha_inicio_certificado : '' }}"
                                            type="date" >
                                    </div>
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>F. Fin de certificado</strong>
                                        <input class="form-control" name="txt-fecha-fin-certificado" id="txt-fecha-fin-certificado"
                                        value="{{isset($certificado) ? $certificado->fm_fecha_fin_certificado : '' }}"
                                            type="date">
                                    </div>
                                </div>
                                <div class="row row-sm controls_horas_certificado" style="display: none;">
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>Hora Inicio:</strong>
                                        <input
                                            class="form-control"
                                            name="txt-hora-inicio-certificado"
                                            id="txt-hora-inicio-certificado"
                                            placeholder="Ingresar hora Inicio"
                                            type="time"
                                            data-label='Hora Inicio'
                                        >
                                        <span class="badge bg-danger" data-for="txt-hora-inicio-certificado"></span>
                                    </div>
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>Hora Fin:</strong>
                                        <input
                                            class="form-control"
                                            name="txt-hora-fin-certificado"
                                            id="txt-hora-fin-certificado"
                                            placeholder="Ingresar hora Fin"
                                            type="time"
                                            data-label='Hora Fin'
                                            disabled
                                        >
                                        <span class="badge bg-danger" data-for="txt-hora-fin-certificado"></span>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>Causa:</strong>
                                        <input id="txt-search-causa" data-label='Causa' class="form-control input-mayus" data-noresults_text="No se encontraron resultados" data-wait_search="Buscando Causas..." type="text" autocomplete="off" placeholder="Buscar causa..."
                                        value="{{isset($certificado) ? $certificado->cm_descripcion : '' }}"
                                        data-value="{{isset($certificado) ? $certificado->cm_id : '' }}"
                                        data-text="{{isset($certificado) ? $certificado->cm_descripcion : '' }}"
                                        >
                                        <span class="badge bg-danger" data-for="txt-search-causa"></span>
                                    </div>
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>Medico:</strong>
                                        <input id="txt-search-medico" name="txt-medico" data-label='Médico' class="form-control input-mayus" data-noresults_text="No se encontraron resultados" data-wait_search="Buscando Medico..." type="text" autocomplete="off" placeholder="Buscar medico..."
                                        value="{{isset($certificado) ? ($certificado->me_cedula != '' ? "[{$certificado->me_cedula}] {$certificado->me_apellidos} {$certificado->me_nombres}" : "{$certificado->me_apellidos} {$certificado->me_nombres}") : '' }}"
                                        data-value="{{isset($certificado) ? $certificado->me_id : '' }}"
                                        data-text="{{isset($certificado) ? ($certificado->me_cedula != '' ? "[{$certificado->me_cedula}] {$certificado->me_apellidos} {$certificado->me_nombres}" : "{$certificado->me_apellidos} {$certificado->me_nombres}") : '' }}"
                                        >
                                        <span class="badge bg-danger" data-for="txt-search-medico"></span>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>Diagnóstico:</strong>
                                        <input id="txt-search-diagnostico" data-label='Diagnóstico' class="form-control input-mayus" data-noresults_text="No se encontraron resultados" data-wait_search="Buscando Diagnósticos..." type="text" autocomplete="off" placeholder="Buscar diagnóstico..."
                                        value="{{isset($certificado) ? ($certificado->dm_cie10 != '' ? "[{$certificado->dm_cie10}] {$certificado->dm_descripcion}" : "{$certificado->dm_descripcion}") : '' }}"
                                        data-value="{{isset($certificado) ? $certificado->dm_id : '' }}"
                                        data-text="{{isset($certificado) ? ($certificado->dm_cie10 != '' ? "[{$certificado->dm_cie10}] {$certificado->dm_descripcion}" : "{$certificado->dm_descripcion}") : '' }}"
                                        >
                                        <span class="badge bg-danger" data-for="txt-search-diagnostico"></span>
                                        <span class="badge bg-warning" id="txt-search-diagnostico-warning"></span>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>Observación:</strong>
                                        <textarea id="txt-observacion-ficha" data-label='Observación' name="txt-observacion-ficha" class="form-control input-mayus" rows="6">{{isset($certificado) ? $certificado->fm_observacion : '' }}</textarea>
                                        <span class="badge bg-danger" data-for="txt-observacion-ficha"></span>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-lg mg-t-10 text-center">
                                        <button class="btn btn-warning-gradient" id="btn-volver-listado-fichas" type="button"><i class="fa fa-th-list"></i> CANCELAR Y VOLVER</button>
                                        <button class="btn btn-success-gradient btn-movi" id="btn-guardar-ficha-medica" type="button" {{isset($certificado) ? ($certificado->aprobado ? "style=display:none;" : "") : '' }}><i class="fa fa-save"></i> {{isset($certificado) ? 'MODIFICAR': 'GUARDAR' }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- INICIO MODAL ADMINISTRAR CAUSAS  -->
<x-generico.modal_search_options 
    idModal="modal_administrar_causas" 
    btnAgregar="btn-add-causas" 
    actionAgregar="add_causa_medica"
    idFormulario='form-administrador-causas-medicas' 
    title='Administrar causas medicas' 
    buttonSelect='btn-selection-causa-medica'
    actionSelect='selectTrCausa'
    url='/get_search_causa_consulta_medica/1/200/{text}'
    :asyncronous="true"
    :columns="['Descripción']"
    :columnsData="['cm_descripcion']"
    :columnsSearchData="['cm_descripcion']"
    :columnsDataTransform="[]"
    nodeData="data"
    actionUpdate='update_causa_medica(${r["cm_id"]},"` + r["cm_descripcion"] + `")'
    actionDelete='delete_causa_medica(${r["cm_id"]})'
    :columnsDataset="['cm_id','cm_descripcion']"
    >
</x-generico.modal_search_options>
<!--FIN MODAL ADMINISTRAR CAUSAS -->

<!-- INICIO MODAL ADMINISTRAR DIAGNOSTICOS  -->
<x-generico.modal_search_options 
    idModal="modal_administrar_diagnosticos" 
    btnAgregar="btn-add-diagnostico" 
    actionAgregar="add_diagnostico_medico"
    idFormulario='form-administrador-diagnostico-medico' 
    title='Administrar diagnosticos medicos' 
    buttonSelect='btn-selection-diagnostico-medico'
    actionSelect='selectTrDiagnostico'
    url='/get_search_diagnostico_consulta_medica/1/200/{text}'
    :asyncronous="true"
    :columns="['CIE10', 'Descripción','Requiere CIE10']"
    :columnsData="['dm_cie10','dm_descripcion', 'dm_requiere_cie10']"
    :columnsSearchData="['dm_cie10','dm_descripcion']"
    :columnsDataTransform="['dm_requiere_cie10'=>'r[`dm_requiere_cie10`] == true? `SI`:`NO`']"
    nodeData="data"
    actionUpdate='update_diagnostico_medico(${r["dm_id"]},"` + r["dm_cie10"] + `","` + r["dm_descripcion"] + `",${r["dm_requiere_cie10"]})'
    actionDelete='delete_diagnostico_medico(${r["dm_id"]})'
    :columnsDataset="['dm_id','dm_cie10','dm_descripcion','dm_requiere_cie10']"
    >
</x-generico.modal_search_options>
<!--FIN MODAL ADMINISTRAR DIAGNOSTICOS -->

<!-- INICIO MODAL ADMINISTRAR MEDICOS  -->
<x-generico.modal_search_options 
    idModal="modal_administrar_medicos" 
    btnAgregar="btn_add_medico_consulta" 
    actionAgregar="add_medico_consulta"
    idFormulario='form-administrador-medico-consulta' 
    title='Administrar medicos' 
    buttonSelect='btn-selection-medico-consulta'
    actionSelect='selectTrMedicoConsulta'
    url='/get_search_medico_consulta_ficha/1/100/{text}'
    :asyncronous="true"
    :columns="['Cédula', 'Apellidos','Nombres','Sexo','Centro Medico']"
    :columnsData="['me_cedula','me_apellidos', 'me_nombres', 'me_sexo', 'me_centro_medico']"
    :columnsSearchData="['me_cedula','me_apellidos', 'me_nombres', 'me_centro_medico']"
    :columnsDataTransform="[]"
    nodeData="data"
    actionUpdate='update_medico_consulta(${r["me_id"]},"` + r["me_cedula"] + `","` + r["me_apellidos"] + `","` + r["me_nombres"] + `","` + r["me_sexo"] + `","` + r["me_centro_medico"] + `")'
    actionDelete='delete_medico_consulta(${r["me_id"]})'
    :columnsDataset="['me_id','me_apellidos','me_nombres','me_cedula']"
    >
</x-generico.modal_search_options>
<!--FIN MODAL ADMINISTRAR MEDICOS -->

<!-- INICIO MODAL AGREGAR MODIFICAR CAUSAS  -->
<x-administrador.medico.modal_modificar_causas_medicas>
</x-administrador.medico.modal_modificar_causas_medicas>
<!--FIN MODAL AGREGAR MODIFICAR  CAUSAS -->

<!-- INICIO MODAL AGREGAR MODIFICAR DIAGNOSTICOS  -->
<x-administrador.medico.modal_modificar_agregar_diagnosticos_medicos>
</x-administrador.medico.modal_modificar_agregar_diagnosticos_medicos>
<!--FIN MODAL AGREGAR MODIFICAR DIAGNOSTICOS -->

<!-- INICIO MODAL AGREGAR MODIFICAR MEDICOS  -->
<x-administrador.medico.modal_modificar_agregar_medicos_consulta>
</x-administrador.medico.modal_modificar_agregar_medicos_consulta>
<!--FIN MODAL AGREGAR MODIFICAR MEDICOS -->

<!-- INICIO MODAL CONFIRMAR GENERACION DE FICHA  -->
<x-generico.confirmation_emergent idModal="modal_confirmacion_generacion_certificado" message="Esta seguro de guardar este registro?" idBtnConfirm="btn_confirm_generate_certificate" idBtnCancel="btn_cancelar_generate_certificate">
</x-generico.confirmation_emergent>
<!-- FIN MODAL CONFIRMAR GENERACION DE FICHA  -->

<!-- INICIO MODAL CONFIRMAR ELIMINAR CAUSA MEDICA  -->
<x-generico.confirmation_emergent idModal="modal_confirmacion_deshabilitar_causa_medica" message="Esta seguro de eliminar esta Causa Médica?" idBtnConfirm="btn_confirm_deshabilitar_causa" idBtnCancel="btn_cancelar_deshabilitar_causa">
</x-generico.confirmation_emergent>
<!-- FIN MODAL CONFIRMAR ELIMINAR CAUSA MEDICA  -->

<!-- INICIO MODAL CONFIRMAR ELIMINAR MEDICO  -->
<x-generico.confirmation_emergent idModal="modal_confirmacion_deshabilitar_medico" message="Esta seguro de eliminar este Médico?" idBtnConfirm="btn_confirm_deshabilitar_medico" idBtnCancel="btn_cancelar_deshabilitar_medico">
</x-generico.confirmation_emergent>
<!-- FIN MODAL CONFIRMAR ELIMINAR MEDICO -->

<!-- INICIO MODAL CONFIRMAR ELIMINACION DIAGNOSTICO  -->
<x-generico.confirmation_emergent idModal="modal_confirmacion_deshabilitar_diagnostico" message="Esta seguro de eliminar este Diagnóstico Médico?" idBtnConfirm="btn_confirm_deshabilitar_diagnostico" idBtnCancel="btn_cancelar_deshabilitar_diagnostico">
</x-generico.confirmation_emergent>
<!-- FIN MODAL CONFIRMAR ELIMINACION DIAGNOSTICO  -->

<!-- INICIO MODAL VISOR PDF  -->
<x-generico.modal_iframe_view idModal="modal_view_pdf_certificado" idVisor="iframe_visor_certificado" titulo="Visor Certificado Médico">
</x-generico.modal_iframe_view>
<!-- FIN MODAL VISOR PDF  -->
@endsection

@section('js')
<script type='text/javascript' src='/js/Medico/registrar_ficha_medica.js'></script>
@endsection