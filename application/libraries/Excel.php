<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once APPPATH."/third_party/Classes/PHPExcel.php";

class Excel extends PHPExcel {

    public function __construct() {
        parent::__construct();
    }

    /*
	* Function Name : readExcelFile
	* ParamName 	: fileName
	* Return        : Exceldata in Array
	*/
	
	public function readExcelFile($fileName)
	{	
		$file = $fileName;
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		
		//------------ Get value in PHP Array --------------
		
		foreach ($cell_collection as $cell) 
		{
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

			if ($row == 1) 
			{
				$header[$row][$column] = $data_value;
			} 
			else 
			{
				$arr_data[$row][$column] = $data_value;
			}
		}
		
		$data['header'] = $header;
		$data['values'] = $arr_data;
		return $data;
	}
	
	/*
	* Function Name : createExcelFile
	*/
	public function createExcelFile($data)
	{
		$this->setActiveSheetIndex(0);
		$this->getActiveSheet()->setTitle('worksheet');

		$char='A';
		foreach($data[0] as $key=>$val)
		{
			$this->getActiveSheet()->setCellValue($char.'1', strtoupper($key));
			$this->getActiveSheet()->getStyle($char.'1')->getFont()->setSize(12);
			$this->getActiveSheet()->getStyle($char.'1')->getFont()->setBold(true);	
			$char++;	
		}
		
		$i = 2;
		foreach($data as $key=>$val) 
		{
			$char='A';
			foreach($data[$key] as $key=>$val)
			{
				$this->getActiveSheet()->setCellValue($char.$i, $val);
				$char++;					
			}
			$i++;
		}
		$filename = 'user_report.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"'); 
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel5');  
		$objWriter->save('php://output');
	}


	/*
	* Function Name : createExcelFileForReport For Different Use
	* Param 1 : For Database Array Data
	* Param 2 : For File Name & Worksheet Name Array
	*/
	public function createExcelFileForPayment($data,$data1)
	{
		ob_end_clean();
		$this->setActiveSheetIndex(0);
		$this->getActiveSheet()->setTitle($data1['worksheet_name']);
		
		$this->getActiveSheet()->freezePane('A2');
	
		$char='A';
		//------------ For Title ---------
		foreach($data[0] as $key=>$val)
		{
			//echo $char."=".$val."<br>";
			$this->getActiveSheet()->getColumnDimension($char)->setAutoSize(true);
			$this->getActiveSheet()->setCellValue($char.'1',$val);
			$this->getActiveSheet()->getStyle($char.'1')->getFont()->setSize(13);
			$this->getActiveSheet()->getStyle($char.'1')->getFont()->setBold(true);	
			$char++;	
		}
		//------------ End For Title ---------
		
		$i = 3;
		foreach($data as $key=>$val) 
		{
			if($key != 0){
				$char='A';
				foreach($data[$key] as $key=>$val)
				{
					if($key == 'status'){
						if($val == '0'){
							$val = "Not Paid";
							$this->getActiveSheet()->getStyle($char.$i)->applyFromArray(array('font' => array('color' => array('rgb' => 'CC0000'))));
						}else{
							$val = "Paid";
							$this->getActiveSheet()->getStyle($char.$i)->applyFromArray(array('font' => array('color' => array('rgb' => '006600'))));
						}
					}	
					$this->getActiveSheet()->setCellValue($char.$i, $val);
					$char++;					
				}
				$i++;
			}	
		}
		
		// //============= Additional Change ================
				
		//============= End Additional Change ================
		$filename = $data1['filename'];
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"'); 
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel5');  
		$objWriter->save('php://output');
	}	

}
