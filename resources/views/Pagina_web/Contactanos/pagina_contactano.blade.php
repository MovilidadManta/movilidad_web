@extends('Administrador.Layout.app_pagina_web')
@section('css')

@endsection


@section('content')
<section id="breadcrumb-section" class="breadcrumb-area breadcrumb-center">
    <div class="av-container">
        <div class="av-columns-area">
            <div class="av-column-12">
                <div class="breadcrumb-content">
                    <div class="breadcrumb-heading">
                        <h2>CONTACTANOS</h2>
                    </div>
                    <ol class="breadcrumb-list">
                        <li><a href="https://web.movilidadmanta.gob.ec">Inicio</a> &nbsp;&gt;&nbsp;</li>
                        <li class="active">Contactanos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div> <!-- container -->
</section>

<section id="post-section" class="post-section av-py-default blog-page">
    <div class="av-container width-t-100-n">
        <div class="av-columns-area wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div id="av-primary-content" class="av-column-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <p class="has-text-align-justify has-text-color margin-b-no justify" style="color:#009fe3;font-size:15px">Como parte de nuestro esfuerzo constante de comunicación directa y buscando tener una mayor cercanía con nuestras diferentes audiencias, ponemos a su disposición este servicio de contacto, por medio del cual nos puede manifestar sus dudas o inquietudes sobre las distintas áreas operativas de nuestra empresa.
                    De antemano agradecemos su interés por conocer más sobre los procedimientos y operación de nuestra empresa. Así mismo, le garantizamos un seguimiento detallado a sus comentarios. Continuamos firmes con el cambio, y ustedes forman parte fundamental del mismo</p>
                <div class="rt-container-fluid rt-tpg-container tpg-shortcode-main-wrapper rt-img-holder(height: 230px;)" id="rt-tpg-container-985975327" data-layout="layout1" data-grid-style="even" data-desktop-col="3" data-tab-col="2" data-mobile-col="1" data-sc-id="874">
                </div>
                <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even ">


                    <div class="rt-col-md-12 rt-col-sm-6 rt-col-xs-12 even-grid-item rt-grid-item margin-b-no">
                        <div class="rt-holder sha-no">
                            <div class="rt-detail pad25">
                                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                                <form class="form" novalidate id="form-contactano" method="POST" enctype="multipart/form-data">
                                    <div class="row marg-bot">
                                        <div class="col">
                                            <label class="color-ti" for=""><strong>Nombres</strong> </label>
                                            <input type="text" id="txt-nombre" name="txt-nombre" class="form-control" placeholder="Ingresar Nombres" aria-label="Ingresar Nombres">
                                        </div>
                                        <div class="col">
                                            <label class="color-ti"><strong>Apellidos</strong> </label>
                                            <input type="text" id="txt-apellido" name="txt-apellido" class="form-control" placeholder="Ingresar apellidos" aria-label="Ingresar apellidos">
                                        </div>
                                        <div class="col">
                                            <label class="color-ti"><strong>Correo</strong> </label>
                                            <input type="text" id="txt-correo" name="txt-correo" class="form-control" placeholder="Ingresar Correo" aria-label="Ingresar Correo">
                                        </div>
                                    </div>
                                    <div class="row marg-bot">
                                        <div class="col">
                                            <label class="color-ti"><strong>Ingrese su mensaje</strong> </label>
                                            <textarea type="text" id="txt-mensaje" name="txt-mensaje" class="form-control" placeholder="Ingresar Mensaje" rows="3" aria-label="Ingresar Mensaje"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 ">
                                        <div class="post-meta btn-ri">
                                            <span class="read-more">
                                                <a class="btn-noticia" id="btn-guardar-contactano"><strong>Enviar</strong> </a>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>
</section>

@endsection

@section('js')
<script type='text/javascript' src='/js/Contactano/pagina_contactanos.js'></script>
@endsection