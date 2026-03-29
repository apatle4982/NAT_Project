<?php
// src/Controller/ReviewsController.php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Routing\Router;

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
        $this->viewBuilder()->setLayout('default');
        $this->autoRender = true;
        $this->Authentication->allowUnauthenticated(['index', 'add']);
    }

    public function index($id = null){
        if ($id !== null) {
            $id = (int) $id;
            $this->set('reviewId', $id);
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
    	$examReceiptFields = $this->FilesExamReceipt->getMainDataAll($fmd_id);
    	$partnerMapFields = $this->CompanyFieldsMap->partnerMapFields($companyId);
        $attorney = $this->FilesAttorneyAssignment->find()->where(['RecId' => $id])->first();
        $attorney_dtl = $this->Vendors->find()->where(['Id' => $attorney['vendorid']])->first();
        //echo "<pre>";print_r($attorney_dtl['name']);echo "</pre>";
        $this->set(compact('FilesMainData','examReceiptFields', 'attorney_dtl'));
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if(count($this->request->getData('answer'))>0){
                $data['answer'] = json_encode($data['answer']);
            }
        //echo "<pre>";print_r($data);echo "</pre>";exit;
            $review = $this->AttorneyReviews->patchEntity($review, $data);
            if ($review->getErrors()) {
                debug($review->getErrors()); // Show validation errors
                exit;
            }
            if ($this->AttorneyReviews->save($review)) {
                $fullUrl = Router::url(['controller' => 'Reviews', 'action' => 'index', $id], true);
                $this->Flash->success(__('Your review has been submitted.'));
                return $this->redirect($fullUrl);
            }
            $this->Flash->error(__('Unable to submit your review.'));
        }
        $this->set(compact('review'));
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
        //echo "<pre>";print_r($data);echo "</pre>";exit;
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

        foreach ($data as $key => $value) {
            $data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['ID','Name']);
        }
		return $data;
	}

    public function edit($id = null){
        $AttorneyReviews = $this->AttorneyReviews->get($id);
        $AolData = $this->FilesAolAssignment->find()->where(['RecId'=>$id])->first();
        $AttData = $this->FilesAttorneyAssignment->find()->where(['RecId'=>$id])->first();


        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            $AttorneyReviews = $this->AttorneyReviews->patchEntity($AttorneyReviews, $data);

            if ($this->AttorneyReviews->save($AttorneyReviews)) {
                $this->Flash->success(__('The Attorney review has been updated.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Unable to update the review.'));
        }

        $this->set(compact('AolData'));
        $this->set(compact('AttData'));
        $this->set(compact('AttorneyReviews'));
        $this->render('add'); // Reuses the 'add' template
    }


    /*public function edit($id = null){
        $AttorneyReviews = $this->AttorneyReviews->get($id);

        if($this->request->getData()){
            $data = $this->request->getData();

        }
        //echo "<pre>";print_r($data);echo "</pre>";exit;
        if ($this->request->is(['post', 'put'])) {
            $AttorneyReviews = $this->AttorneyReviews->patchEntity($AttorneyReviews, $data);
            if ($this->AttorneyReviews->save($AttorneyReviews)) {
                $this->Flash->success(__('The Attorney review has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update the review.'));
        }
        $this->set(compact('AttorneyReviews'));
        $this->render('add');
    }*/
}

// templates/Reviews/index.php
?>