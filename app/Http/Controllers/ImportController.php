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

		//define la extención del archivo
		$inputFileType = 'Xlsx';
		//obtinene la ruta del archivo cargado
		$pathFileName = public_path('updateAvailabilityTemplate.xlsx');
		//procesa el archivo para ser leído
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		$reader->setReadDataOnly(true);
		$spreadsheet = $reader->load($pathFileName);
		$mes = $spreadsheet->getActiveSheet()->getCell('B1')->getValue();
		// convierte mes de string a entero
		$nmes = date('m',strtotime($mes));
		//return $nmes;
		$anio = $spreadsheet->getActiveSheet()->getCell('C1')->getValue();
		$dataArray = $spreadsheet->getActiveSheet()
		    ->rangeToArray(
		        'A3:AG20',     // The worksheet range that we want to retrieve
		        TRUE,        // Value that should be returned for empty cells
		        TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
		        TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
		        TRUE         // Should the array be indexed by cell row and cell column
		    );
			//var_dump($mes, $anio);
		    foreach ($dataArray as $row) {

		    	var_dump($row);

				    	
		  }
	}


	public function importInterators()
	{
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
		$reader->setReadDataOnly(TRUE);
		$pathFileName = public_path('updateAvailabilityTemplate.xlsx');
		$spreadsheet = $reader->load($pathFileName);

		$worksheet = $spreadsheet->getActiveSheet();
		//dd($worksheet);
		echo '<table>' . PHP_EOL;
		foreach ($worksheet->getRowIterator(3) as $row) {
			echo '<tr>' . PHP_EOL;
			   $cellIterator = $row->getCellIterator();
			   //var_dump(($cellIterator));
    		   $cellIterator->setIterateOnlyExistingCells(FALSE);

    		foreach ($cellIterator as $cell) {
		        echo '<td>' .
		       	$cell->getValue()	.
		        '</td>' . PHP_EOL;
		        
		    }
		    echo '</tr>' . PHP_EOL;
		}
		echo '</table>' . PHP_EOL;

	}

	public function importIndexes()
	{
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
		$reader->setReadDataOnly(TRUE);
		$pathFileName = public_path('updateAvailabilityTemplate.xlsx');
		$spreadsheet = $reader->load($pathFileName);

		$worksheet = $spreadsheet->getActiveSheet();
		// Get the highest row and column numbers referenced in the worksheet
		$highestRow = $worksheet->getHighestRow(); // e.g. 10
		$highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

		echo '<table>' . "\n";
		for ($row = 1; $row <= $highestRow; ++$row) {
		    echo '<tr>' . PHP_EOL;
		    for ($col = 1; $col <= $highestColumnIndex; ++$col) {
		        $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
		        echo '<td>' . $value . '</td>' . PHP_EOL;
		    }
		    echo '</tr>' . PHP_EOL;
		}
		echo '</table>' . PHP_EOL;
	}

	public function importCordenadas()
	{
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
		$reader->setReadDataOnly(TRUE);
		$pathFileName = public_path('updateAvailabilityTemplate.xlsx');
		$spreadsheet = $reader->load($pathFileName);

		$mes = $spreadsheet->getActiveSheet()->getCell('B1')->getValue();
		// convierte mes de string a entero
		$nmes = date('m',strtotime($mes));
		//return $nmes;
		$anio = $spreadsheet->getActiveSheet()->getCell('C1')->getValue();
		var_dump($nmes, $anio);
		$worksheet = $spreadsheet->getActiveSheet();
		// Get the highest row number and column letter referenced in the worksheet
		$highestRow = $worksheet->getHighestRow(); // e.g. 10
		$highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
		// Increment the highest column letter
		$highestColumn++;


		for ($row = 3; $row <= $highestRow; ++$row) {

			$dia = 0;
		    for ($col = 'A'; $col != $highestColumn; ++$col) {

		    	$data = $worksheet->getCell($col . $row)
		                 ->getValue();

		    		if ($col  == 'A') {
		    			$Room_id = $worksheet->getCell($col . $row)
		                 ->getValue();
		    			var_dump($Room_id);
		    		}
		    		if ($data == 'c/o' || $data == null) {
		                //var_dump($data);
		                $fecha = Carbon::create($anio, $nmes, $dia++);
		                var_dump($fecha);
		            }
		            if ($data == null) {
		            	$status = 1;
		            	var_dump($status);
		            }
		            if ($data == 'c/o'){
		            	$status = 0;
		            	var_dump($status);
		            }
		                 
		    }

		}

	}

}


/*if (isset($frow)) {
				    		var_dump(count($frow));
				    		for ($i=1; $i <32 ; $i++) { 
				    		$fecha = Carbon::create($anio, $nmes, $i);
				    		var_dump($fecha);
				    		}
				    	}*/
