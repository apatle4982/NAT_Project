<?php
declare(strict_types=1);

namespace App\Controller;
require_once ROOT . '/vendor/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\View\View;
use Cake\Http\Response;
use LRS_PDF_ACCURATE;
use	LRS_PDF_COMMON;
use Cake\ORM\TableRegistry; 
use Cake\I18n\Time;
use Cake\Mailer\Mailer;
use Cake\Routing\Router;
use Cake\I18n\FrozenTime;

class PdfController extends AppController{
	public function getCompanyEmail()
    {
        $this->request->allowMethod(['post']); // Allow only POST requests

        $fileId = $this->request->getData('file_id'); // Get file ID from AJAX request

        if (!$fileId) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Invalid file ID']));
        }

        // Load Tables
        $filesMainDataTable = TableRegistry::getTableLocator()->get('FilesMainData');
        $companyMstTable = TableRegistry::getTableLocator()->get('CompanyMst');

        // Step 1: Get PartnerId from files_main_data
        $partner = $filesMainDataTable->find()
            ->select(['company_id'])
            ->where(['Id' => $fileId])
            ->first();

        if (!$partner) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Partner ID not found']));
        }

        // Step 2: Get cm_email from company_mst based on company_id
        $company = $companyMstTable->find()
            ->select(['cm_email'])
            ->where(['cm_id' => $partner->company_id])
            ->first();

        if (!$company) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Company email not found']));
        }

        return $this->response->withType('application/json')->withStringBody(json_encode(['success' => true, 'email' => $company->cm_email]));
        //return $this->response->withType('application/json')->withStringBody(json_encode(['success' => true, 'email' => "vsurjuse@tiuconsulting.com"]));
    }

    public function getAttorneyEmail(){
        $this->request->allowMethod(['post']); // Allow only POST requests

        $fileId = $this->request->getData('file_id'); // Get file ID from AJAX request

        if (!$fileId) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Invalid file ID']));
        }

        //$files_attorney_assignment = TableRegistry::getTableLocator()->get('files_attorney_assignment');
        $filesAttorneyAssignment = TableRegistry::getTableLocator()->get('FilesAttorneyAssignment');
        $vendors = TableRegistry::getTableLocator()->get('Vendors');

        $attorney = $filesAttorneyAssignment->find()->select(['vendorid'])->where(['RecId' => $fileId])->first();

        if (!$attorney) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Attorney is not assigned']));
        }

        $vendor = $vendors->find()->select(['main_contact_email'])->where(['id' => $attorney->vendorid])->first();
        //echo "<pre>";print_r($vendor);echo "</pre>";exit;
        if (!$vendor) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Attorney email not found']));
        }

        return $this->response->withType('application/json')->withStringBody(json_encode(['success' => true, 'email' => $vendor->main_contact_email]));
    }

public function sendAolEmail(){
    if ($this->request->is('post')) {
        $data = $this->request->getData();
        //echo "<pre>";print_r($data);echo "</pre>";exit;
        if($data['email_type']){
            $folder = $data['email_type'];
            if($data['email_type']=='final'){
                $review_url = Router::url('/reviews/index/'.$data['email_btn_id'], true);
                $data['body'] = $data['body']."<br>Click <a href='".$review_url."'>here<a> to review";
            }
        }
        $filePath = "";
        if (!empty($data['email_btn_id'])) {
            $id = $data['email_btn_id'];
            $filePath = WWW_ROOT . 'files' . DS . 'export' . DS . 'aol_assignment' . DS . 'pdf' . DS . $folder . DS . "AssignmentDetails-$id.pdf";
        }
        
        if (!empty($filePath) && file_exists($filePath)) {
            debug("File exists: " . $filePath);
        } else {
            debug("File NOT found: " . $filePath);
            $this->Flash->error('PDF file not found.');
        }

        $email = new Mailer('default');
        $email->setFrom(['info@tiuconsulting.com' => 'NAT'])
            ->setTo($data['email'])
            ->setSubject($data['subject'])
            ->setEmailFormat('both');

        // Attach file
        if (!empty($filePath) && file_exists($filePath)) {
            $email->addAttachments([$filePath]);
        }
        // Send email
        $email->deliver($data['body']);
        $this->Flash->success('AOL Email sent successfully.');
        return $this->redirect($this->referer());
    }
    throw new BadRequestException('Invalid request.');
}

    
public function generatePdfOld($id, $flag = "")
{
    $this->autoRender = false;

    require_once(FPDF_VENDER . "lrs_pdf.php");
    $pdf = new LRS_PDF_ACCURATE();

    $this->loadModel('FilesExamReceipt');
    $this->loadModel("FilesMainData");

    $fmd_data = $this->FilesMainData->find()->where(['Id' => $id])->first();
    $data = $this->FilesExamReceipt->find()->where(['RecId' => $id])->first();
    $vest = array();
    $mortgage = array();
    $judgments = array();

    if($data['vesting_attributes'])
    $vest = json_decode($data['vesting_attributes']);

    if($data['open_mortgage_attributes'])
    $mortgage = json_decode($data['open_mortgage_attributes']);

    if($data['open_judgments_attributes'])
    $judgments = json_decode($data['open_judgments_attributes']);

    // Define colors (Green theme)
    $headerColor = [34, 139, 34]; // Dark Green

    // Initialize PDF
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);

    // Title
    $pdf->SetTextColor($headerColor[0], $headerColor[1], $headerColor[2]);
    $pdf->Cell(0, 10, 'Insured Attorney Opinion Letter', 0, 1, 'C');
    $pdf->Ln(5);

    // Reset text color for body
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 10);

    // Property Information
    $this->addSectionHeader($pdf, 'Property Information', $headerColor);
    $this->addDataTable($pdf, [
        'NAT File Number' => $fmd_data['NATFileNumber'],
        'Loan Number' => $fmd_data['LoanNumber'],
        'Subject Names' => $data['VestedAsGrantee'],
        'Property Address' => $data['OfficialPropertyAddress'],
        'Creation Date' => $data['created'],
        'Effective Date' => $data['OpenJudgmentsDateRecorded']
    ]);

    // Vesting Information
    $pdf->Ln(5);
    $this->addSectionHeader($pdf, 'Vesting Information', $headerColor);
    if(count($vest) > 0){
        $cnt = 1;
        foreach($vest as $v){
          //echo "<pre>";print_r($v);echo "</pre>";exit;
            $this->addDataTable($pdf, [
                "Deed Type" => $v->VestingDeedType,
                "Title Vested In" => $v->VestingDeedType,
                "Grantor" => $v->VestingGrantor,
                "Dated" => $v->VestingDated,
                "Recorded" => $v->VestingRecordedDate,
                "Book & Page" => $v->VestingBookPage,
                "Comments" => $v->VestingComments
            ], true);
            $cnt++;
            $pdf->Ln(5);
        }
    }


    // Open Mortgages
    $pdf->Ln(5);
    $this->addSectionHeader($pdf, 'Open Mortgages', $headerColor);

    if(count($mortgage) > 0){
        $cnt = 1;
        foreach($mortgage as $v){
            $this->addDataTable($pdf, [
                "Amount" => $v->OpenMortgageAmount,
                "Dated" => $v->OpenMortgageDated,
                "Recorded" => $v->OpenMortgageRecordedDate,
                "Lender" => $v->OpenMortgageLenderMortgagee,
                "Borrower" => $v->OpenMortgageBorrowerMortgagor,
                "Instrument" => $v->OpenMortgageInstrument,
                "Comments" => $v->OpenMortgageComments
            ], true);
            $cnt++;
            $pdf->Ln(5);
        }
    }

    $pdf->Ln(5);
    $this->addSectionHeader($pdf, 'Judgments & Other Encumbrances', $headerColor);
    if(count($judgments) > 0){
        $cnt = 1;
        foreach($judgments as $v){
            //echo "<pre>";print_r($v);echo "</pre>";exit;
            $this->addDataTable($pdf, [
                "Litigation" => $v->OpenJudgmentsLienHolderPlaintiff,
                "Comments" => $v->OpenJudgmentsComments
            ], true);
            $cnt++;
            $pdf->Ln(5);
        }
    }

    // Tax Status
    $pdf->Ln(5);
    $this->addSectionHeader($pdf, 'Tax Status', $headerColor);
    $this->addDataTable($pdf, [
        'Parcel #' => $data['apn_parcel_number'],
        'Tax Year' => $data['TaxYear'],
        'Delinquent No' => $data['TaxDeliquentDate'],
        'Tax Value' => $data['TaxAmount'],
        'Exemption' => $data['exemption'],
        'Annual Tax' => $data['annual_tax'],
        'Comments' => $data['TaxComments']
    ], true);

    // Legal Description
    $pdf->Ln(5);
    $this->addSectionHeader($pdf, 'Legal Description & Comments', $headerColor);
    $this->addDataTable($pdf, [
        'Legal Description' => $data['LegalDescription'],
        'Additional Comments' => 'None'
    ], true);

    /*$pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetTextColor($headerColor[0], $headerColor[1], $headerColor[2]);
    $pdf->Cell(0, 10, 'AOL Insurance & Wrap Language', 0, 1, 'C');
    $pdf->Ln(5);*/

    // Final Output
    //$pdf->Output('D', "AssignmentDetails-$id.pdf");
	// Define the file path in webroot directory
    $pdf_folder = "pre";
    if($flag=="final"){$pdf_folder = "final";}
	$filePath = WWW_ROOT . 'files' . DS . 'export' . DS . 'aol_assignment' . DS . 'pdf' . DS  . $pdf_folder . DS . "AssignmentDetails-$id.pdf";
	// Ensure the directory exists
	if (!is_dir(dirname($filePath))) { mkdir(dirname($filePath), 0777, true); }

    $this->static_page1($pdf, $id);
    $this->static_page2($pdf, $id);
	// Save the PDF to the server
	$pdf->Output('F', $filePath);
    if($flag=="" or $flag=="finalpdf"){
	    $pdf->Output('D', "AssignmentDetails-$id.pdf");
    }
}

private function addSectionHeader(&$pdf, $title, $headerColor)
{
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor($headerColor[0], $headerColor[1], $headerColor[2]);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(0, 8, $title, 1, 1, 'L', true);
    //$pdf->Ln(2);
    $pdf->SetTextColor(0, 0, 0);
}

private function addDataTable(&$pdf, $data, $wrapText = false)
{
    $pdf->SetFont('Arial', '', 10);
    foreach ($data as $key => $value) {
        if (empty($value)) {
            $value = 'N/A';
        }

        // Calculate height dynamically
        $colWidth = 140;
        $lineHeight = 6;
        $maxWidth = $pdf->GetStringWidth($value);
        $numLines = ceil($maxWidth / $colWidth);
        $cellHeight = max(6, $numLines * $lineHeight);

        // Align the label and content to have the same height
        $pdf->Cell(50, $cellHeight, "$key:", 1, 0, 'L');
        $pdf->MultiCell($colWidth, $lineHeight, $value, 1, 'L');

        // Add spacing after each row
        //$pdf->Ln(2);
    }
}

private function addMultiCellData(&$pdf, $title, $content)
{
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(50, 8, "$title:", 1, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(140, 8, $content, 1, 'L');
    $pdf->Ln(3);
}

    public function static_page1(&$pdf, $id){
        $this->autoRender = false;
        // Generate PDF content
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 10, 'Policy Details', 0, 1, 'C');
        $pdf->Ln(5);

        // Table Header
        $pdf->SetFont('Arial', 'B', 10);
        /*$pdf->Cell(30, 6, 'Item', 1);
        $pdf->Cell(60, 6, 'Title', 1);
        $pdf->Cell(0, 6, 'Content', 1, 1);*/

        // Table Data
        $this->addRow($pdf, "Item 1", "Insured Name & Address", "");
        $this->addRow($pdf, "Item 2", "Policy Period", "From 05/01/20xx to 05/01/20xx (12:01 a.m. Standard Time)");
        $this->addRow($pdf, "Item 3", "Limit of Liability", "As set forth in Section II Limits of Liability");
        $this->addRow($pdf, "Item 4", "Coverage Parts", "Applicable to this Policy. See Item 7");
        $this->addRow($pdf, "Item 5", "Premium", "Additional premium due shall be applicable to each Coverage Part Report for which coverage is provided under the terms of Section I Insuring Agreement.");
        $this->addRow($pdf, "Item 6", "Taxes and Fees", "Surplus Lines Premium Tax: 4.85%; or $0.0485 per $1.00 of premium\nStamping Fee: 0.075%; or $0.00075 per $1.00 of premium");
        $this->addRow($pdf, "Item 7", "Forms and Endorsements", "IFC EO P 0001 0520 Blanket Policy; IFC EO P 0002 0524 Service of Process; IFC EO P 0003 0524 Arbitration Provision; IFC EO P 0004 0524 Certified Acts of Terrorism Coverage and Cap on Certified Acts Losses; IFC EO P 0011 1223 Refinance Attorney Title Opinion Service Agreement Form; IFC EO E 0015 0524 General Change Endorsement; IFC EO E 0016 0524 Addition of Service Agreement with A Lender or Client Endorsement; IFC EO E 0017 0524 Service Agreement Manuscript Endorsement; IFC EO P 0018 0524 Privacy Notice.");
    }

    public function static_page2(&$pdf, $id){
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'SERVICE AGREEMENT LIABILITY POLICY', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'BLANKET POLICY', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, 'Table of Contents', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);

        $contents = [
            'Section I - Insuring Agreement' => 1,
            'Section II - Limit of Liability' => 2,
            'Section III - Definitions' => 2,
            'Section IV - Exclusions' => 2,
            'Section V - General Conditions' => 3,
            'Notice of Loss and Cooperation' => 3,
            'Action Against Insurer' => 3,
            'Cancellation and Nonrenewal' => 3,
            'Subrogation' => 3,
            'Other Insurance' => 4,
            'Authorization and Sole Agent' => 4,
            'Heading and Titles' => 4,
            'Assignment of Interest' => 4,
            'Changes' => 4,
            'Territory' => 4
        ];

        foreach ($contents as $title => $page) {
            $pdf->Cell(130, 6, $title, 0, 0);
            $pdf->Cell(10, 6, $page, 0, 1, 'R');
        }
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'INSURING AGREEMENT', 0, 1);
        $pdf->SetFont('Arial', '', 10);

        $text = "Subject to the Limit of Liability stated in Item 3 of the Declarations Page, and the conditions set forth in items A through C below, the insurer agrees to pay on behalf of the insured those sums the insured becomes legally liable to pay to a client for a loss arising out of the insured's breach of an obligation assumed by the insured under the terms of a service agreement. The service agreements eligible for coverage under this policy shall be in the form or as shown in the applicable Coverage Part(s) in Item 4 of the Declarations Page. All applicable endorsements are attached hereto and incorporated as part of this policy.";
        $pdf->MultiCell(0, 6, $text);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, 'A.', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $textA = "The service agreement(s) must be in effect during the policy period or used in the underwriting of a loan which closes on a date within the policy period while also meeting all terms and conditions of the service agreement(s).";
        $pdf->MultiCell(0, 6, $textA);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, 'B.', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $textB = "None of the terms and conditions of the service agreement(s) may be more favorable to the client than those set forth in the applicable Coverage Part(s). If any such terms are more favorable, coverage shall not be invalidated, but the insurer shall only be liable for providing coverage consistent with the applicable Coverage Part(s).";
        $pdf->MultiCell(0, 6, $textB);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, 'C.', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $textC = "Coverage applies to reports that: 1. Bear a date within the policy period; or 2. Are used in the underwriting of a loan that closes within the policy period and meet all service agreement conditions. The report must be submitted within forty-five (45) calendar days after the month-end of the loan funding.";
        $pdf->MultiCell(0, 6, $textC);
    }

    public function addRow($pdf, $item, $title, $content){
        $cellWidthItem = 13;
        $cellWidthTitle = 47;
        $cellWidthContent = 130; // Remaining width
        $lineHeight = 6;

        // Calculate number of lines required for content
        $maxLines = max(
            $pdf->NbLines($cellWidthItem, $item),
            $pdf->NbLines($cellWidthTitle, $title),
            $pdf->NbLines($cellWidthContent, $content)
        );

        $rowHeight = $lineHeight * $maxLines; // Make all columns have the same height

        // Draw cells with consistent height
        $pdf->Cell($cellWidthItem, $rowHeight, $item, 1, 0);
        $pdf->Cell($cellWidthTitle, $rowHeight, $title, 1, 0);
        $pdf->MultiCell($cellWidthContent, $lineHeight, $content, 1);
    }

    public function exampdf($id){
        $this->viewBuilder()->enableAutoLayout(false);
        $this->loadModel("FilesMainData");
	    $this->loadModel('FilesVendorAssignment');
	    $this->loadModel('Vendors');

        $fmd_data = $this->FilesMainData->find()->where(['Id' => $id])->first();
        $fva_data = $this->FilesVendorAssignment->find()->where(['RecId' => $id])->first();
        $vendor_data = $this->Vendors->find()->where(['id' => $fva_data['vendorid']])->first();

        $this->set(compact('fmd_data','fva_data','vendor_data'));

        $html = $this->render('/Pdf/vendor_pdf');
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("Request-for-Title-Exam-$id.pdf", ["Attachment" => true]);

        return $this->response->withType('application/pdf');
    }

   public function generatePdf($id = null, $flag = ""){
    $this->viewBuilder()->enableAutoLayout(false);
        $this->loadModel("FilesMainData");
	    $this->loadModel('FilesVendorAssignment');
	    $this->loadModel('Vendors');
	    $this->loadModel('FilesExamReceipt');

        $fmd_data = $this->FilesMainData->find()->where(['Id' => $id])->first();
        $fva_data = $this->FilesVendorAssignment->find()->where(['RecId' => $id])->first();
        $vendor_data = $this->Vendors->find()->where(['id' => $fva_data['vendorid']])->first();
        $exam = $this->FilesExamReceipt->find()->where(['RecId' => $id])->first();
        //echo "<pre>";print_r($exam);echo "</pre>";exit;
        $pdf_folder = "pre";
        if ($flag == "final" or $flag == "finalpdf") { $pdf_folder = "final"; }

        $filePath = WWW_ROOT . 'files' . DS . 'export' . DS . 'aol_assignment' . DS . 'pdf' . DS . $pdf_folder . DS . "AssignmentDetails-$id.pdf";

        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        $this->set(compact('fmd_data','fva_data','vendor_data', 'exam', 'flag'));

        //$html = $this->render('/Pdf/aol_pdf');
        $html = $this->render('/Pdf/aol_pdf')->getBody()->__toString();
        //$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        $html = utf8_decode($html);

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        // ************* For Water Mark ************
        $dompdf->render();
        if ($flag == "pre" or $flag == "") {
            $canvas = $dompdf->getCanvas();

            if ($canvas && is_object($canvas)) {
                $pageCount = $canvas->get_page_count();

                $fontMetrics = new \Dompdf\FontMetrics($canvas, $dompdf->getOptions());
                $font = $fontMetrics->get_font('Helvetica', 'bold');

                $text = "Unexecuted - Not to be used for Closing";
                $fontSize = 36;

                $width = $canvas->get_width();
                $height = $canvas->get_height();

                for ($i = 1; $i <= $pageCount; $i++) {
                    $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($text, $fontSize, $font) {
                        $width = $canvas->get_width();
                        $height = $canvas->get_height();

                        // Adjust starting point for bottom-left to top-right diagonal
                        $x = 50;
                        $y = $height - 100;

                        $canvas->set_opacity(0.2);
                        $canvas->save();
                        $canvas->rotate(-45, $x, $y);  // Negative angle for bottom-left to top-right
                        $canvas->text($x, $y, $text, $font, $fontSize, [0.8, 0.8, 0.8]);
                        $canvas->restore();
                    });
                }
            }
        }
        // *************************
        // Save the PDF to the server
        file_put_contents($filePath, $dompdf->output());

        if ($flag == "" || $flag == "finalpdf") {
            // Force download
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="AssignmentDetails-' . $id . '.pdf"');
            echo $dompdf->output();
            exit;
        }
        //$dompdf->render();
        //$dompdf->stream("AssignmentDetails-$id.pdf", ["Attachment" => true]);
        /*$dompdf->stream("AssignmentDetails-$id.pdf", ["Attachment" => false]);   // View file in browser */
        //return $this->response->withType('application/pdf');
    }

}
