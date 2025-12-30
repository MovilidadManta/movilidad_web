<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Sheet;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use DB;
use Carbon\Carbon;

class ImportarArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function importar_archivo_RTV()
    {
        require 'PHPExcel/Classes/PHPExcel.php';
        $nombreArchivo = 'RTV_MANTA_TAXIS.xlsx';

        $inputFileType = PHPExcel_IOFactory::identify($nombreArchivo);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($nombreArchivo);

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow_columna = $sheet->getHighestColumn();
        $highestRow_fila = $sheet->getHighestRow();
        $date = Carbon::now();

        for ($fila = 2; $fila <= $highestRow_fila; $fila++) {



            $id_pregunta = DB::table('pre_preguntas')->insertGetId([
                'pregunta' => $sheet->getCell("B" . $fila)->getValue(),
                'id_tipo' => 2,
                'id_proyecto' => 9,
                'estado_preguntas' => 0,
                'estado' => 1,
                'created_at' => $date,
                'tipo' => "P"

            ]);
            echo "" . $sheet->getCell("A" . $fila)->getValue() . " Id pregunta - " . $id_pregunta;
            echo "<br>";

            if ($id_pregunta != 0) {
                /* Opcion 1
                $id_opcion1 = DB::table('pre_opciones')->insertGetId([
                    'opcion' => $sheet->getCell("H" . $fila)->getValue(),
                    'value' =>  $sheet->getCell("H" . $fila)->getValue(),
                    'estado' => 1,
                    'id_pregunta' => $id_pregunta,
                    'tipo_respuesta_opcion' => $sheet->getCell("I" . $fila)->getValue(),
                    'opcion_pregunta' => 1,
                    'created_at' => substr($date, 0, 255)
                ]);
                echo "" . $sheet->getCell("H" . $fila)->getValue() . " Id Opcion 1" . $id_opcion1;
                echo "<br>";*/

                // Opcion 2
                /*$date = Carbon::now();
                $id_opcion2 = DB::table('pre_opciones')->insertGetId([
                    'opcion' => $sheet->getCell("K" . $fila)->getValue(),
                    'value' =>  $sheet->getCell("K" . $fila)->getValue(),
                    'estado' => 1,
                    'id_pregunta' => $id_pregunta,
                    'tipo_respuesta_opcion' => $sheet->getCell("L" . $fila)->getValue(),
                    'opcion_pregunta' => 1,
                    'created_at' => substr($date, 0, 255)

                ]);
                echo "" . $sheet->getCell("K" . $fila)->getValue() . " Id Opcion 2" . $id_opcion2;
                echo "<br>";*/


                /* Opcion 3
                $id_opcion3 = DB::table('pre_opciones')->insertGetId([
                    'opcion' => $sheet->getCell("N" . $fila)->getValue(),
                    'value' =>  $sheet->getCell("N" . $fila)->getValue(),
                    'estado' => 1,
                    'id_pregunta' => $id_pregunta,
                    'tipo_respuesta_opcion' => $sheet->getCell("I" . $fila)->getValue(),
                    'opcion_pregunta' => 1,
                    'created_at' => substr($date, 0, 255)

                ]);
                echo "" . $sheet->getCell("O" . $fila)->getValue() . " Id Opcion 3" . $id_opcion3;
                echo "<br>";*/
            }
        }

        // return $nombreArchivo;
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
