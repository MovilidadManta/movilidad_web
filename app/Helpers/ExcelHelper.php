<?php

namespace App\Helpers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use \PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use \PhpOffice\PhpSpreadsheet\Chart\Layout;
use \PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use \PhpOffice\PhpSpreadsheet\Chart\Legend;
use \PhpOffice\PhpSpreadsheet\Chart\Title;
use \PhpOffice\PhpSpreadsheet\Chart\Chart;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;
use PHPExcel_Style_Alignment;

class ExcelHelper{


    public static function ContructSpreadsheet ($titulos, $columnasHeader, $FilasData, $formatosCeldas)
    {
        $spreadsheet = new Spreadsheet();

        foreach ($titulos as &$titulo) {
            $filaPrincipal = explode(":", $titulo["columns"])[0];
            $spreadsheet->setActiveSheetIndex(0)
            ->mergeCells($titulo["columns"]);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue($filaPrincipal, $titulo["value"]);
            $spreadsheet->getActiveSheet()->getStyle($titulo["columns"])->applyFromArray( $titulo["formato"]);
        }

        foreach ($columnasHeader as &$columnHeader) {
            $spreadsheet->getActiveSheet()
            ->setCellValue($columnHeader["column"], $columnHeader["value"]);
        }

        foreach ($FilasData as &$FilaData) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValueExplicit($FilaData["column"], $FilaData["value"], $FilaData["type"]);
        }

        foreach ($formatosCeldas as &$formatoCeldas) {
            $spreadsheet->getActiveSheet()->getStyle($formatoCeldas['columns'])->applyFromArray($formatoCeldas['format']);
        }

        return $spreadsheet;
    }

    public static function AddPieChart($sheet,$nameGrafico, $titleHeader, $yLabel, $legendPosition, $chartPositionTop, $chartPositionBottom, $showValues ,$arraySeriesLabels, $arraySeriesValues, $arrayxAxisTickValues){
        $dataSeriesLabels = [];
        $dataSeriesValues = [];
        $xAxisTickValues = [];

        foreach ($arraySeriesLabels as $i => $l) {
            $dataSeriesLabels[$i] = new DataSeriesValues($l['tipo'], $l['hojas'], null, $l['num_hojas']);
        }

        foreach ($arraySeriesValues as $i => $v) {
            $dataSeriesValues[$i] = new DataSeriesValues($v['tipo'], $v['hojas'], null, $v['num_hojas']);
        }

        foreach ($arrayxAxisTickValues as $i => $l) {
            $xAxisTickValues[$i] = new DataSeriesValues($l['tipo'], $l['hojas'], null, $l['num_hojas']);
        }

        $series = [new DataSeries(
            DataSeries::TYPE_PIECHART, // Tipo de gráfico
            null, // Agrupación (opcional)
            range(0, count($dataSeriesValues) - 1), // Índices de series (opcional)
            $dataSeriesLabels, // Etiquetas de series
            $xAxisTickValues,
            $dataSeriesValues // Valores de series
        )];

        $layout = new Layout();
        $layout->setShowVal($showValues); // Mostrar los valores en el gráfico
        $layout->setShowPercent(true); // Mostrar el porcentaje en el gráfico

        $plotArea = new PlotArea($layout, $series);
        $legend = new  Legend($legendPosition, null, false);

        $title = new  \PhpOffice\PhpSpreadsheet\Chart\Title($titleHeader);

        $yAxisLabel = new  \PhpOffice\PhpSpreadsheet\Chart\Title($yLabel);

        $chart = new Chart(
            $nameGrafico, // Nombre del gráfico
            $title, // Título del gráfico (opcional)
            $legend, // Leyenda del gráfico (opcional)
            $plotArea, // Valores del eje X (categoría) (opcional)
            true,  // Valores del eje Y (datos) (opcional)
            'gap',
            null,
            $yAxisLabel
        );

        $chart->setTopLeftPosition($chartPositionTop);
        $chart->setBottomRightPosition($chartPositionBottom);
        $sheet->addChart($chart);

        return $sheet;
    }

    public static function GetStyleEstiloTituloReporte(){
        return array(
            'font' => array(
                'name' => 'Verdana',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 14,
                'color' => array(
                    'rgb' => '090909'
                )
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => true
            )
        );
    }

    public static function GetStyleStyleArray(){
        return array(
            'font' => array(
                'size' => 12,
                'bold' => true,
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => true
            )
        );
    }

    public static function GetStyleStyleNegrita(){
        return array(
            'font' => array(
                'name' => 'Verdana',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 10,
                'color' => array(
                    'rgb' => '090909'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                    'bold' => true,
                )
            ),

        );
    }
}