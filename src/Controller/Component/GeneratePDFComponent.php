<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\View\View;
use Cake\View\ViewBuilder;
use Cake\Routing\Router;
use Cake\Filesystem\File;
use QRcode;
//use FPDF;
use LRS_PDF_ACCURATE;
use	LRS_PDF_COMMON;

/**
 * GeneratePDF component
 */
class GeneratePDFComponent extends Component
{
	// call from intial conversheet and viewAll complete page
	public function generateCoversheetPDF(array $fmdDocIDs){
		//explode fmd_dco ids
		$fmdDocIDs = $this->setFmdDocIds($fmdDocIDs); 
		$pdfname = '';
		// fetch recording data for pdf gerenate match
		$PDFRecordingData = $this->fetchFmdRecording($fmdDocIDs);
		
		if(!empty($PDFRecordingData)){	
			$pdfname = $this->pdfGenerateFinal($PDFRecordingData);
		}
		return $pdfname;
	}
	
	// Call from recording coversheet and above function 
	public function pdfGenerateFinal($PDFRecordingData, $prifix=''){
		$pdfObject = null;
		 
		foreach($PDFRecordingData as $pdfData){
			$lrsId = $pdfData['NATFileNumber'];
			$docId = $pdfData['frd']['TransactionType'];
			$companyId = $pdfData['company_id'];

			if($pdfData['fcd']['search_status'] == 'S' && $pdfData['frd']['hard_copy_received'] == 'N')
			{ continue;	}

			// generate PDF file
			$pdfObject = $this->createPDFfile($pdfData, $companyId, $pdfObject);

			if(is_object($pdfObject)){
				// update recording data for pdf gerenate 
				$this->updateRecording($pdfData['frd']['Id']);
			}
		}
		
		$pdfname = null;
		// create coversheet PDF file
		if(is_object($pdfObject)){
			$pdfname = "Rec_Conf_Coversheet_".date("Y-m-d").$prifix.".pdf";
			$pdfObject->Output($pdfname,"D");
		}

		return $pdfname;
	}
	
	
	// Call from recording coversheet and above function 
	public function fetchFmdRecording($fmdDocIDs, $count=false){

		$recordingData = '';
		$this->FilesMainData = TableRegistry::get('FilesMainData');
		// find all recording data for match QRcode for PDF
		$recordingQuery = $this->FilesMainData->recordingKNIcheckDataQuery($fmdDocIDs, $count);
 
		if($count){
			$recordingData = $recordingQuery->all()->count();
		}else{
			if(isset($fmdDocIDs['limit']) &&  strpos($fmdDocIDs['limit'], '-')){
				$limit = explode('-',$fmdDocIDs['limit']);
				$recordingQuery = $recordingQuery->limit($limit[1])->offset($limit[0]);
			}

			$recordingData = $recordingQuery->disableHydration()->all()->toArray();
		}
		return $recordingData;
	}
	
	
	private function setFmdDocIds($coverSheetIds){
		$postPDFData =[];
		foreach($coverSheetIds as $key){
				
				if(!empty($key) && strpos($key, '_')){
					$expl = explode("_",$key);
					$LRSNo = trim($expl[0]);
					$docType = trim($expl[1]);
					$postPDFData['fmdId'][] = $LRSNo;  
					$postPDFData['docId'][] = $docType;  
				}
		}
		return $postPDFData;
	}
	
	
	private function updateRecording($recId){
		$this->FilesRecordingData = TableRegistry::get('FilesRecordingData');
		$this->FilesRecordingData->updateRecordingData($recId, 'pdf_generate'); 
		
		// this is handle in scanning recognition  ==> files-recording-data/scanning-recognition
		// $this->FilesRecordingData->updateRecordingData($recId, 'hard_copy_received');
		return true;
	}

	private function getMappingFeilds($companyId=null, $flag=1){
		$this->CompanyFieldsMap = TableRegistry::get('CompanyFieldsMap');
		$partnerMapField =  $this->CompanyFieldsMap->partnerMapFields($companyId, $flag, false);
		return $partnerMapField;
	}
	 
	// generate PDF code 
	private function createPDFfile($list, $companyId=null, $pdfObject = null){
		//echo '<pre>'; print_r($list); exit;
		require_once(FPDF_VENDER."lrs_pdf.php");

		if(is_null($pdfObject)){
			// dynamic select class name
			$pdf = new LRS_PDF_ACCURATE();
		}else{
			$pdf = $pdfObject;
		} 
		
		$pdf->AliasNbPages();

		$pdf->SetFont('times','B',18);

		$pdf->SetFillColor(255,255,255);

		$pdf->SetLineWidth(.1);
		$pdf->Ln(5);

		if($list['frd']['RecId']!="" ){
		
			// for dynamic header.
			$pdf->AddPage('', '', 0, $companyId); 

			$pdf->SetFillColor(255,255,255);
			
			if($companyId == DEFAULT_COMPANY){
				$partnerMapField = $this->getMappingFeilds($companyId);
				$pdf = $this->pdfForAccurate($pdf, $list, $partnerMapField);
				$yAxis = 55;
			}else{
				$pdf = $this->pdfForCommon($pdf, $list);
				$yAxis = 35;
			} 

			//$qrcode = new QRcode($list['NATFileNumber'].'_'.$list['frd']['TransactionType']); //The string you want to encode
			$qrcode = $this->generateQRcode($list['PartnerFileNumber'], $list['frd']['TransactionType'], true);
			$qrcode->displayFPDF($pdf, 150, $yAxis, 25); //PDF object, X pos, Y pos, Size of the QR code

		}
		
		/* $pdfname = "Rec_Conf_Coversheet_".date("Y-m-d")."_".mt_rand().".pdf";
		$pdf->Output($pdfname,"D"); */
		return $pdf;
	}

	private function pdfForAccurate($pdf, $list, $partnerMapField){

		$pdf->Ln();
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"File No.: ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(103,6,$list['PartnerFileNumber'],'0',0,'L',true);
		
		$pdf->SetFont('times','',10);
		$pdf->Cell(10,6,$list['frd']['RecordingProcessingDate'],'0',0,'L',true);
		$pdf->Ln();

		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6, "Client: ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(140,6,$list['Grantees'],'0',0,'L',true);
		$pdf->Ln();

		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6, $partnerMapField['mappedtitle']['I'].": ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(140,6,$list['I'],'0',0,'L',true);
		$pdf->Ln();		
		
		$addrarr = [];
		if($partnerMapField['mappedtitle']['J'] != "") $addrarr[] = $list['J'];
		if($partnerMapField['mappedtitle']['K'] != "") $addrarr[] = $list['K'];
		if($partnerMapField['mappedtitle']['L'] != "") $addrarr[] = $list['L'];
		$addr = (is_array($addrarr))?implode(", ",$addrarr):"";
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(140,6,$addr,'0',0,'L',true); 
		$pdf->Ln();		
		
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Reference No:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(103,6,$list['B'],'0',0,'L',true);	
		
		$pdf->SetFont('times','',10);
		$pdf->Cell(150, 22,$list['PartnerFileNumber'].'-'.$list['frd']['TransactionType'],'0',0,'L',true);
		$pdf->Ln();
		
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6, $partnerMapField['mappedtitle']['Grantors']." :   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(140,6,$list['Grantors'],'0',0,'L',true);
		$pdf->Ln();
		
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Property: ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(140,6,$list['M'],'0',0,'L',true);
		$pdf->Ln();

		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Location:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(140,6,$list['City'].' '.$list['State'],'0',0,'L',true);
		$pdf->Ln();

		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"County:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);	
		$pdf->Cell(140,6,$list['County'],'0',0,'L',true);

		$pdf->Ln(10);	
		$pdf->SetLineWidth(0.50);
		$pdf->Cell(180,1,'',"T",0,'C',1);
		$pdf->Ln();		
		$pdf->SetFont('times','B',12);		
		$pdf->Cell(180,6,"Recording Information",'0',0,'C',true);		
		$pdf->Ln(5);
		
		$pdf->SetLineWidth(0.50);
		$pdf->Ln(5);	
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Document Type:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(50,6,$list['dtm']['Title'],'0',0,'L',true);
		$pdf->Ln();

		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Executed Date:   ",'0',0,'L',true);

		$arrdtexec =  ($list['Q'] != '') ? date('m/d/Y', strtotime($list['Q'])): '' ;

		$pdf->SetFont('times','',10);
		$pdf->Cell(50,6,$arrdtexec,'0',0,'L',true);
		$pdf->SetFont('times','B',10); 

		$arrdtrec =  ($list['frd']['RecordingDate'] != '') ? date('m/d/Y', strtotime($list['frd']['RecordingDate'])): '' ;

		$pdf->Cell(40,6,"Filing Date: ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(50,6,$arrdtrec." @ ".$list['frd']['RecordingTime'],'0',0,'L',true);
		$pdf->Ln();

		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Amount:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(50,6,$list['LoanAmount'],'0',0,'L',true);
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Open Ended:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(50,6,"No",'0',0,'L',true);
		$pdf->Ln();
		
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Volume/Inst#/Doc#:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);

		if($list['frd']['Book']!=""){
			$pdf->Cell(50,6,$list['frd']['Book'],'0',0,'L',true);
		}else{
			$pdf->Cell(50,6,$list['frd']['InstrumentNumber'],'0',0,'L',true);
		}

		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Page:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(50,6,$list['frd']['Page'],'0',0,'L',true);
		$pdf->Ln();

		$pdf->SetLineWidth(0.50);
		$pdf->Ln(5);	
		$pdf->Cell(180,6,"The '".$list['dtm']['Title']."' shown above was recorded in the public records on your behalf .",'0',0,'L',true);
		$pdf->Ln();	
		$pdf->Cell(180,6,"A recorded original document is attached to this report for your records.",'0',0,'L',true);

		if($list['frd']['Book']!="" && $list['frd']['InstrumentNumber']!=""){
			$pdf->Ln();
			$pdf->Ln();	
			$pdf->Cell(180,6,"Document Number: ".$list['frd']['InstrumentNumber'],'0',0,'L',true);
		}

		if($list['H']=="YES" || $list['H']=="Yes" || $list['H']=="yes" || $list['H']=="Y" || $list['H']=="y"){
			$arrdteff = ($list['frd']['EffectiveDate'] != '') ? date('m/d/Y', strtotime($list['frd']['EffectiveDate'])) : '';
			
			
			$pdf->Ln();$pdf->Ln();		
			$pdf->Cell(180,6,"Our search was updated thru ".$arrdteff.", we have found no intervening liens or deed transfers from the date of the original property",'0',0,'L',true);
			$pdf->Ln();	
			$pdf->Cell(180,6,"report.",'0',0,'L',true);			
		}
		
		$pdf->Ln();	$pdf->Ln();	$pdf->Ln();	
		$pdf->Cell(180,6, "Thank you for using the the Accurate Group",'0',0,'C',true);

		$pdf->Ln();
		return $pdf;
	}
	
	private function pdfForCommon($pdf, $list){
		
		$pdf->Ln();
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"File No.:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(140,6,$list['PartnerFileNumber'],'0',0,'L',true);
		
		$pdf->Ln();				
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Mortgagor / Grantor:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(140,6,$list['Grantors'],'0',0,'L',true);
		$pdf->Ln();

		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Mortgagee / Grantee:",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(140,6,$list['Grantees'],'0',0,'L',true);
		$pdf->Ln();	
		
		$PropertyAddress = [$list['StreetNumber'],$list['StreetName']];
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Property Address: ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(140,6,implode(', ', array_filter($PropertyAddress)),'0',0,'L',true);
		$pdf->Ln();
		
		$citState = [$list['City'],$list['State'], $list['Zip']];
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Location:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(140,6,implode(', ', array_filter($citState)),'0',0,'L',true);
		$pdf->Ln();

		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"County:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);	
		$pdf->Cell(140,6,$list['County'],'0',0,'L',true);
		
		$pdf->Ln();	
		$pdf->SetFont('times','',10);
		$pdf->Cell(164,6,$list['PartnerFileNumber'].'-'.$list['frd']['TransactionType'],'0',0,'R',true);
		$pdf->Ln();	
		
		$pdf->Ln(2);	
		$pdf->SetLineWidth(0.50);
		$pdf->Cell(180,1,'',"T",0,'C',1);
		$pdf->Ln();	
		$pdf->SetFont('times','B',12);		
		$pdf->Cell(180,6,"Recording Information",'0',0,'C',true);			
		$pdf->SetLineWidth(0.50);
		$pdf->Ln();	$pdf->Ln();	
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Document Type:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(140,6,$list['dtm']['Title'],'0',0,'L',true);
		$pdf->Ln();
	
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Date Recorded:   ",'0',0,'L',true);
		$arrdtexec = ($list['frd']['RecordingDate'] != '') ? date('m/d/Y', strtotime($list['frd']['RecordingDate'])) : '';
		
		$pdf->SetFont('times','',10);
		$pdf->Cell(50,6,$arrdtexec,'0',0,'L',true);
		$pdf->SetFont('times','B',10);
		
		$pdf->Cell(40,6,"Time Recorded: ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(50,6,$list['frd']['RecordingTime'],'0',0,'L',true);
		$pdf->Ln();

		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Instrument Number:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(50,6,$list['frd']['InstrumentNumber'],'0',0,'L',true);
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Volume / Liber Book:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(50,6,$list['frd']['Book'],'0',0,'L',true);
		$pdf->Ln();
		
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Page:",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(50,6,$list['frd']['Page'],'0',0,'L',true);
		
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Loan Amount:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(50,6,$list['LoanAmount'],'0',0,'L',true);
		$pdf->Ln();
		
		$arrdtexdate = ($list['frd']['RecordingProcessingDate'] != '') ? date('m/d/Y', strtotime($list['frd']['RecordingProcessingDate'])) : '';
		
		$pdf->SetFont('times','B',10);
		$pdf->Cell(40,6,"Execution Date:   ",'0',0,'L',true);
		$pdf->SetFont('times','',10);
		$pdf->Cell(50,6,$arrdtexdate,'0',0,'L',true);
		$pdf->Ln();

		$pdf->SetLineWidth(0.50);
		$pdf->Ln(5);	
		$pdf->Cell(180,6,"The '".$list['dtm']['Title']."' shown above was recorded in the public records on your behalf .",'0',0,'L',true);
		$pdf->Ln();	
		$pdf->Cell(180,6,"A recorded original document is attached to this report for your records.",'0',0,'L',true);

		$pdf->Ln();	

		return $pdf;
	}
	
	/**
	* Call from differant modules for 
	* For BARCODE QRcode only use '_' and NATFileNumber value
	* For QRcode  in PDF '-' and PartnerFileNumber value
	*
	* ---- Module name------
	* 1) Checkin records generate BARCODE (Generate only bar code)
	* 2) Initiate Coversheet (Multiple records in single PDF)
	* 3) Records Detail View (Single records in single PDF)
	* 4) Recording section (Multiple records in single PDF)
	*
	* $fileIdnum =>> NATFileNumber OR PartnerFileNumber
	**/
	
	public function generateQRcode($fileIdnum, $docId, $is_pdf= false){

		require_once(FPDF_VENDER."qrcode.class.php");
		
		$seperator = ($is_pdf) ? '-' : '_';
		
		$qrcode = new QRcode($fileIdnum.$seperator.$docId);
		
		if(is_object($qrcode)){
			if($is_pdf){
				// generate qr code image
				return $qrcode;
			}else{
				// for checkin page
				echo  $qrcode->displayPNG(100);
				return true;	
			}
		}else{
			return false;
		}
	}
}