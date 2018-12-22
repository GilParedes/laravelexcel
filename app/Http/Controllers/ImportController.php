<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
		dd($spreadsheet->getActiveSheet()->toArray(null, true, true, true));

	}

}
