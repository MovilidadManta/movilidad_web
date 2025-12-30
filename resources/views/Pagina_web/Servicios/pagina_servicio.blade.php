@extends('Administrador.Layout.app_pagina_web')
@section('css')
<style>
    a {
        text-decoration: none;
    }
</style>

@endsection


@section('content')
<section id="breadcrumb-section" class="breadcrumb-area breadcrumb-center">
    <div class="av-container">
        <div class="av-columns-area">
            <div class="av-column-12">
                <div class="breadcrumb-content">
                    <div class="breadcrumb-heading">
                        <h2>SERVICIOS</h2>
                    </div>
                    <ol class="breadcrumb-list">
                        <li><a href="/">Inicio</a> &nbsp;&gt;&nbsp;</li>
                        <li class="active">SERVICIOS</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="post-section" class="post-section av-py-default blog-page">
    <div class="av-container width-t-100-n">
        <div class="av-columns-area wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div id="av-primary-content" class="av-column-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <div class="rt-container-fluid rt-tpg-container tpg-shortcode-main-wrapper rt-img-holder(height: 230px;)" id="rt-tpg-container-985975327" data-layout="layout1" data-grid-style="even" data-desktop-col="3" data-tab-col="2" data-mobile-col="1" data-sc-id="874">
                </div>
                <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even ">
                    @foreach($servicio as $data)
                    <div class="rt-col-md-4 rt-col-sm-6 rt-col-xs-12 even-grid-item rt-grid-item margin-b-no" data-id="1943">
                        <div class="rt-holder sha-no">
                            <div class="rt-detail pad-no" align="center">
                                <img src="{{$data->ser_imagen}}" alt="" style="    height: 3em;" align="center">
                                <div class="align-ce">
                                    <a class="color-ti" target="_blank" href="{{$data->ser_enlace}}">
                                        <span class="date color-des"><i class="far fa-calendar-alt"></i>
                                            <strong clas="">{{$data->ser_descripcion}}</strong>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('js')

@endsection