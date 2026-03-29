<?php
declare(strict_types=1);

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
//use FPDF;
use LRS_PDF_ACCURATE;
use	LRS_PDF_COMMON;
use Cake\ORM\TableRegistry; 
use Cake\I18n\Time;
use Cake\Mailer\Mailer;

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
            ->select(['PartnerId'])
            ->where(['Id' => $fileId])
            ->first();

        if (!$partner) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Partner ID not found']));
        }

        // Step 2: Get cm_email from company_mst based on PartnerId
        $company = $companyMstTable->find()
            ->select(['cm_email'])
            ->where(['cm_id' => $partner->PartnerId])
            ->first();

        if (!$company) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Company email not found']));
        }

        //return $this->response->withType('application/json')->withStringBody(json_encode(['success' => true, 'email' => $company->cm_email]));
        return $this->response->withType('application/json')->withStringBody(json_encode(['success' => true, 'email' => "vsurjuse@tiuconsulting.com"]));
    }
	/*public function sendAolEmail(){
        if ($this->request->is('post')) {
			print_r($this->request->getData());exit;
            $data = $this->request->getData();
			if($data['email_btn_id']){
				$filePath = WWW_ROOT . 'files' . DS . 'export' . DS . 'aol_assignment' . DS . 'pdf' . DS . "AssignmentDetails-$id.pdf";
			}
            $email = new Mailer('default');
            $email->setFrom(['info@tiuconsulting.com' => 'NAT'])
                ->setTo($data['email'])
                ->setSubject($data['subject'])
                ->setEmailFormat('both')
                ->deliver($data['body']);

            // Handle attachment
            if (!empty($data['attachment']->getClientFilename())) {
                $attachmentPath = WWW_ROOT . 'uploads/' . $data['attachment']->getClientFilename();
                $data['attachment']->moveTo($attachmentPath);
                $email->addAttachments([$attachmentPath]);
            }

            $this->Flash->success('Email sent successfully.');
            return $this->redirect($this->referer());
        }

        throw new BadRequestException('Invalid request.');
    }*/
public function sendAolEmail()
{
    if ($this->request->is('post')) {
        $data = $this->request->getData();

        $filePath = "";
        if (!empty($data['email_btn_id'])) {
            $id = $data['email_btn_id'];

            // Use full absolute path instead of URL
            $filePath = WWW_ROOT . 'files' . DS . 'export' . DS . 'aol_assignment' . DS . 'pdf' . DS . "AssignmentDetails-$id.pdf";
        }

        // Debugging: Check if the file exists
        if (!empty($filePath) && file_exists($filePath)) {
            debug("File exists: " . $filePath);
        } else {
            debug("File NOT found: " . $filePath);
            $this->Flash->error('PDF file not found.');
        }

        // Initialize email
        $email = new Mailer('default');
        $email->setFrom(['info@tiuconsulting.com' => 'NAT'])
            ->setTo($data['email'])
            ->setSubject($data['subject'])
            ->setEmailFormat('both');

        // Attach file if it exists
        if (!empty($filePath) && file_exists($filePath)) {
            $email->addAttachments([$filePath]);
        }

        // Send email
        $email->deliver($data['body']);

        $this->Flash->success('Email sent successfully.');
        return $this->redirect($this->referer());
    }

    throw new BadRequestException('Invalid request.');
}

    
public function generatePdf($id, $flag = "")
{
    $this->autoRender = false;

    require_once(FPDF_VENDER . "lrs_pdf.php");
    $pdf = new LRS_PDF_ACCURATE();

    $this->loadModel('FilesExamReceipt');
    $this->loadModel("FilesMainData");

    $fmd_data = $this->FilesMainData->find()->where(['Id' => $id])->first();
    $data = $this->FilesExamReceipt->find()->where(['RecId' => $id])->first();

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
        'Property Address' => $data['PropertyAddress'],
        'City' => $data['PropertyCity'],
        'State' => $data['PropertyState'],
        'Zip Code' => $data['PropertyZipCode']
    ]);

    // Vesting Information
    $pdf->Ln(5);
    $this->addSectionHeader($pdf, 'Vesting Information', $headerColor);
    $this->addDataTable($pdf, [
        'Deed Type' => $data['VestingDeedType'],
        'Title Vested In' => $data['VestingBookPage'],
        'Grantor' => $data['VestingGrantor'],
        'Dated' => $data['VestingDated'],
        'Recorded' => $data['VestingRecordedDate'],
        'Book & Page' => $data['VestingBookPage'],
        'Comments' => $data['VestingComments']
    ], true);

    // Open Mortgages
    $pdf->Ln(5);
    $this->addSectionHeader($pdf, 'Open Mortgages', $headerColor);
    $this->addDataTable($pdf, [
        'Amount' => $data['OpenMortgageAmount'],
        'Dated' => $data['OpenMortgageDated'],
        'Recorded' => $data['OpenMortgageRecordedDate'],
        'Lender' => $data['OpenMortgageLenderMortgagee'],
        'Borrower' => $data['OpenMortgageBorrowerMortgagor'],
        'Instrument' => $data['OpenMortgageInstrument'],
        'Comments' => $data['OpenMortgageComments']
    ], true);

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

    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetTextColor($headerColor[0], $headerColor[1], $headerColor[2]);
    $pdf->Cell(0, 10, 'AOL Insurance & Wrap Language', 0, 1, 'C');
    $pdf->Ln(5);

    // Final Output
    //$pdf->Output('D', "AssignmentDetails-$id.pdf");
	// Define the file path in webroot directory
	$filePath = WWW_ROOT . 'files' . DS . 'export' . DS . 'aol_assignment' . DS . 'pdf' . DS . "AssignmentDetails-$id.pdf";
	// Ensure the directory exists
	if (!is_dir(dirname($filePath))) {
		mkdir(dirname($filePath), 0777, true);
	}
	// Save the PDF to the server
	$pdf->Output('F', $filePath);
	$pdf->Output('D', "AssignmentDetails-$id.pdf");

}

private function addSectionHeader(&$pdf, $title, $headerColor)
{
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor($headerColor[0], $headerColor[1], $headerColor[2]);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(0, 10, $title, 1, 1, 'L', true);
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
        $lineHeight = 8;
        $maxWidth = $pdf->GetStringWidth($value);
        $numLines = ceil($maxWidth / $colWidth);
        $cellHeight = max(8, $numLines * $lineHeight);

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

    public function static_page1($id)
    {
        // Do not auto-render a view
        $this->autoRender = false;

        // Include the FPDF library
        require_once(FPDF_VENDER . "lrs_pdf.php");
        $pdf = new LRS_PDF_ACCURATE();

        // Generate PDF content
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        // Title
        $pdf->Cell(0, 10, 'National Attorney Title', 0, 1, 'C');
        $pdf->Ln(5);

        // Add Policy Content
        $pdf->SetFont('Arial', '', 10);

        // Item 2
        $pdf->Cell(0, 8, 'Item 2. Policy Period:', 0, 1);
        $pdf->MultiCell(0, 8, 'From 051°01 [20xx to 05L07 L20xx (12:01 a.m. Standard Time)]');

        // Item 3
        $pdf->Cell(0, 8, 'Item 3. Limit of Liability:', 0, 1);
        $pdf->MultiCell(0, 8, 'As set forth in Section II Limits of Liability');

        // Item 4
        $pdf->Cell(0, 8, 'Item 4. Coverage Part(s):', 0, 1);
        $pdf->MultiCell(0, 8, 'Applicable to this Policy: See Item 7.');

        // Item 5
        $pdf->Cell(0, 8, 'Item 5. Premium:', 0, 1);
        $pdf->MultiCell(0, 8, 'Additional premium due shall be applicable to each Coverage Part Report for which coverage is provided under the terms of Section I Insuring Agreement.');

        // Item 6
        $pdf->Cell(0, 8, 'Item 6. Taxes and Fees:', 0, 1);
        $pdf->MultiCell(0, 8, "- Surplus Lines Pre111tml Tax: 4.85%, or \$0.0485 per \$1.00 of premium");
        $pdf->MultiCell(0, 8, "- Stamping Fee: 0.075%, or \$0.00075 per \$1.00 of premium");

        // Item 7
        $pdf->Cell(0, 8, 'Item 7. The following Forms(s) and/or Endorsement(s) are made a part of this Policy at issuance:', 0, 1);
        $forms = [
            'IFC EO P 0001 0520 Blanket Policy',
            'IFC EO P 0002 0524 Service of Process',
            'IFC EO P 0003 0524 Arbitration Provision',
            'IFC EO P 0004 0524 Certified Acts of Terrorism C v rag and Cap on Certified Acts Losses',
            'IFC EO P 0011 1223 Refinance Attorney Title Opinion Servt <ile Agreement Form',
            'IFC EO E 0015 0524 General Change Endor. ement',
            'IFC EO E 0016 0524 Add. it. \Un of Service Agreement with A Lender or Client Endorsement',
            'IFC EO E 0017 0524 Service Agreement f anuscript Endorsement',
            'IFC EO P 0018 0524 Privacy otice'
        ];
        foreach ($forms as $form) {
            $pdf->MultiCell(0, 8, "- " . $form);
        }

        // Return PDF as string
        return $pdf->Output('S'); // Returns the PDF data as a string
    }

}
