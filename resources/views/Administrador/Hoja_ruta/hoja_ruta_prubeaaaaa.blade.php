<div class="text-wrap ta">
    <div class="example">
        <div class="panel panel-primary tabs-style-2">
            <div class=" tab-menu-heading">
                <div class="tabs-menu1">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs main-nav-line">
                        <li><a href="#jefe_inmediato" class="nav-link active" data-bs-toggle="tab">Jefe Inmediato</a>
                        </li>
                        <li><a href="#tthh" class="nav-link" data-bs-toggle="tab">Talento Humano</a></li>
                        <li><a href="#contabilidad" class="nav-link" data-bs-toggle="tab">Contabilidad</a></li>
                        <li><a href="#almacen_bodega" class="nav-link" data-bs-toggle="tab">Almacen y Bodega</a></li>
                        <li><a href="#tecnologia" class="nav-link" data-bs-toggle="tab">Recursos Técnologicos</a></li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="jefe_inmediato">
                    <div class="col-md-12">
                        <form class="form" novalidate id="form-jefe-inmediato" method="POST"
                            enctype="multipart/form-data">
                            <div class="text-wrap card-body">
                                <div class="example">
                                    <div class="panel panel-primary tabs-style-2">
                                        <h5 class="card-title mb-3" align="center">JEFE
                                            INMEDIATO
                                        </h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <td width="15%"><strong>Entrego los
                                                        archivos fisicos:</strong></td>
                                                <td width="15%" colspan="2">
                                                    <select name="select-entrega-archivo-fisico"
                                                        id="select-entrega-archivo-fisico" class="form-control">
                                                        <option value="0">SELECCIONE
                                                        </option>
                                                        <option value="1">SI
                                                        </option>
                                                        <option value="2">NO
                                                        </option>
                                                    </select>
                                                </td>
                                                <td width="10%" class="align-midle">
                                                    <strong>Nombres:</strong>
                                                </td>
                                                <td width="50%" class="align-midle">
                                                    JULIAN ANDRES CEDEPA CARDIALOGO
                                                    HUMILDE</td>
                                            </tr>

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Fecha de entrega:</strong>
                                                </td>
                                                <td width="25%" colspan="2">
                                                    <input class="form-control" name="txt-fecha-entrega"
                                                        id="txt-fecha-entrega" placeholder="Ingresar fecha de compra"
                                                        type="date" onkeypress="mayus(this);"></input>
                                                </td>
                                                <td width="10%" class="align-midle">
                                                    <strong>Cargo:</strong>
                                                </td>
                                                <td width="50%" class="align-midle">
                                                    ANALISTA DE TECNOLOGIA 3</td>
                                            </tr>

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Entrego informe
                                                        Final:</strong>
                                                </td>
                                                <td width="20%">
                                                    <select name="select-informe-final" id="select-informe-final"
                                                        class="form-control">
                                                        <option value="0">SELECCIONE
                                                        </option>
                                                        <option value="SI">SI
                                                        </option>
                                                        <option value="NO">NO
                                                        </option>
                                                    </select>
                                                </td>
                                                <td width="5%"><input type="file" class="" name="txt-ruta-informe-final"
                                                        id="txt-ruta-informe-final" data-max-file-size="3M" /></td>
                                                <td width="10%" class="align-midle">
                                                    <strong>Firma:</strong>
                                                </td>
                                                <td width="50%"></td>
                                            </tr>
                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Observacion:
                                                    </strong>
                                                </td>
                                                <td width="85%" colspan='4'>
                                                    <input class="form-control" name="txt-observacion-jefe-inmediato"
                                                        id="txt-observacion-jefe-inmediato"
                                                        placeholder="Ingresar observacion" type="text"
                                                        onkeypress="mayus(this);"></input>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mg-t-10" align="right">
                                <button class="btn btn-primary btn btn-success-gradient btn-movi"
                                    id="btn-guardar-jefe-inmediato" type="button"><i class="fa fa-save"></i>
                                    Guardar</button>
                                <!--<button class="btn btn-primary btn btn-success-gradient btn-movi" id="btn-guardar-o" type="button"><i class="fa fa-save"></i> Guardaeeeeeeer</button>-->
                                <!--<button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>-->
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="tthh">
                    <div class="col-md-12">
                        <form class="form" novalidate id="form-catalogo" method="POST" enctype="multipart/form-data">
                            <div class="text-wrap card-body">
                                <div class="example">
                                    <div class="panel panel-primary tabs-style-2">
                                        <h5 class="card-title mb-3" align="center">
                                            TALENTO HUMANO
                                        </h5>
                                        <table class="table table-bordered">

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Entrego Credencial:</strong>
                                                </td>
                                                <td width="20%" class="align-midle">
                                                    <select name="select-tipo-sistema-operativo"
                                                        id="select-tipo-sistema-operativo" class="form-control">
                                                        <option value="0">SELECCIONE
                                                        </option>
                                                        <option value="SI">SI
                                                        </option>
                                                        <option value="NO">NO
                                                        </option>
                                                    </select>
                                                </td>
                                                <td width="5%" class="align-midle">
                                                    <input type="file" class="" name="txt-ruta-foto" id="txt-ruta-foto"
                                                        data-max-file-size="3M" />
                                                </td>
                                                <td width="10%" rowspan="2" class="align-midle">
                                                    <strong>Nombres:</strong>
                                                </td>
                                                <td width="50%" rowspan="2" class="align-midle">
                                                    MAIRUXI MARIA LOPEZ CEDENO
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Declaración
                                                        Juramentada:</strong>
                                                </td>
                                                <td width="20%" class="align-midle">
                                                    <select name="select-tipo-sistema-operativo"
                                                        id="select-tipo-sistema-operativo" class="form-control">
                                                        <option value="0">SELECCIONE
                                                        </option>
                                                        <option value="SI">SI
                                                        </option>
                                                        <option value="NO">NO
                                                        </option>
                                                    </select>
                                                </td>
                                                <td width="5%" class="align-midle">
                                                    <input type="file" class="" name="txt-ruta-foto" id="txt-ruta-foto"
                                                        data-max-file-size="3M" />
                                                </td>

                                            </tr>

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Aviso de Salida
                                                        IESS:</strong>
                                                </td>
                                                <td width="20%" class="align-midle">
                                                    <select name="select-tipo-sistema-operativo"
                                                        id="select-tipo-sistema-operativo" class="form-control">
                                                        <option value="0">SELECCIONE
                                                        </option>
                                                        <option value="SI">SI
                                                        </option>
                                                        <option value="NO">NO
                                                        </option>
                                                    </select>
                                                </td>
                                                <td width="5%" class="align-midle">
                                                    <input type="file" class="" name="txt-ruta-foto" id="txt-ruta-foto"
                                                        data-max-file-size="3M" />
                                                </td>
                                                <td width="10%" class="align-midle">
                                                    <strong>Cargo:</strong>
                                                </td>
                                                <td width="50%" class="align-midle">
                                                    DIRECTORA DE TTHH</td>
                                            </tr>

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Dias de vacaciones no
                                                        gozados:</strong>
                                                </td>
                                                <td width="20%" class="align-midle">
                                                    <select name="select-tipo-sistema-operativo"
                                                        id="select-tipo-sistema-operativo" class="form-control">
                                                        <option value="0">SELECCIONE
                                                        </option>
                                                        <option value="SI">SI
                                                        </option>
                                                        <option value="NO">NO
                                                        </option>
                                                    </select>
                                                </td>
                                                <td width="5%" class="align-midle">
                                                    <input class="form-control" name="txt-observacion"
                                                        id="txt-observacion" placeholder="Ingresar dias de vacaciones"
                                                        type="text" onkeypress="mayus(this);"></input>
                                                </td>
                                                <td width="10%" rowspan="2" class="align-midle">
                                                    <strong>Firma de Directora de
                                                        TTHH:</strong>
                                                </td>
                                                <td width="50%" rowspan="2" class="align-midle">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Fecha de
                                                        Informe:</strong>
                                                </td>
                                                <td width="25%" colspan="2">
                                                    <input class="form-control" name="txt-fecha-compra"
                                                        id="txt-fecha-compra" placeholder="Ingresar fecha de compra"
                                                        type="date" onkeypress="mayus(this);"></input>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Observacion:
                                                    </strong>
                                                </td>
                                                <td width="85%" colspan='4'>
                                                    <input class="form-control" name="txt-observacion"
                                                        id="txt-observacion" placeholder="Ingresar observacion"
                                                        type="text" onkeypress="mayus(this);"></input>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mg-t-10" align="right">
                                <button class="btn btn-primary btn btn-success-gradient btn-movi"
                                    id="btn-guardar-jefe-inmediato" type="button"><i class="fa fa-save"></i>
                                    Guardar</button>
                                <!--<button class="btn btn-primary btn btn-success-gradient btn-movi" id="btn-guardar-o" type="button"><i class="fa fa-save"></i> Guardaeeeeeeer</button>-->
                                <!--<button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>-->
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="contabilidad">
                    <div class="col-md-12">
                        <form class="form" novalidate id="form-catalogo" method="POST" enctype="multipart/form-data">
                            <div class="text-wrap card-body">
                                <div class="example">
                                    <div class="panel panel-primary tabs-style-2">
                                        <h5 class="card-title mb-3" align="center">
                                            CONTABILIDAD
                                        </h5>
                                        <table class="table table-bordered">

                                            <tr>
                                                <td width="15%" rowspan="2" class="align-midle">
                                                    <strong>Saldo de anticipo de sueldo
                                                        por pagar:</strong>
                                                </td>
                                                <td width="15%" rowspan="2" class="align-midle">
                                                    <select name="select-tipo-sistema-operativo"
                                                        id="select-tipo-sistema-operativo" class="form-control">
                                                        <option value="0">SELECCIONE
                                                        </option>
                                                        <option value="SI">SI
                                                        </option>
                                                        <option value="NO">NO
                                                        </option>
                                                    </select>
                                                </td>
                                                <td width="20%" rowspan="2" class="align-midle">
                                                    <input class="form-control" name="txt-observacion"
                                                        id="txt-observacion" placeholder="Ingresar saldo" type="text"
                                                        onkeypress="mayus(this);"></input>
                                                </td>
                                                <td width="10%" class="align-midle">
                                                    <strong>Nombres</strong>
                                                </td>
                                                <td width="40%" class="align-midle">
                                                    Guillermo Ronaldo Cevallos Qiot
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="10%" class="align-midle">
                                                    <strong>Cargo</strong>
                                                </td>
                                                <td width="40%" class="align-midle">
                                                    Director Administrativo Financiero
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Fecha de
                                                        Informe:</strong>
                                                </td>
                                                <td width="25%" colspan="2" class="align-midle">
                                                    <input class="form-control" name="txt-fecha-compra"
                                                        id="txt-fecha-compra" placeholder="Ingresar fecha de compra"
                                                        type="date" onkeypress="mayus(this);"></input>
                                                </td>
                                                <td width="10%" class="align-midle">
                                                    <strong>Firma Director/a
                                                        Administrativa
                                                        Financiera:</strong>
                                                </td>
                                                <td width="40%" class="align-midle">
                                                </td>
                                            </tr>


                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Observacion:
                                                    </strong>
                                                </td>
                                                <td width="85%" colspan='4'>
                                                    <input class="form-control" name="txt-observacion"
                                                        id="txt-observacion" placeholder="Ingresar observacion"
                                                        type="text" onkeypress="mayus(this);"></input>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mg-t-10" align="right">
                                <button class="btn btn-primary btn btn-success-gradient btn-movi"
                                    id="btn-guardar-jefe-inmediato" type="button"><i class="fa fa-save"></i>
                                    Guardar</button>
                                <!--<button class="btn btn-primary btn btn-success-gradient btn-movi" id="btn-guardar-o" type="button"><i class="fa fa-save"></i> Guardaeeeeeeer</button>-->
                                <!--<button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>-->
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="almacen_bodega">
                    <div class="col-md-12">
                        <form class="form" novalidate id="form-catalogo" method="POST" enctype="multipart/form-data">
                            <div class="text-wrap card-body">
                                <div class="example">
                                    <div class="panel panel-primary tabs-style-2">
                                        <h5 class="card-title mb-3" align="center">
                                            GUARDALMACEN
                                        </h5>
                                        <table class="table table-bordered">

                                            <tr>
                                                <td width="15%" rowspan="2" class="align-midle">
                                                    <strong>Acta de entrega-recepcion de
                                                        bienes:</strong>
                                                </td>
                                                <td width="20%" rowspan="2" class="align-midle">
                                                    <select name="select-tipo-sistema-operativo"
                                                        id="select-tipo-sistema-operativo" class="form-control">
                                                        <option value="0">SELECCIONE
                                                        </option>
                                                        <option value="SI">SI
                                                        </option>
                                                        <option value="NO">NO
                                                        </option>
                                                    </select>
                                                </td>
                                                <td width="5%" rowspan="2" class="align-midle">
                                                    <input type="file" class="" name="txt-ruta-foto" id="txt-ruta-foto"
                                                        data-max-file-size="3M" />
                                                </td>
                                                <td width="10%" class="align-midle">
                                                    <strong>Nombres:</strong>
                                                </td>
                                                <td width="50%" class="align-midle">
                                                    MARIA DEL CARMEN GARCIA MECIABO
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="10%" class="align-midle">
                                                    <strong>Cargo:</strong>
                                                </td>
                                                <td width="50%" class="align-midle">
                                                    Directora de Guardalmacen
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Fecha de
                                                        Informe:</strong>
                                                </td>
                                                <td width="25%" class="align-midle" colspan="2">
                                                    <input class="form-control" name="txt-fecha-compra"
                                                        id="txt-fecha-compra" placeholder="Ingresar fecha de compra"
                                                        type="date" onkeypress="mayus(this);"></input>
                                                </td>
                                                <td width="10%" class="align-midle">
                                                    <strong>Firma de Director/a de
                                                        Guardalmacen:</strong>
                                                </td>
                                                <td width="50%" class="align-midle">

                                                </td>

                                            </tr>

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Observacion:
                                                    </strong>
                                                </td>
                                                <td width="85%" colspan='4'>
                                                    <input class="form-control" name="txt-observacion"
                                                        id="txt-observacion" placeholder="Ingresar observacion"
                                                        type="text" onkeypress="mayus(this);"></input>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mg-t-10" align="right">
                                <button class="btn btn-primary btn btn-success-gradient btn-movi"
                                    id="btn-guardar-jefe-inmediato" type="button"><i class="fa fa-save"></i>
                                    Guardar</button>
                                <!--<button class="btn btn-primary btn btn-success-gradient btn-movi" id="btn-guardar-o" type="button"><i class="fa fa-save"></i> Guardaeeeeeeer</button>-->
                                <!--<button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>-->
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="tecnologia">
                    <div class="col-md-12">
                        <form class="form" novalidate id="form-catalogo" method="POST" enctype="multipart/form-data">
                            <div class="text-wrap card-body">
                                <div class="example">
                                    <div class="panel panel-primary tabs-style-2">
                                        <h5 class="card-title mb-3" align="center">
                                            UNIDAD DE TECNOLOGIA DE LA INFORMACIÓN
                                        </h5>
                                        <table class="table table-bordered">

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Informe técnico:</strong>
                                                </td>
                                                <td width="20%" class="align-midle">
                                                    <select name="select-tipo-sistema-operativo"
                                                        id="select-tipo-sistema-operativo" class="form-control">
                                                        <option value="0">SELECCIONE
                                                        </option>
                                                        <option value="SI">SI
                                                        </option>
                                                        <option value="NO">NO
                                                        </option>
                                                    </select>
                                                </td>
                                                <td width="5%" class="align-midle">
                                                    <input type="file" class="" name="txt-ruta-foto" id="txt-ruta-foto"
                                                        data-max-file-size="3M" />
                                                </td>
                                                <td width="10%" class="align-midle">
                                                    <strong>Nombres:</strong>
                                                </td>
                                                <td width="50%" class="align-midle">
                                                    YORDY FREDDY ALMEIDA LOOR
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Gestor documental y correo
                                                        electronico
                                                        inhabilitado:</strong>
                                                </td>
                                                <td width="25%" colspan="2" class="align-midle">
                                                    <select name="select-tipo-sistema-operativo"
                                                        id="select-tipo-sistema-operativo" class="form-control">
                                                        <option value="0">SELECCIONE
                                                        </option>
                                                        <option value="SI">SI
                                                        </option>
                                                        <option value="NO">NO
                                                        </option>
                                                    </select>
                                                </td>

                                                <td width="10%" class="align-midle">
                                                    <strong>Cargo:</strong>
                                                </td>
                                                <td width="50%" class="align-midle">
                                                    ANALISTA DE TECNOLOGIA 3
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Fecha de
                                                        Informe:</strong>
                                                </td>
                                                <td width="25%" class="align-midle" colspan="2">
                                                    <input class="form-control" name="txt-fecha-compra"
                                                        id="txt-fecha-compra" placeholder="Ingresar fecha de compra"
                                                        type="date" onkeypress="mayus(this);"></input>
                                                </td>
                                                <td width="10%" class="align-midle">
                                                    <strong>Firma de director/a
                                                        TIC'S:</strong>
                                                </td>
                                                <td width="50%" class="align-midle">

                                                </td>

                                            </tr>

                                            <tr>
                                                <td width="15%" class="align-midle">
                                                    <strong>Observacion:
                                                    </strong>
                                                </td>
                                                <td width="85%" colspan='4'>
                                                    <input class="form-control" name="txt-observacion"
                                                        id="txt-observacion" placeholder="Ingresar observacion"
                                                        type="text" onkeypress="mayus(this);"></input>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mg-t-10" align="right">
                                <button class="btn btn-primary btn btn-success-gradient btn-movi"
                                    id="btn-guardar-jefe-inmediato" type="button"><i class="fa fa-save"></i>
                                    Guardar</button>
                                <!--<button class="btn btn-primary btn btn-success-gradient btn-movi" id="btn-guardar-o" type="button"><i class="fa fa-save"></i> Guardaeeeeeeer</button>-->
                                <!--<button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>-->
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>