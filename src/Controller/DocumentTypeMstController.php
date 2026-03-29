<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DocumentTypeMst Controller
 *
 * @property \App\Model\Table\DocumentTypeMstTable $DocumentTypeMst
 * @method \App\Model\Entity\DocumentTypeMst[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentTypeMstController extends AppController
{
	private $columns_alise = [  
                                "ID" => "DocumentTypeMst.Id",
								"Title" => "DocumentTypeMst.Title",
								'SimplifileDocumentType'=>'DocumentSimplifileMst.document_type_name',
								'CountyCalDocumentType'=>'DocumentCountycalMst.document_type_name',
								'CSCDocumentType'=>'DocumentCscMst.document_type_name',
								"Actions" => ""
                            ];
	private $columnsorder = ['DocumentTypeMst.Id','DocumentTypeMst.Title','DocumentTypeMst.document_type_name','DocumentTypeMst.document_type_name','DocumentTypeMst.document_type_name'];
	
	public function initialize(): void
	{
	   parent::initialize();	  
	   $this->loadModel('DocumentSimplifileMst');	  
	   $this->loadModel('DocumentCountycalMst');	  
	   $this->loadModel('DocumentCscMst');	  
	  
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
        // set page title
		$pageTitle = 'Document Type Listing';
		$this->set(compact('pageTitle'));
		
		// $this->paginate = [
            // 'contain' => ['DocumentSimplifileMst','DocumentCountycalMst','DocumentCscMst'],
        // ];
		// $settings = ['limit' => 99999, 
					// 'maxLimit' => 99999];
        // $documentTypeMst = $this->paginate($this->DocumentTypeMst, $settings);
		
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
    }
	
	public function ajaxListIndex(){ 
		$this->autoRender = false;
		$modelname = $this->name;
		array_pop($this->columns_alise); 
		$this->columns_alise = array_merge($this->columns_alise,['simplifileDocType'=>'DocumentSimplifileMst.document_type_name','CountyDocType'=>'DocumentCountycalMst.document_type_name','cscDocType'=>'DocumentCscMst.document_type_name']);
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
		
		$query = $this->$modelname->find('search',$pdata['condition'])->contain(['DocumentSimplifileMst','DocumentCountycalMst','DocumentCscMst']);
		//debug($query);
		if($pdata['is_search'] === false){
		    $recordsTotal = $this->$modelname->find('all',['fields'=>['DocumentTypeMst.Id']])->count();
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
            $data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['ID','Title']);
        }
		return $data;
	}
    /**
     * View method
     *
     * @param string|null $id Document Type Mst id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $documentTypeMst = $this->DocumentTypeMst->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('documentTypeMst'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
           // set page title
		 $pageTitle = 'Add Document Type';
		 $this->set(compact('pageTitle'));

        $documentTypeMst = $this->DocumentTypeMst->newEmptyEntity();
        if ($this->request->is('post')) {
            $documentTypeMst = $this->DocumentTypeMst->patchEntity($documentTypeMst, $this->request->getData());
           
            if ($this->DocumentTypeMst->save($documentTypeMst)) {
                $this->Flash->success(__('The document type mst has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document type mst could not be saved. Please, try again.'));
        }
		
		$docSimplifileType = $this->DocumentSimplifileMst->documentSimplifileTypeListing();
		
		$docCountycalType = $this->DocumentCountycalMst->documentCountycalTypeListing();
		
		$docCSCType = $this->DocumentCscMst->documentCSCTypeListing();
		
        $this->set(compact('documentTypeMst','docSimplifileType','docCountycalType','docCSCType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Document Type Mst id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
         // set page title
		$pageTitle = 'Edit Document Type';
		$this->set(compact('pageTitle'));
        $documentTypeMst = $this->DocumentTypeMst->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $documentTypeMst = $this->DocumentTypeMst->patchEntity($documentTypeMst, $this->request->getData());
            if ($this->DocumentTypeMst->save($documentTypeMst)) {
                $this->Flash->success(__('The document type mst has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document type mst could not be saved. Please, try again.'));
        }
		$docSimplifileType = $this->DocumentSimplifileMst->documentSimplifileTypeListing();
		
		$docCountycalType = $this->DocumentCountycalMst->documentCountycalTypeListing();
		
		$docCSCType = $this->DocumentCscMst->documentCSCTypeListing();
		
        $this->set(compact('documentTypeMst','docSimplifileType','docCountycalType','docCSCType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document Type Mst id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $documentTypeMst = $this->DocumentTypeMst->get($id);
        if ($this->DocumentTypeMst->delete($documentTypeMst)) {
            $this->Flash->success(__('The document type mst has been deleted.'));
        } else {
            $this->Flash->error(__('The document type mst could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
