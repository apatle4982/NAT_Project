<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DocumentCscMst Controller
 *
 * @property \App\Model\Table\DocumentCscMstTable $DocumentCscMst
 * @method \App\Model\Entity\DocumentCscMst[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentCscMstController extends AppController
{
	private $columns_alise = [  
                                "ID" => "DocumentCscMst.Id",
								"State" => "States.State_name",
								'County'=>'CountyMst.cm_title',
								'TransactionType'=>'DocumentTypeMst.Title',
								'cscDocumentTypeName'=>'DocumentCscMst.document_type_name',
								"Actions" => ""
                            ];
	private $columnsorder = ['DocumentCscMst.Id','DocumentCscMst.State_name','DocumentCscMst.cm_title','DocumentCscMst.Title','DocumentCscMst.document_type_name'];
	
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
        $documentCscMst = $this->paginate($this->DocumentCscMst);

        $this->set(compact('documentCscMst'));*/
		
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
		
		$this->set('pageTitle','CSC Document Type Listing');
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
		    $recordsTotal = $this->$modelname->find('all',['fields'=>['DocumentCscMst.Id']])->count();
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
            $data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['ID','cscDocumentTypeName']);
        }
		return $data;
	}
    /**
     * View method
     *
     * @param string|null $id Document Csc Mst id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $documentCscMst = $this->DocumentCscMst->get($id, [
            'contain' => ['States'],
        ]);

        $this->set(compact('documentCscMst'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $documentCscMst = $this->DocumentCscMst->newEmptyEntity();
        if ($this->request->is('post')) {
            $documentCscMst = $this->DocumentCscMst->patchEntity($documentCscMst, $this->request->getData());
            if ($this->DocumentCscMst->save($documentCscMst)) {
                $this->Flash->success(__('The document csc type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document csc type could not be saved. Please, try again.'));
        }
        //$States = $this->DocumentCscMst->States->find('list', ['limit' => 200])->all();
		
		$StateList = $this->States->StateListArray();		
		$this->set('StateList', $StateList);
		
		$CountyList = $this->CountyMst->getCountyIdByState();
		$this->set('CountyList', $CountyList);
		
		$DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
		$this->set('DocumentTypeData', $DocumentTypeData);
		
		$this->set('pageTitle','Add CSC Document Type');
		
        $this->set(compact('documentCscMst'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Document Csc Mst id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $documentCscMst = $this->DocumentCscMst->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $documentCscMst = $this->DocumentCscMst->patchEntity($documentCscMst, $this->request->getData());
            if ($this->DocumentCscMst->save($documentCscMst)) {
                $this->Flash->success(__('The document csc type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document csc type could not be saved. Please, try again.'));
        }
        //$States = $this->DocumentCscMst->States->find('list', ['limit' => 200])->all();
		$StateList = $this->States->StateListArray();		
		$this->set('StateList', $StateList);
		
		$CountyList = $this->CountyMst->getCountyIdByState();
		$this->set('CountyList', $CountyList);
		
		$DocumentTypeData = $this->DocumentTypeMst->documentTypeListing();
		$this->set('DocumentTypeData', $DocumentTypeData);
		
		$this->set('pageTitle','Edit CSC Document Type');
		
        $this->set(compact('documentCscMst'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document Csc Mst id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $documentCscMst = $this->DocumentCscMst->get($id);
        if ($this->DocumentCscMst->delete($documentCscMst)) {
            $this->Flash->success(__('The document csc type has been deleted.'));
        } else {
            $this->Flash->error(__('The document csc type could not be deleted. Please, try again.'));
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
