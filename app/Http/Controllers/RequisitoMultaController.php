<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequisitoMultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Pagina_web.Requisitos.pagina_requisito_multa');
    }

    public function requisito_id($id)
    {
        if ($id == 1) {
            $requisito = 'EXONERACIÓN DE PARQUEO';
        } else if ($id == 2) {
            $requisito = 'ACTUALIZACIÓN DE DATOS';
        } else if ($id == 3) {
            $requisito = 'CERTIFICACIÓN DE CORREO';
        } else if ($id == 4) {
            $requisito = 'CONVENIO DE PAGO';
        } else if ($id == 5) {
            $requisito = 'LEVANTAMIENTO DE GRAVAMEN DE CARRO';
        } else if ($id == 6) {
            $requisito = 'LEVANTAMIENTO DE GRAVAMEN DE MOTO';
        } else if ($id == 7) {
            $requisito = 'TRASPASO DE MULTA';
        } else if ($id == 8) {
            $requisito = 'DESVINCULACIÓN DE MULTA';
        } else if ($id == 9) {
            $requisito = 'ANULACIÓN DE MULTA POR ERROR DE  DIGITACIÓN';
        }
        return view('Pagina_web.Requisitos.pagina_requisito_id', compact('requisito', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}