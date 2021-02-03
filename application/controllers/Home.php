<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Home extends MY_Controller {

    /*
    |-------------------------------------------------------------------
    | Construct
    |-------------------------------------------------------------------
    | 
    */
    function __construct()
    {
        parent::__construct();
        $this->load->model('home_model');
    }

    /*
    |-------------------------------------------------------------------
    | Index
    |-------------------------------------------------------------------
    |
    */
	function index()
	{
        $data['title'] = 'Codeigniter 3 - PHPSpreadsheet';
        $data['transaction_list'] = $this->home_model->fetch_transactions();

        $this->load->view('frontend/homepage/header', $data);
        $this->load->view('frontend/homepage/content', $data);
        $this->load->view('frontend/homepage/footer', $data);
    }
    
    /*
    |-------------------------------------------------------------------
    | Import Excel
    |-------------------------------------------------------------------
    |
    */
	function import_excel()
	{
        $this->load->helper('file');

        /* Allowed MIME(s) File */
        $file_mimes = array(
            'application/octet-stream', 
            'application/vnd.ms-excel', 
            'application/x-csv', 
            'text/x-csv', 
            'text/csv', 
            'application/csv', 
            'application/excel', 
            'application/vnd.msexcel', 
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        if(isset($_FILES['uploadFile']['name']) && in_array($_FILES['uploadFile']['type'], $file_mimes)) {

            $array_file = explode('.', $_FILES['uploadFile']['name']);
            $extension  = end($array_file);

            if('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($_FILES['uploadFile']['tmp_name']);
            $sheet_data  = $spreadsheet->getActiveSheet(0)->toArray();
            $array_data  = [];

            for($i = 1; $i < count($sheet_data); $i++) {
                $data = array(
                    'name'       => $sheet_data[$i]['0'],
                    'price'      => $sheet_data[$i]['1'],
                    'qty'        => $sheet_data[$i]['2'],
                    'input_date' => $sheet_data[$i]['3']
                );
                $array_data[] = $data;
            }
            
            if($array_data != '') {
                $this->home_model->insert_transaction_batch($array_data);
            }
            $this->modal_feedback('success', 'Success', 'Data Imported', 'OK');
        } else {
            $this->modal_feedback('error', 'Error', 'Import failed', 'Try again');
        }
        redirect('/');
    }

    /*
    |-------------------------------------------------------------------
    | Export Excel
    |-------------------------------------------------------------------
    |
    */
	function export_excel()
	{
        /* Data */
        $data = $this->home_model->fetch_transactions();

        /* Spreadsheet Init */
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        /* Excel Header */
        $sheet->setCellValue('A1', '#');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Price');
        $sheet->setCellValue('D1', 'Quantity');
        $sheet->setCellValue('E1', 'Total');
        $sheet->setCellValue('F1', 'Date');
        
        /* Excel Data */
        $row_number = 2;
        foreach($data as $key => $row)
        {
            $sheet->setCellValue('A'.$row_number, $key+1);
            $sheet->setCellValue('B'.$row_number, $row['name']);
            $sheet->setCellValue('C'.$row_number, $row['price']);
            $sheet->setCellValue('D'.$row_number, $row['qty']);
            $sheet->setCellValue('E'.$row_number, $row['total']);
            $sheet->setCellValue('F'.$row_number, $row['input_date']);
        
            $row_number++;
        }

        /* Excel File Format */
        $writer = new Xlsx($spreadsheet);
        $filename = 'excel-report';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

}
