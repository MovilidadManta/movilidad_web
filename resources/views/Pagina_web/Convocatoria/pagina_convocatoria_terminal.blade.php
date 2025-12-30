@extends('Administrador.Layout.app_pagina_web')
@section('css')
<style>
    .breadcrumb-area {
        background-image: url(./Imagenes/banner.jpg);
        background-attachment: scroll;
    }

    .flex {
        display: flex !important;
    }

    .jcontent_end {
        justify-content: end;
    }

    .w2em {
        width: 2em;
    }

    .pdf {
        color: #f44336 !important;
        font-size: 35px !important;
    }

    .jcontent_end {
        justify-content: center !important;
    }
</style>

<!-- imgaen 1920x300 px-->

@endsection


@section('content')
<section id="breadcrumb-section" class="breadcrumb-area breadcrumb-center">
    <div class="av-container">
        <div class="av-columns-area">
            <div class="av-column-12">
                <div class="breadcrumb-content">
                    <div class="breadcrumb-heading">

                        <h2>CONVOCATORIAS DE ARRENDAMIENTOS</h2>

                    </div>

                    <ol class="breadcrumb-list">
                        <li></li>
                        <li class="active"></li>
                    </ol>
                </div>
            </div>
        </div>
    </div> <!-- container -->
</section>

<section id="post-section" class="post-section av-py-default-100 blog-page">
    <div class="av-container width-t-100-n">
        <div class="av-columns-area wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div id="av-primary-content" class="av-column-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <div class="rt-container-fluid rt-tpg-container tpg-shortcode-main-wrapper rt-img-holder(height: 230px;)" id="rt-tpg-container-985975327" data-layout="layout1" data-grid-style="even" data-desktop-col="3" data-tab-col="2" data-mobile-col="1" data-sc-id="874">
                </div>
                <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even ">
                    <div class="rt-col-md-12 rt-col-sm-6 rt-col-xs-12 even-grid-item rt-grid-item margin-b-no" data-id="1943">
                        <div class="rt-holder ">
                            <div class="rt-detail">
                                <div class="post-meta-user  ">
                                    <span class="date"><i class="far fa-calendar-alt"></i>
                                        La Empresa Pública Municipal Movilidad de Manta EP, presenta las siguientes
                                        convocatorias a todos los interesados a
                                        participar en el proceso de arrendamiento.</span>
                                </div>
                                <div class="tpg-excerpt">
                                    <table class="responsive">
                                        <tbody>
                                            @foreach ($arrendamientos as $arrendamiento)
                                            <tr>
                                                <td width="80%">
                                                    <span>{{$arrendamiento->ca_descripcion}}</span>
                                                </td>
                                                <td class="flex jcontent_end">
                                                    <a target="_blank" href="/convocatoria_arrendamiento/archivo/{{$arrendamiento->ca_nombre_archivo}}">
                                                        <i class="fa fa-file-pdf-o pdf"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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

@endsection