{{$update}}
<div class="modal" id="modal-cooperativa{{$update ? '-m': ''}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar Cooperativas</h1>
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
                    id="csrf-token"
                >
                <form
                    class="form"
                    novalidate
                    id="form-cooperativa{{$update ? '-m': ''}}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @if($update)
                        <input type="hidden" name="txt-id-cooperativa-m" id="txt-id-cooperativa-m">
                        <input type="hidden" name="txt-foto-anterior" id="txt-foto-anterior">
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Foto</strong>
                            <strong> (La foto debera tener una dimension de 1535 X 512 PX)</strong>
                            <input
                                type="file"
                                class="dropify"
                                name="txt-file-foto{{$update ? '-m': ''}}"
                                id="txt-file-foto{{$update ? '-m': ''}}"
                                data-max-file-size="3M"
                            >
                        </div>
                        <div class="col-md-8 mg-t-10">
                            <strong>Nombre</strong>
                            <input
                                class="form-control"
                                name="txt-nombre{{$update ? '-m': ''}}"
                                id="txt-nombre{{$update ? '-m': ''}}"
                                placeholder="Ingresar nombre de la cooperativa"
                                type="text"
                            >
                        </div>
                        <div class="col-md-4 mg-t-10">
                            <strong>Codigo</strong>
                            <input
                                class="form-control"
                                name="txt-codigo{{$update ? '-m': ''}}"
                                id="txt-codigo{{$update ? '-m': ''}}"
                                placeholder="Ingresar codigo del anden"
                                type="text"
                            >
                        </div>
                        <div class="col-md-4 mg-t-10">
                            <strong>Abreviatura</strong>
                            <input
                                class="form-control"
                                name="txt-abreviatura{{$update ? '-m': ''}}"
                                id="txt-abreviatura{{$update ? '-m': ''}}"
                                placeholder="Ingresar nombre de abreviatura"
                                type="text"
                            >
                        </div>
                        <div class="col-md-4 mg-t-10">
                            <strong>Tipo</strong>
                            <select name="select-tipo{{$update ? '-m': ''}}" id="select-tipo{{$update ? '-m': ''}}" class="form-control">
                                <option value="0">Seleccione tipo</option>
                                <option value="1">Interprovincial</option>
                                <option value="2">Intracantonal</option>
                            </select>
                        </div>
                        <div class="col-md-4 mg-t-10">
                            <strong>Estado</strong>
                            <select name="select-estado{{$update ? '-m': ''}}" id="select-estado{{$update ? '-m': ''}}" class="form-control">
                                <option value="0">Seleccione Estado</option>
                                <option value="A">Activo</option>
                                <option value="I">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-4 mg-t-10">
                            <strong>Correo</strong>
                            <input
                                class="form-control"
                                name="txt-correo{{$update ? '-m': ''}}"
                                id="txt-correo{{$update ? '-m': ''}}"
                                placeholder="Ingresar correo"
                                type="text"
                            >
                        </div>
                        <div class="col-md-4 mg-t-10">
                            <strong>Convencional</strong>
                            <input
                                class="form-control"
                                name="txt-convencional{{$update ? '-m': ''}}"
                                id="txt-convencional{{$update ? '-m': ''}}"
                                placeholder="Ingresar Convencional"
                                type="text"
                            >
                        </div>
                        <div class="col-md-4 mg-t-10">
                            <strong>Celular</strong>
                            <input
                                class="form-control"
                                name="txt-celular{{$update ? '-m': ''}}"
                                id="txt-celular{{$update ? '-m': ''}}"
                                placeholder="Ingresar celular"
                                type="text"
                            >
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Ubicación</strong>
                            <input
                                class="form-control"
                                name="txt-ubicacion{{$update ? '-m': ''}}"
                                id="txt-ubicacion{{$update ? '-m': ''}}"
                                placeholder="Ingresar ubicación de la cooperativa"
                                type="text"
                            >
                        </div>
                        <div class="col-md-4 mg-t-10">
                            <strong>Realiza Encomienda?</strong>
                            <select name="select-estado-encomienda{{$update ? '-m': ''}}" id="select-estado-encomienda{{$update ? '-m': ''}}" class="form-control">
                                <option value="0">Seleccione tipo</option>
                                <option value="SI">Si</option>
                                <option value="NO">No</option>
                            </select>
                        </div>
                        <div class="col-md-8 mg-t-10">
                            <strong>Ubicación de encomienda</strong>
                            <input
                                class="form-control"
                                name="txt-ubicacion-encomienda{{$update ? '-m': ''}}"
                                id="txt-ubicacion-encomienda{{$update ? '-m': ''}}"
                                placeholder="Ingresar ubicación de encomienda"
                                type="text"
                            >
                        </div>
                        <div class="col-md-12 mg-t-10" id="container-horario-encomienda{{$update ? '-m': ''}}" style="display: none;">
                            <strong>Horarios encomienda:</strong>
                            <div class="row">
                                <div class="col-sm-12">
                                    <strong>Días:</strong>
                                    <div class="d-flex justify-content-around align-items-center flex-wrap">
                                        <div class="form-check">
                                            <input type="checkbox" value="Lunes" name="check-horario-encomienda{{$update ? '-m': ''}}-lunes" id="check-horario-encomienda{{$update ? '-m': ''}}-lunes" checked>
                                            <label for="check-horario-encomienda{{$update ? '-m': ''}}-lunes">
                                                Lunes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" value="Martes" name="check-horario-encomienda{{$update ? '-m': ''}}-martes" id="check-horario-encomienda{{$update ? '-m': ''}}-martes" checked>
                                            <label for="check-horario-encomienda{{$update ? '-m': ''}}-martes">
                                                Martes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" value="Miercoles" name="check-horario-encomienda{{$update ? '-m': ''}}-miercoles" id="check-horario-encomienda{{$update ? '-m': ''}}-miercoles" checked>
                                            <label for="check-horario-encomienda{{$update ? '-m': ''}}-miercoles">
                                                Miercoles
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" value="Jueves" name="check-horario-encomienda{{$update ? '-m': ''}}-jueves" id="check-horario-encomienda{{$update ? '-m': ''}}-jueves" checked>
                                            <label for="check-horario-encomienda{{$update ? '-m': ''}}-jueves">
                                                Jueves
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" value="Viernes" name="check-horario-encomienda{{$update ? '-m': ''}}-viernes" id="check-horario-encomienda{{$update ? '-m': ''}}-viernes" checked>
                                            <label for="check-horario-encomienda{{$update ? '-m': ''}}-viernes">
                                                Viernes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" value="Sabados" name="check-horario-encomienda{{$update ? '-m': ''}}-sabados" id="check-horario-encomienda{{$update ? '-m': ''}}-sabados">
                                            <label for="check-horario-encomienda{{$update ? '-m': ''}}-sabados">
                                                Sabados
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" value="Domingos" name="check-horario-encomienda{{$update ? '-m': ''}}-domingos" id="check-horario-encomienda{{$update ? '-m': ''}}-domingos">
                                            <label for="check-horario-encomienda{{$update ? '-m': ''}}-domingos">
                                                Domingos
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <strong>Desde:</strong>
                                    <input
                                        class="form-control"
                                        name="txt-desde-horario{{$update ? '-m': ''}}"
                                        id="txt-desde-horario{{$update ? '-m': ''}}"
                                        placeholder="Ingresar horario Desde"
                                        type="time"
                                    >
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <strong>Hasta:</strong>
                                    <input
                                        class="form-control"
                                        name="txt-hasta-horario{{$update ? '-m': ''}}"
                                        id="txt-hasta-horario{{$update ? '-m': ''}}"
                                        placeholder="Ingresar horario Hasta"
                                        type="time"
                                        disabled
                                    >
                                </div>
                                <div class="col-sm-12 col-md-3 text-center marg-a">
                                    <a class="btn background-btn-nuevo pad-nu " id="btn-guardar-horario-encomienda-cooperativa{{$update ? '-m': ''}}">
                                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                                        <strong class="color-btn-nuevo" id="text-btn-añadir{{$update ? '-m': ''}}">Añadir</strong>
                                    </a>
                                </div>
                                <div class="mg-t-30" id="div-table-horario-encomienda{{$update ? '-m': ''}}">
                                    <table border="2" class="table">
                                        <thead class="background-thead">
                                            <tr align="center">
                                                <th align="center" class="border-bottom-0 color-th">Horario</th>
                                                <th align="center" class="border-bottom-0 color-th">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-encomienda-horario{{$update ? '-m': ''}}" data-id='0'>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <input id="horario-encomienda{{$update ? '-m': ''}}" name="horario-encomienda{{$update ? '-m': ''}}" type="hidden" value="" />
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Observacion</strong>
                            <textarea
                                class="form-control"
                                id="txt-observacion{{$update ? '-m': ''}}"
                                name="txt-observacion{{$update ? '-m': ''}}"
                                rows="6"
                                placeholder="Ingresar Descripción"
                            ></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-{{$update ? 'modificar': 'guardar'}}-cooperativa" type="button">
                    <i class="fa {{$update ? 'fa-edit': 'fa-save'}}"></i> {{$update ? 'Modificar': 'Guardar'}}
                </button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>