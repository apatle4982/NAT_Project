<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DocumentCountycalMst Controller
 *
 * @method \App\Model\Entity\DocumentCountycalMst[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentCountycalMstController extends AppController
{
	private $columns_alise = [  
                                "ID" => "DocumentCountycalMst.Id",
								"State" => "States.State_name",
								'County'=>'CountyMst.cm_title',
								'TransactionType'=>'DocumentTypeMst.Title',
								'CountyCalDocumentTypeName'=>'DocumentCountycalMst.document_type_name',
								"Actions" => ""
                            ];
	private $columnsorder = ['DocumentCountycalMst.Id','DocumentCountycalMst.State_name','DocumentCountycalMst.cm_title','DocumentCountycalMst.Title','DocumentCountycalMst.document_type_name'];
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
	public function initialize(): void
	{
	   parent::initialize();	  
	   $this->loadModel('CountyMst');	  
	   $this->loadModel('States');
	   $this->loadModel("DocumentTypeMst");
	}
	public function beforeFilter(\Cake\Event\EventInterface $event)
    {
		parent::beforeFilter($event); 
		$this->loginAccess();
	}
    public function index()
    {		
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
		
		$this->set('pageTitle','County Cal Document Type Listing');
        //$this->set(compact('documentCountycalMst'));
    }
	public function ajaxListIndex(){ 
		$this->autoRender = false;
		$modelname = $this->name;
		array_pop($this->columns_alise); 
		$this->columns_alise = array_merge($this->columns_alise,['StateName'=>'States.State_name','CountyName'=>'CountyMst.cm_title','docType'=>'DocumentTypeMst.Title']);
		
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
		
		$query = $this->$modelname->find('search',$pdata['condition'])->contain(['States','CountyMst','DocumentTypeMst']);
		
		if($pdata['is_search'] === false){
		    $recordsTotal = $this->$modelname->find('all',['fields'=>['DocumentCountycalMst.Id']])->count();
		}else{ 
			unset($pdata['condition']['limit'], $pdata['condition']['offset']);
			$recordsTotal = $this->$modelname->find('all')->count();
		}
 
        $results = $query->disableHydration()->all();
		
        $data = $results->toArray(); 
		$data = $this->getParsingData($data);
        
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
            $data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['ID','CountyCalDocumentTypeName']);
        }
		return $data;
	}
    /**
     * View method
     *
     * @param string|null $id Document Countycal Mst id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $documentCountycalMst = $this->DocumentCountycalMst->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('documentCountycalMst'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $documentCountycalMst = $this->DocumentCountycalMst->newEmptyEntity();
        if ($this->request->is('post')) {
			
			$postData = $this->request->getData();
            $documentCountycalMst = $this->DocumentCountycalMst->patchEntity($documentCountycalMst, $postData);
            if ($this->DocumentCountycalMst->save($documentCountycalMst)) {
                $this->Flash->success(__('The document Countycal type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document Countycal type could not be saved. Please, try again.'));
        }
		
		$StateList = $this->States->StateListArray();		
		$this->set('StateList', $StateList);
		
		$CountyList = $this->CountyMst->getCountyIdByState();
		$this->set('CountyList', $CountyList);
		
		$DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
		$this->set('DocumentTypeData', $DocumentTypeData);
		
		$this->set('pageTitle','Add County Cal Document Type');
        $this->set(compact('documentCountycalMst'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Document Countycal Mst id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $documentCountycalMst = $this->DocumentCountycalMst->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $documentCountycalMst = $this->DocumentCountycalMst->patchEntity($documentCountycalMst, $this->request->getData());
            if ($this->DocumentCountycalMst->save($documentCountycalMst)) {
                $this->Flash->success(__('The document Countycal mst has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document Countycal mst could not be saved. Please, try again.'));
        }
		
		$StateList = $this->States->StateListArray();		
		$this->set('StateList', $StateList);
		
		$CountyList = $this->CountyMst->getCountyIdByState();
		$this->set('CountyList', $CountyList);
		
		$DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
		$this->set('DocumentTypeData', $DocumentTypeData);
		
		$this->set('pageTitle','Edit County Cal Document Type');
        $this->set(compact('documentCountycalMst'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document Countycal Mst id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $documentCountycalMst = $this->DocumentCountycalMst->get($id);
        if ($this->DocumentCountycalMst->delete($documentCountycalMst)) {
            $this->Flash->success(__('The document Countycal mst has been deleted.'));
        } else {
            $this->Flash->error(__('The document Countycal mst could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function searchCountyAjax()
	{
		$this->autoRender = false;
		
		$id = $this->request->getData('id'); 
		
		$CountyTitle = $this->CountyMst->getCountysByStateId($id); 
		
		$towstxtErrorCounty = '<select name="County_id" class="form-control" required="required"><option value="">Select County</option>';
		foreach($CountyTitle as $key=>$CountyText){
			if($CountyText['cm_title'] != null){   
				$towstxtErrorCounty .= '<option value="'.$CountyText['cm_id'].'"'; 
				$towstxtErrorCounty .= '>'.$CountyText['cm_title'].'</option>';
			}
		}
		$towstxtErrorCounty .= '</select>';
		echo $towstxtErrorCounty; 
		exit;
	}
	
}
