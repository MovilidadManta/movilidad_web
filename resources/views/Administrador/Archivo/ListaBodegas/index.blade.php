@extends('Administrador.Layout.app')

@section('css')
@endsection

@section('content')
<!-- main-content -->

<!-- container -->
<div class="main-container">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto col-md-12">
            <div class="d-flex">
                <div class="col-xs-12">
                    <h2 class="content-title mb-0 my-auto color-titulo">Lista de Bodegas</h2>
                </div>
            </div>
        </div>


    </div>
    <!-- breadcrumb -->

    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <!--div-->
            <div class="card">
                <div class="card-body">
                    <div class="row row-sm">

                        @foreach($bodegas as $b)
                        <div class="col-xs-12 col-md-2 col-lg-4">
                            <div class="card h-100 text-center">
                                <img class="card-img-top w-100" src="{{asset('Imagenes/archivo/bodega.jpg')}}" alt="">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h4 class="card-title mb-3">{{$b->archivo}}</h4>
                                    <p class="card-text">{{$b->ubicacion}}.</p>
                                    <a class="btn btn-primary" href="{{$prefix}}{{$b->id}}">Seleccionar bodega</a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>

                </div>
            </div>
        </div>
        <!--/div-->
    </div>
<!-- End Row -->
</div>
<!-- Container closed -->
@endsection