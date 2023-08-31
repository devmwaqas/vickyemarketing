<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH.'/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(admin_controller().'report_model');
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'login');
		}

		if($this->session->userdata('admin_type') == 2) {
			redirect(admin_url().'dashboard');
		}
	}

	public function index()
	{
		$this->load->view('report/manage_report');
	}

	public function create_columns_range($start = 'A', $end = 'ZZ'){
		$return_range = [];
		for ($i = $start; $i !== $end; $i++){
			$return_range[] = $i;
		}
		return $return_range;
	}

	public function export_excel_report()
	{
		$data = $_GET;

		if(!empty($data['start_date'])) {
			$data['start_date'] = date('Y-m-d', strtotime($data['start_date']));
		} else {
			$data['start_date'] = date('Y-m-d');
		}
		if(!empty($data['end_date'])) {
			$data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
		} else {
			$data['end_date'] = date('Y-m-d');
		}

		$orders = $this->report_model->get_orders($data['start_date'], $data['end_date'], $data['status']);

		$objPHPExcel = new Spreadsheet();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.5);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.25);
		$objPHPExcel->getActiveSheet()->setShowGridlines(false);
		$heading_style = array(
			'font' => array(
				'color' => array('rgb' => '000000'),
				'size' => 20,
				'name' => 'Arial',
				'bold' => true,
			),
			'alignment' => array(
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			),
		);
		$default_border = array(
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			'color' => array('rgb' => '000000'),
		);
		$top_header_style = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'color' => array('rgb' => 'd8d8d8'),
			),
			'font' => array(
				'color' => array('rgb' => '000000'),
				'size' => 10,
				'name' => 'Arial',
				'bold' => true,
			),
			'alignment' => array(
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			),
		);
		$style_header = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'font' => array(
				'color' => array('rgb' => '000000'),
				'size' => 12,
				'name' => 'Arial',
				'bold' => false,
			),
			'alignment' => array(
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			),
		);
		$style_header_text_left = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'font' => array(
				'color' => array('rgb' => '000000'),
				'size' => 10,
				'name' => 'Arial',
				'bold' => false,
			),
			'alignment' => array(
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			),
		);
		$new_row = 1;
		$new_row2 = $new_row + 1;
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$new_row.':K'.$new_row);
		$objPHPExcel->getActiveSheet()->getRowDimension($new_row)->setRowHeight(30);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$new_row, 'Orders Report');
		$objPHPExcel->getActiveSheet()->getStyle('A'.$new_row)->applyFromArray($heading_style);
		$objPHPExcel->getActiveSheet()->getRowDimension($new_row2)->setRowHeight(30);

		$h = array();
		foreach($orders as $row){
			foreach($row as $key=>$val){
				if(!in_array($key, $h)){
					$h[] = str_replace("_", " ", $key);
				}
			}
			break;
		}

		$h[] = 'Commission';

		$alphabet = 0;
		$alphabets = $this->create_columns_range('A', 'ZZ');

		foreach($h as $key) {
			$key = ucwords($key);
			$objPHPExcel->getActiveSheet()->setCellValue($alphabets[$alphabet].$new_row2, $key);
			$objPHPExcel->getActiveSheet()->getStyle($alphabets[$alphabet].$new_row2)->applyFromArray($top_header_style);
			$alphabet++;
		}
		$new_row3 = $new_row2 + 1;
		foreach($orders as $row) {
			$alphabet = 0;
			foreach($row as $key=>$val) {
				if($alphabets[$alphabet] == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($alphabets[$alphabet].$new_row3)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
				}

				if($key == 'Order_SS_URL' || $key == 'Review_SS_URL' || $key == 'Refund_SS_URL') {
					$val = base_url()."assets/pictures/".$val;
				}

				if($key == 'order_status' && $val == 0) {
					$val = "Ordered";
				} elseif($key == 'order_status' && $val == 1) {
					$val = "Reviewed";
				} elseif($key == 'order_status' && $val == 2) {
					$val = "On Hold";
				} elseif($key == 'order_status' && $val == 3) {
					$val = "Canceled";
				} elseif($key == 'order_status' && $val == 4) {
					$val = "Refunded";
				} elseif($key == 'order_status' && $val == 5) {
					$val = "Completed";
				}

				$objPHPExcel->getActiveSheet()->setCellValue($alphabets[$alphabet].$new_row3, $val);
				$objPHPExcel->getActiveSheet()->getStyle($alphabets[$alphabet].$new_row3)->applyFromArray($style_header_text_left);
				$alphabet++;
			}

			$objPHPExcel->getActiveSheet()->setCellValue($alphabets[$alphabet].$new_row3, "");
			$objPHPExcel->getActiveSheet()->getStyle($alphabets[$alphabet].$new_row3)->applyFromArray($style_header_text_left);
			$new_row3++;
		}


		foreach (range('A','Q') as $col) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}

		$file_name = 'orders-report'.date('mdY');
		ob_start();
		$writer = new Xlsx($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename='.$file_name.'.xlsx');
		header('Cache-Control: max-age=0');
		ob_end_clean();
		$writer->save('php://output');
	}

}