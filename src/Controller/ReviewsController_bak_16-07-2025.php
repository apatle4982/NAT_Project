<?php
// src/Controller/ReviewsController.php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Routing\Router;
use Cake\Core\Configure;
use App\Controller\PdfController;

class ReviewsController extends AppController
{
    private $columnHeaders = ["RecId","status","comment","created_date"];

	private $columns_alise = [
                                "ID" => "Id",
								"RecId" => "RecId",
								'Status'=>'status',
								'Comment'=>'comment',
								'Created date'=>'created_date',
								"Actions" => ""
                            ];
	private $columnsorder = ['Id','RecId','status','comment','created_date'];
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel("FilesMainData");
        $this->loadModel('FilesVendorAssignment');
        $this->loadModel('FilesAolAssignment');
        $this->loadModel('FilesAttorneyAssignment');
        $this->loadModel('FilesEscrowAssignment');
        $this->loadComponent('GeneratePDF');
        $this->loadModel('AttorneyReviews');
        $this->loadModel('FilesExamReceipt');
        $this->loadModel("CompanyFieldsMap");
        $this->loadModel("CompanyMst");
        $this->loadModel("Vendors");
        $this->loadModel('PublicNotes');
        $this->viewBuilder()->setLayout('default');
        $this->autoRender = true;
        //$this->Authentication->allowUnauthenticated(['index', 'add']);
    }

    public function index($id = null){
        if ($id !== null) {
            $id = (int) $id;
            $this->set('reviewId', $id);
            
           // echo $id; exit;
            
            $fmd_data = $this->FilesMainData->find()->where(['Id' => $id])->first();
            
        } else {
            $aol_data = null; // Set a default value to avoid query errors
        }
        
        
        $this->set(compact('fmd_data'));
        //echo "<pre>";print_r($fmd_data);echo "</pre>";
        $review = $this->AttorneyReviews->newEmptyEntity();
        $FilesMainData = $fmd_data; // file main data id
        $fmd_id = $fmd_data['Id']; // file main data id
    	$companyId = $fmd_data['company_id']; // need to discuss
    	$examReceiptFields = $this->FilesExamReceipt->getMainDataAll($id);
        $examReceiptFields1 = $this->FilesExamReceipt->find()->where(['RecId' => $id])->first();
    	$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($companyId);
    	
    	
    	
    	
        $attorney = $this->FilesAttorneyAssignment->find()->where(['RecId' => $id])->first(); 
        $attorney_dtl = [];
        if(!empty($attorney)){
            $attorney_dtl = $this->Vendors->find()->where(['Id' => $attorney['vendorid']])->first(); 
        }
       
        //echo "<pre>";print_r($attorney_dtl['name']);echo "</pre>";
        $this->set(compact('FilesMainData','examReceiptFields', 'attorney_dtl', 'examReceiptFields1'));
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            /*if(count($this->request->getData('answer'))>0){
                $data['answer'] = json_encode($data['answer']);
            }*/
        //echo "<pre>";print_r($data);echo "</pre>";exit;
            $review = $this->AttorneyReviews->patchEntity($review, $data);
            if ($review->getErrors()) {
                debug($review->getErrors()); // Show validation errors
                exit;
            }
            /*SIGN*/
            $RecId = $this->request->getData('RecIdSign');
            $signatureData = $this->request->getData('signature');

            if (!empty($signatureData)) {

                list($type, $data) = explode(';', $signatureData);
                list(, $data) = explode(',', $data);
                $decodedData = base64_decode($data);
                $signaturePath = WWW_ROOT . "files/signature_{$clientId}.png";
                file_put_contents($signaturePath, $decodedData);
            }
            
            if ($this->AttorneyReviews->save($review)) {
                $fullUrl = Router::url(['controller' => 'Reviews', 'action' => 'index', $id], true);

                $currentUserId = $this->currentUser->user_id;
                $FmdData = $this->FilesMainData->find()->where(['Id' => $id])->first();
                $this->PublicNotes->insertNewPublicNotes($id, $FmdData['TransactionType'], $currentUserId, "Review has been submitted by Attorney", 'Aol',true, "Aol Review Submission");

                $this->Flash->success(__('Your review has been submitted.'));
                return $this->redirect($fullUrl);
            }
            $this->Flash->error(__('Unable to submit your review.'));
        }
        $this->set(compact('review'));
    }

    public function saveSignature() {

        if ($this->request->is('post')) {
            $RecId = $this->request->getData('RecIdSign');
            $signatureData = $this->request->getData('signature');

            if (!empty($signatureData)) {
                // Extract base64 image data
                list($type, $data) = explode(';', $signatureData);
                list(, $data) = explode(',', $data);
                $decodedData = base64_decode($data);

                // Save Signature Image
                $signaturePath = WWW_ROOT.'files'.DS.'signature'.DS.'aol'.DS.'signature_'.$RecId.'.png';

                file_put_contents($signaturePath, $decodedData);

                $pdfController = new PdfController();
                $pdfController->generatePdf($RecId, "final", true);
                $pdfController->generatePdf($RecId, "signature", true);

                $response = ['status' => 'success', 'message' => 'Signature saved successfully.'];
                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode($response));

            } else {
                $this->Flash->error(__('Signature is required.'));
            }
        }

        return $this->redirect(['controller' => 'Reviews', 'action' => 'index', $RecId]);
    }

    public function list(){
        // set page title
		$pageTitle = 'Attorney Reviews List';
        $this->set(compact('pageTitle'));

		$AttorneyReviews = $this->AttorneyReviews->newEmptyEntity();

		// step for datatable config : 3
		$this->set('dataJson',$this->CustomPagination->setDataJson($this->columns_alise,['Actions']));

		// step for datatable config : 4

		$isSearch = 0;
		$formpostdata = '';
		if ($this->request->is(['patch', 'post', 'put'])) {
			$formpostdata = $this->request->getData();
			$isSearch = 1;
		}
		$this->set('formpostdata', $formpostdata);
		//end step
		$this->set('isSearch', $isSearch);

		$this->set(compact('AttorneyReviews'));
    }

    public function ajaxListIndex(){
		$this->autoRender = false;
		$modelname = "AttorneyReviews";
		array_pop($this->columns_alise);

        $this->CustomPagination->setPaginationData(['request'=>$this->request->getData(),
                                                     'columns'=>$this->columnsorder,
                                                     'columnAlise'=>$this->columns_alise,
                                                     'modelName'=>$modelname
                                                   ]);

		$pdata = $this->CustomPagination->getQueryData();

		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END

		$query = $this->$modelname->find('search',$pdata['condition']);

		if($pdata['is_search'] === false){
		    $recordsTotal = $this->$modelname->find('all',['fields'=>['id']])->count();
		}else{
			unset($pdata['condition']['limit'], $pdata['condition']['offset']);
			$recordsTotal = $this->$modelname->find('all')->count();
		}

        $results = $query->disableHydration()->all();

        $data = $results->toArray();
		$data = $this->getParsingData($data);
        $i=0;
        foreach($data as $k=>$v){
            $fmd_data = $this->FilesMainData->find()->where(['Id' => $v['RecId']])->first();
            $data[$i]['RecId'] = $fmd_data->NATFileNumber;
            $i++;
        }
        //echo "<pre>";print_r($data);echo "</pre>";
        $response = array(
            "draw" => intval($pdata['draw']),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsTotal),
            "data" => $data
        );

		echo json_encode($response);
        exit;
    }

    private function getParsingData(array $data){
        $text = '';

        foreach ($data as $key => $value) {
            $fileUrl = Router::url('/files/export/aol_assignment/pdf/aol_signed/' . "AssignmentDetails-" . $value['RecId'] . ".pdf", true);

            //$data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['RecId','Name']);
            $data[$key]['Actions'] .=  '<a href="'.Router::url(['controller' => 'reviews','action' => 'edit/'.$value['RecId']]).'" title="Edit" class="link-success fs-15"><i class="ri-edit-2-line"></i></a> ';
            $data[$key]['Actions'] .=  '<a download href="'.$fileUrl.'" title="Download Signed PDF" class="link-success fs-15"><i class="ri-file-pdf-line" aria-hidden="true"></i></a> ';;
        }
		return $data;
	}

    /*public function edit($id = null){
        $AttorneyReviews = $this->AttorneyReviews->get($id);
        $fmd_data = $this->FilesMainData->find()->where(['Id' => $id])->first();

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            // Set correct primary key field
            $data['RecId'] = $id;

            // Define upload directory
            $uploadPath = WWW_ROOT . 'uploads' . DS;

            // Ensure the uploads directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Handle file upload
            if (!empty($data['supporting_documentation']) && $data['supporting_documentation'] instanceof \Laminas\Diactoros\UploadedFile) {
                if ($data['supporting_documentation']->getClientFilename()) {
                    $file = $data['supporting_documentation'];
                    $fileName = time() . '_' . $file->getClientFilename();
                    $file->moveTo($uploadPath . $fileName);
                    $data['supporting_documentation'] = $fileName;
                }
            } else {
                // Retain existing file if no new file is uploaded
                unset($data['supporting_documentation']);
            }

            // Debugging output to verify patched entity
            //debug($data);

            $AttorneyReviews = $this->AttorneyReviews->patchEntity($AttorneyReviews, $data);

            // Check if entity contains modified data
            debug($AttorneyReviews);

            // Save the record
            if ($this->AttorneyReviews->save($AttorneyReviews)) {
                $this->Flash->success(__('The Attorney review has been updated.'));
                return $this->redirect(['action' => 'list']);
            }

            $this->Flash->error(__('Unable to update the review.'));
        }

        $this->set(compact('AttorneyReviews'));
        $this->set(compact('fmd_data'));
        $this->render('add');
    }*/

    public function edit($id = null){
        // Fetch the existing review record
        $AttorneyReviews = $this->AttorneyReviews->get($id);
        $fmd_data = $this->FilesMainData->find()->where(['Id' => $id])->first();
        $AttData = $this->FilesAttorneyAssignment->find()->where(['RecId' => $id])->first();
        $AolData = $this->FilesAolAssignment->find()->where(['RecId' => $id])->first();

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            // Set primary key
            $data['Id'] = $id;

            // Define upload directory
            $uploadPath = WWW_ROOT . 'uploads' . DS;

            // Ensure uploads directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Handle file upload properly
            if (
                isset($data['supporting_documentation']) &&
                $data['supporting_documentation'] instanceof \Laminas\Diactoros\UploadedFile
            ) {
                if ($data['supporting_documentation']->getClientFilename()) {
                    $file = $data['supporting_documentation'];
                    $fileName = time() . '_' . $file->getClientFilename();

                    try {
                        // Move the file
                        $file->moveTo($uploadPath . $fileName);

                        // Save only the filename as a string
                        $data['supporting_documentation'] = $fileName;
                    } catch (\Exception $e) {
                        $this->Flash->error(__('File upload failed: ' . $e->getMessage()));
                        return $this->redirect(['action' => 'edit', $id]);
                    }
                } else {
                    // If no file uploaded, keep existing file name
                    $data['supporting_documentation'] = $AttorneyReviews->supporting_documentation;
                }
            } else {
                // Keep the existing file name if no new file is uploaded
                unset($data['supporting_documentation']);
            }

            // Ensure RecId is included
            $data['RecId'] = $id;

            // Debugging: Check what data is being passed
            //debug($data);

            // Patch and save entity
            $AttorneyReviews = $this->AttorneyReviews->patchEntity($AttorneyReviews, $data);

            // Debugging: Check for validation errors
            if ($AttorneyReviews->getErrors()) {
                debug($AttorneyReviews->getErrors()); // Output validation errors
                $this->Flash->error(__('Validation failed! Please check the form inputs.'));
                return;
            }

            if ($this->AttorneyReviews->save($AttorneyReviews)) {
                $this->Flash->success(__('The Attorney review has been updated.'));
                return $this->redirect(['action' => 'list']);
            } else {
                $this->Flash->error(__('Unable to update the review.'));
            }
        }

        $this->set(compact('AttorneyReviews', 'fmd_data', 'AttData', 'AolData'));
        $this->render('add');
    }
}
?>