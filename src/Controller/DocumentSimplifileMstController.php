<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DocumentSimplifileMst Controller
 *
 * @property \App\Model\Table\DocumentSimplifileMstTable $DocumentSimplifileMst
 * @method \App\Model\Entity\DocumentSimplifileMst[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentSimplifileMstController extends AppController
{
	private $columns_alise = [  
                                "ID" => "DocumentSimplifileMst.Id",
								"State" => "States.State_name",
								'County'=>'CountyMst.cm_title',
								'TransactionType'=>'DocumentTypeMst.Title',
								'simplifileDocumentTypeName'=>'DocumentSimplifileMst.document_type_name',
								"Actions" => ""
                            ];
	private $columnsorder = ['DocumentSimplifileMst.Id','DocumentSimplifileMst.State_name','DocumentSimplifileMst.cm_title','DocumentSimplifileMst.Title','DocumentSimplifileMst.document_type_name'];
	
	public function beforeFilter(\Cake\Event\EventInterface $event)
	{
		parent::beforeFilter($event);
		$this->Authentication->addUnauthenticatedActions(['Users/login']);
		$this->loginAccess();
	}
	
	public function initialize(): void
	{
	   parent::initialize();	  
	   $this->loadModel('CountyMst');	  
	   $this->loadModel('States');
	   $this->loadModel("DocumentTypeMst");
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        /*$this->paginate = [
            'contain' => ['States','CountyMst','DocumentTypeMst'],
        ];
		
        $documentSimplifileMst = $this->paginate($this->DocumentSimplifileMst);
	 
		//pr($documentSimplifileMst); exit;
        $this->set(compact('documentSimplifileMst'));*/
		
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
		
		$this->set('pageTitle','Simplifile Document Type Listing');
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
		    $recordsTotal = $this->$modelname->find('all',['fields'=>['DocumentSimplifileMst.Id']])->count();
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
            $data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['ID','simplifileDocumentTypeName']);
        }
		return $data;
	}
    /**
     * View method
     *
     * @param string|null $id Document Simplifile Mst id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $documentSimplifileMst = $this->DocumentSimplifileMst->get($id, [
            'contain' => ['States'],
        ]);

        $this->set(compact('documentSimplifileMst'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $documentSimplifileMst = $this->DocumentSimplifileMst->newEmptyEntity();
        if ($this->request->is('post')) {
            $documentSimplifileMst = $this->DocumentSimplifileMst->patchEntity($documentSimplifileMst, $this->request->getData());
            if ($this->DocumentSimplifileMst->save($documentSimplifileMst)) {
                $this->Flash->success(__('The document simplifile type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document simplifile type could not be saved. Please, try again.'));
        }
        //$States = $this->DocumentSimplifileMst->States->find('list', ['limit' => 200])->all();
		$StateList = $this->States->StateListArray();		
		$this->set('StateList', $StateList);
		
		$CountyList = $this->CountyMst->getCountyIdByState();
		$this->set('CountyList', $CountyList);
		
		$DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
		$this->set('DocumentTypeData', $DocumentTypeData);
		
		$this->set('pageTitle','Add Simplifile Document Type');
		
        $this->set(compact('documentSimplifileMst'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Document Simplifile Mst id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $documentSimplifileMst = $this->DocumentSimplifileMst->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $documentSimplifileMst = $this->DocumentSimplifileMst->patchEntity($documentSimplifileMst, $this->request->getData());
            if ($this->DocumentSimplifileMst->save($documentSimplifileMst)) {
                $this->Flash->success(__('The document simplifile type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document simplifile type could not be saved. Please, try again.'));
        }
        //$States = $this->DocumentSimplifileMst->States->find('list', ['limit' => 200])->all();
		$StateList = $this->States->StateListArray();		
		$this->set('StateList', $StateList);
		
		$CountyList = $this->CountyMst->getCountyIdByState();
		$this->set('CountyList', $CountyList);
		
		$DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
		$this->set('DocumentTypeData', $DocumentTypeData);
		
		$this->set('pageTitle','Edit Simplifile Document Type');
		
        $this->set(compact('documentSimplifileMst'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document Simplifile Mst id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $documentSimplifileMst = $this->DocumentSimplifileMst->get($id);
        if ($this->DocumentSimplifileMst->delete($documentSimplifileMst)) {
            $this->Flash->success(__('The document simplifile type has been deleted.'));
        } else {
            $this->Flash->error(__('The document simplifile type could not be deleted. Please, try again.'));
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
