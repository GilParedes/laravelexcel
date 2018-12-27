<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;

class ImportController extends Controller
{

	public function createExcel()
	{
	
	    $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');

		$writer = new Xlsx($spreadsheet);
		$writer->save('hello world.xlsx');

		return 'Format creado';

	}

	public function importExcel()
	{
		$inputFileType = 'Xlsx';

		$pathFileName = public_path('updateAvailabilityTemplate.xlsx');
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		$reader->setReadDataOnly(true);
		$spreadsheet = $reader->load($pathFileName);
		$mes = $spreadsheet->getActiveSheet()->getCell('B1')->getValue();
		$mess = Carbon::parse($mes)->month;
		$anio = $spreadsheet->getActiveSheet()->getCell('C1')->getValue();
		$dataArray = $spreadsheet->getActiveSheet()
		    ->rangeToArray(
		        'A2:AG20',     // The worksheet range that we want to retrieve
		        TRUE,        // Value that should be returned for empty cells
		        TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
		        TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
		        TRUE         // Should the array be indexed by cell row and cell column
		    );
			var_dump($mes, $anio);
		    foreach ($dataArray as $row) {
		    	//var_dump($row);
		    	if (isset($row)) {
		    		for ($i=1; $i <32 ; $i++) { 
		    		$fecha = Carbon::create($anio, 07, $i);
		    		var_dump($fecha);
		    	}
		    }
		    	
		    }

		//dd($mes, $anio, $dataArray);

	}

}
