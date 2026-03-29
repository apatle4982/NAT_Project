<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Schema\Collection;
use Cake\Database\Schema\TableSchema;
use Cake\ORM\TableRegistry;
/**
 * FilesMainData Model
 *
 * @method \App\Model\Entity\FilesMainData newEmptyEntity()
 * @method \App\Model\Entity\FilesMainData newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FilesMainData[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FilesMainData get($primaryKey, $options = [])
 * @method \App\Model\Entity\FilesMainData findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FilesMainData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FilesMainData[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FilesMainData|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesMainData saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FilesMainData[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesMainData[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesMainData[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FilesMainData[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FilesMainDataTable extends Table
{
    private $setprifix = 'fva';
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
      
        $this->setTable('files_main_data'.ARCHIVE_PREFIX);
        $this->setAlias('fmd');
        $this->setDisplayField('Id');
        $this->setPrimaryKey('Id');
 
        $this->belongsTo('FilesShiptocountyData')
            ->setBindingKey('RecId')
            ->setForeignKey('Id')
            ->setJoinType('INNER');

        $this->belongsTo('DocumentTypeMst')
            ->setBindingKey('Id')
            ->setForeignKey('TransactionType')
            ->setJoinType('INNER');

        $this->addBehavior('Search.Search');	
		$this->addBehavior('CustomLRS');
 
        $this->searchManagerConfig();
    }

    public function searchManagerConfig()
    {
        $pri=$this->setprifix;

        $search = $this->searchManager();
		$search->Value('company_id');
        $search->Value('TransactionType',['prifix'=>$pri]); 

		$search->Like('NATFileNumber');
		$search->Like('PartnerFileNumber');
		$search->Like('LoanNumber');

		$search->Like('StreetNumber');
		$search->Like('StreetName');
		$search->Like('City');
		$search->Like('County');
		$search->Like('State');
		$search->Like('Zip');

		$search->Like('Grantors');
		$search->Like('Grantees');
		$search->Like('MortgagorGrantors');
		$search->Like('MortgageeLenderCompanyName');

		$search->Like('GrantorFirstName1');
		$search->Like('GrantorFirstName2');
		$search->Like('GranteeFirstName1');
		$search->Like('GranteeFirstName2');
		$search->Like('MortgagorGrantorFirstName1');
		$search->Like('MortgagorGrantorFirstName2');
		$search->Like('MortgageeFirstName1');
		$search->Like('MortgageeFirstName2');

		$search->Value('Status',['prifix'=>'fqcd']);
		$search->Value('cm_partner_cmp',['prifix'=>'cpm']);

        return $search;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
       /*  $validator
            ->integer('company_id')
            ->requirePresence('company_id', 'create')
            ->notEmptyString('company_id');

        $validator
            ->integer('ImportSheetId')
            ->requirePresence('ImportSheetId', 'create')
            ->notEmptyString('ImportSheetId');

        $validator
            ->scalar('CenterBranch')
            ->maxLength('CenterBranch', 255)
            ->allowEmptyString('CenterBranch');

        $validator
            ->scalar('LoanNumber')
            ->maxLength('LoanNumber', 50)
            ->requirePresence('LoanNumber', 'create')
            ->notEmptyString('LoanNumber');

        $validator
            ->scalar('LoanAmount')
            ->maxLength('LoanAmount', 20)
            ->allowEmptyString('LoanAmount');

        $validator
            ->dateTime('FileStartDate')
            ->allowEmptyDateTime('FileStartDate');

        $validator
            ->scalar('PartnerID')
            ->maxLength('PartnerID', 50)
            ->allowEmptyString('PartnerID');

        $validator
            ->scalar('NATFileNumber')
            ->maxLength('NATFileNumber', 50)
            ->allowEmptyString('NATFileNumber');

        $validator
            ->scalar('PartnerFileNumber')
            ->maxLength('PartnerFileNumber', 50)
            ->allowEmptyString('PartnerFileNumber');

        $validator
            ->scalar('Grantors')
            ->maxLength('Grantors', 255)
            ->allowEmptyString('Grantors');

        $validator
            ->scalar('GrantorFirstName1')
            ->maxLength('GrantorFirstName1', 50)
            ->allowEmptyString('GrantorFirstName1');

        $validator
            ->scalar('GrantorLastName1')
            ->maxLength('GrantorLastName1', 225)
            ->requirePresence('GrantorLastName1', 'create')
            ->notEmptyString('GrantorLastName1');
		
		$validator
            ->scalar('GrantorFirstName2')
            ->maxLength('GrantorFirstName2', 50)
            ->allowEmptyString('GrantorFirstName2');

        $validator
            ->scalar('GrantorLastName2')
            ->maxLength('GrantorLastName2', 50)
            ->allowEmptyString('GrantorLastName2');
			
		$validator
            ->scalar('GrantorMaritalStatus')
            ->maxLength('GrantorMaritalStatus', 50)
            ->allowEmptyString('GrantorMaritalStatus');
			
		$validator
            ->scalar('GrantorCorporationName')
            ->maxLength('GrantorCorporationName', 50)
            ->allowEmptyString('GrantorCorporationName');

        $validator
            ->scalar('Grantees')
            ->maxLength('Grantees', 255)
            ->allowEmptyString('Grantees');

        $validator
            ->scalar('GranteeFirstName1')
            ->maxLength('GranteeFirstName1', 100)
            ->allowEmptyString('GranteeFirstName1');

        $validator
            ->scalar('GranteeLastName1')
            ->maxLength('GranteeLastName1', 255)
            ->requirePresence('GranteeLastName1', 'create')
            ->notEmptyString('GranteeLastName1');
			
		$validator
            ->scalar('GranteeFirstName2')
            ->maxLength('GranteeFirstName2', 50)
            ->allowEmptyString('GranteeFirstName2');
			
		$validator
            ->scalar('GranteeLastName2')
            ->maxLength('GranteeLastName2', 50)
            ->allowEmptyString('GranteeLastName2');
			
		$validator
            ->scalar('marital_status_g2')
            ->maxLength('marital_status_g2', 50)
            ->allowEmptyString('marital_status_g2');
			
		$validator
            ->scalar('GranteeCorporationName')
            ->maxLength('GranteeCorporationName', 50)
            ->allowEmptyString('GranteeCorporationName');
			
		$validator
            ->scalar('MortgagorGrantors')
            ->maxLength('MortgagorGrantors', 255)
            ->allowEmptyString('MortgagorGrantors');
			
		$validator
            ->scalar('MortgagorGrantorFirstName1')
            ->maxLength('MortgagorGrantorFirstName1', 50)
            ->allowEmptyString('MortgagorGrantorFirstName1');
			
		$validator
            ->scalar('MortgagorGrantorLastName1')
            ->maxLength('MortgagorGrantorLastName1', 50)
            ->allowEmptyString('MortgagorGrantorLastName1');
			
		$validator
            ->scalar('MortgagorGrantorFirstName2')
            ->maxLength('MortgagorGrantorFirstName2', 50)
            ->allowEmptyString('MortgagorGrantorFirstName2');
			
		$validator
            ->scalar('MortgagorGrantorLastName2')
            ->maxLength('MortgagorGrantorLastName2', 50)
            ->allowEmptyString('MortgagorGrantorLastName2');
			
		$validator
            ->scalar('MortgagorGrantorMaritalStatus')
            ->maxLength('MortgagorGrantorMaritalStatus', 50)
            ->allowEmptyString('MortgagorGrantorMaritalStatus');
			
		$validator
            ->scalar('MortgagorGrantorCorporationName')
            ->maxLength('MortgagorGrantorCorporationName', 50)
            ->allowEmptyString('MortgagorGrantorCorporationName');
			
		$validator
            ->scalar('MortgageeLenderCompanyName')
            ->maxLength('MortgageeLenderCompanyName', 50)
            ->allowEmptyString('MortgageeLenderCompanyName');
			
		$validator
            ->scalar('MortgageeFirstName1')
            ->maxLength('MortgageeFirstName1', 50)
            ->allowEmptyString('MortgageeFirstName1');
			
		$validator
            ->scalar('MortgageeLastName1')
            ->maxLength('MortgageeLastName1', 50)
            ->allowEmptyString('MortgageeLastName1');
			
		$validator
            ->scalar('MortgageeFirstName2')
            ->maxLength('MortgageeFirstName2', 50)
            ->allowEmptyString('MortgageeFirstName2');

		$validator
            ->scalar('MortgageeLastName2')
            ->maxLength('MortgageeLastName2', 50)
            ->allowEmptyString('MortgageeLastName2');
			
		$validator
            ->scalar('MortgageeMaritalStatus')
            ->maxLength('MortgageeMaritalStatus', 50)
            ->allowEmptyString('MortgageeMaritalStatus');
					
			
        $validator
            ->scalar('StreetNumber')
            ->maxLength('StreetNumber', 50)
            ->allowEmptyString('StreetNumber');

        $validator
            ->scalar('StreetName')
            ->maxLength('StreetName', 255)
            ->allowEmptyString('StreetName');

        $validator
            ->scalar('City')
            ->maxLength('City', 50)
            ->allowEmptyString('City');

        $validator
            ->scalar('County')
            ->maxLength('County', 50)
            ->allowEmptyString('County');

        $validator
            ->scalar('TownshipDivision')
            ->maxLength('TownshipDivision', 250)
            ->allowEmptyString('TownshipDivision');

        $validator
            ->scalar('State')
            ->maxLength('State', 50)
            ->allowEmptyString('State');

        $validator
            ->scalar('APNParcelNumber')
            ->maxLength('APNParcelNumber', 50)
            ->requirePresence('APNParcelNumber', 'create')
            ->notEmptyString('APNParcelNumber');

		$validator
            ->scalar('LegalDescriptionShortLegal')
            ->notEmptyString('LegalDescriptionShortLegal');

        $validator
            ->scalar('Zip')
            ->maxLength('Zip', 20)
            ->allowEmptyString('Zip');

        $validator
            ->scalar('A')
            ->maxLength('A', 255)
            ->allowEmptyString('A');

        $validator
            ->scalar('B')
            ->maxLength('B', 255)
            ->allowEmptyString('B');

        $validator
            ->scalar('C')
            ->maxLength('C', 255)
            ->allowEmptyString('C');

        $validator
            ->scalar('D')
            ->maxLength('D', 255)
            ->allowEmptyString('D');

        $validator
            ->scalar('E')
            ->maxLength('E', 255)
            ->allowEmptyString('E');

        $validator
            ->scalar('F')
            ->maxLength('F', 255)
            ->allowEmptyString('F');

        $validator
            ->scalar('G')
            ->maxLength('G', 255)
            ->allowEmptyString('G');

        $validator
            ->scalar('H')
            ->maxLength('H', 255)
            ->allowEmptyString('H');

        $validator
            ->scalar('I')
            ->maxLength('I', 255)
            ->allowEmptyString('I');

        $validator
            ->scalar('J')
            ->maxLength('J', 255)
            ->allowEmptyString('J');

        $validator
            ->scalar('K')
            ->maxLength('K', 255)
            ->allowEmptyString('K');

        $validator
            ->scalar('L')
            ->maxLength('L', 255)
            ->allowEmptyString('L');

        $validator
            ->scalar('M')
            ->maxLength('M', 255)
            ->allowEmptyString('M');

        $validator
            ->scalar('N')
            ->maxLength('N', 255)
            ->allowEmptyString('N');

        $validator
            ->scalar('O')
            ->maxLength('O', 255)
            ->allowEmptyString('O');

        $validator
            ->scalar('P')
            ->maxLength('P', 255)
            ->allowEmptyString('P');

        $validator
            ->scalar('Q')
            ->maxLength('Q', 255)
            ->allowEmptyString('Q');

        $validator
            ->scalar('R')
            ->maxLength('R', 255)
            ->requirePresence('R', 'create')
            ->notEmptyString('R');

        $validator
            ->scalar('S')
            ->maxLength('S', 255)
            ->requirePresence('S', 'create')
            ->notEmptyString('S');

        $validator
            ->scalar('T')
            ->maxLength('T', 255)
            ->requirePresence('T', 'create')
            ->notEmptyString('T');

        $validator
            ->scalar('U')
            ->maxLength('U', 255)
            ->requirePresence('U', 'create')
            ->notEmptyString('U');

        $validator
            ->scalar('V')
            ->maxLength('V', 255)
            ->requirePresence('V', 'create')
            ->notEmptyString('V');

        $validator
            ->scalar('W')
            ->maxLength('W', 255)
            ->requirePresence('W', 'create')
            ->notEmptyString('W');

        $validator
            ->scalar('X')
            ->maxLength('X', 255)
            ->requirePresence('X', 'create')
            ->notEmptyString('X');

        $validator
            ->scalar('Y')
            ->maxLength('Y', 255)
            ->requirePresence('Y', 'create')
            ->notEmptyString('Y');

        $validator
            ->scalar('Z')
            ->maxLength('Z', 255)
            ->requirePresence('Z', 'create')
            ->notEmptyString('Z');

        $validator
            ->scalar('TransactionType')
            ->maxLength('TransactionType', 50)
            ->allowEmptyString('TransactionType');

        $validator
            ->scalar('DocumentImage')
            ->maxLength('DocumentImage', 100)
            ->requirePresence('DocumentImage', 'create')
            ->notEmptyString('DocumentImage');

        $validator
            ->dateTime('CheckInDateTime')
            ->allowEmptyDateTime('CheckInDateTime');

        $validator
            ->integer('UserId')
            ->requirePresence('UserId', 'create')
            ->notEmptyString('UserId');

        $validator
            ->scalar('FileEndDate')
            ->maxLength('FileEndDate', 20)
            ->requirePresence('FileEndDate', 'create')
            ->notEmptyString('FileEndDate');

        $validator
            ->scalar('DocumentReceived')
            ->maxLength('DocumentReceived', 1)
            ->requirePresence('DocumentReceived', 'create')
            ->notEmptyString('DocumentReceived');

        $validator
            ->integer('FCMId')
            ->requirePresence('FCMId', 'create')
            ->notEmptyString('FCMId');

        $validator
            ->scalar('FedexManual')
            ->maxLength('FedexManual', 1)
            ->requirePresence('FedexManual', 'create')
            ->notEmptyString('FedexManual');

        $validator
            ->scalar('DateAdded')
            ->maxLength('DateAdded', 20)
            ->requirePresence('DateAdded', 'create')
            ->notEmptyString('DateAdded');

        $validator
            ->scalar('InternalNotes')
            ->requirePresence('InternalNotes', 'create')
            ->notEmptyString('InternalNotes');

        $validator
            ->scalar('PublicNotes')
            ->requirePresence('PublicNotes', 'create')
            ->notEmptyString('PublicNotes');

        $validator
            ->scalar('ECapable')
            ->maxLength('ECapable', 1)
            ->allowEmptyString('ECapable');

        $validator
            ->scalar('reseach_status')
            ->maxLength('reseach_status', 1)
            ->notEmptyString('reseach_status'); */

        return $validator;
    }


    // pop last fields key
	public function getTableFileds(){

        $schema = $this->getSchema();
        $columnArray = $schema->columns();
         
		$columnArray = array_slice($columnArray, 1,-5); // remove first and last 5 element(colomns)
		return $columnArray;
	}

    // push extra fields key
    public function getTableAllFileds(){
        $schema = $this->getSchema();
        $columnArray = $schema->columns();
        $fields = [];
        foreach($columnArray as $value)
            $fields[] = $this->getAlias().".".$value;
        
        array_push($fields,'pn.Public_Internal');
        array_push($fields,'pn.Regarding');
        array_push($fields,'fva.TransactionType');	
        //array_push($fields,'fcd.DocumentReceived');  
        
        return $fields;
    }

    // push extra fields key
    public function getTableAllFiledsExamReceipt(){
        $schema = $this->getSchema();
        $columnArray = $schema->columns();
        $fields = [];
        foreach($columnArray as $value)
            $fields[] = $this->getAlias().".".$value;
        
        array_push($fields,'pn.Public_Internal');
        array_push($fields,'pn.Regarding');
        array_push($fields,'fmd.TransactionType');  
        array_push($fields,'fmd.DocumentReceived');  
        
        return $fields;
    }

    // push extra fields key
    public function getTableAllFiledsRecordingData(){
        $schema = $this->getSchema();
        $columnArray = $schema->columns();
        $fields = [];
        foreach($columnArray as $value)
            $fields[] = $this->getAlias().".".$value;
        
        array_push($fields,'pn.Public_Internal');
        array_push($fields,'pn.Regarding');
        array_push($fields,'fmd.TransactionType');  
        array_push($fields,'fmd.DocumentReceived');  
        
        return $fields;
    }

    // get all fields key
    private function getAllFmdFields($alies='fmd'){
        $this->setAlias($alies);
        $schema = $this->getSchema();
        $columnArray = $schema->columns();
        $fields = [];
        foreach($columnArray as $value)
            $fields[] = $alies.".".$value;
        
        return $fields;
    }

    public function fetchLRSfileno($PartnerFileNumber, $TransactionType){
        $this->setAlias('fmd');
     
	  
	  
		$query = $this->find('all')
                ->join([
                    'table' => 'files_vendor_assignment',
                    'alias' => 'fva',
                    'type' => 'INNER',
                    'conditions' => ['fva.RecId = fmd.Id'] 
                ])
		    ->select(['fmd.Id','fmd.NATFileNumber','fva.TransactionType'])
            ->where(['fmd.PartnerFileNumber'=>$PartnerFileNumber, 'fva.TransactionType IN '=>$TransactionType]);
       
            $results = $query->order(['fmd.Id'=>'desc'])->disableHydration()->all()->toArray();
    // echo '<pre>';
	 //print_r($results); exit;
	 
        if(!empty($results) && isset($results[0]['NATFileNumber'])){
			return $results[0];
		}
		
		return 0;
	}
    
    public function getFMDid($PartnerFileNumber,$companyId='')
    {
        $results= [];
        $this->setAlias('FilesMainData');
		$query = $this->find()
                    ->join([
                        'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
                        'alias' => 'fva',
                        'type' => 'INNER',
                        'conditions' => ['fva.RecId = FilesMainData.Id'] 
                    ])
					->where(['FilesMainData.PartnerFileNumber'=>addslashes($PartnerFileNumber),'FilesMainData.company_id'=>$companyId]) //
					->select(['FilesMainData.Id','FilesMainData.NATFileNumber'])->disableHydration();

		$results = $query->order(['FilesMainData.Id'=>'desc'])->all()->toArray();
		
		if(!empty($results)) $results=$results[0];
		return $results;
			
    }

    public function getExistingLRS($PartnerFileNumber, $TransactionType, $company_id){  
      $this->FilesQcData = TableRegistry::get('FilesQcData');
      $data = "";
 
        // for only single doctype
        //if(@strpos('$TransactionType', ',') === false){
        if(is_int($TransactionType)){
            $data = $this->FilesQcData->checkQCreject($PartnerFileNumber, $TransactionType, $company_id);
        } 
        $return = [];
 
        if(!empty($data)){
        // update qc if record already rejected and overwrite.
            if(!in_array($data[0]['Status'], ['', 'OK'])){ // for old data //$data[0]['Status'] == 'RTP' || $data[0]['Status'] == 'RIH'
                $this->FilesQcData->updateQCData($data[0]['Id'], ['Status'=>'OK', 'QCProcessingDate'=>date('Y-m-d'), 'QCProcessingTime'=>date('H:i:s')]);
                //update existing record ( with checkingDATA date time, change Y)  
                $checkInData =  [ 
                    'DocumentReceived' => '',
                    'CheckInProcessingDate' => date("Y-m-d"),
                    'CheckInProcessingTime' => date("H:i:s")
                ];
                $this->FilesCheckinData = TableRegistry::get('FilesCheckinData');
                $this->FilesCheckinData->updateFCDByFmdDoc($data[0]['fmd']['Id'], $TransactionType, $checkInData);
                 
		// expected one record
		
               $return = ['fmdId'=>$data[0]['fmd']['Id']]; // UPDATE
            }else{ 
                $return = ['LRSFile'=>$data[0]['fmd']['NATFileNumber']]; // INSERT
            } 
           
        }else{
            //not in QC but this record in checking or other section 
            //then need to follow existing Logic 
            // *add new entry with same LRS number with current data*
            $lrsFile = $this->fetchLRSfileno($PartnerFileNumber, $TransactionType); 
			
			
            $return = ['LRSFile'=>$lrsFile]; // INSERT
        }

        return $return;
    }

    public function sqlDataInsert($mapCSVFieldsTitle,$rowData,$currentUserId,$filesCsvLastId,$cmFileEnabled,$companyid=null,$NATFileNumber=null){
		$sqlmainInt=[];
		 
		$sizeTitle = sizeof($mapCSVFieldsTitle);
		
   
		for($i=0; $i<$sizeTitle;$i++){
			if( $mapCSVFieldsTitle[$i]=='FileStartDate' || $mapCSVFieldsTitle[$i]=='CheckInDateTime'){
				$rowData[$i] = date("Y-m-d H:i:s",strtotime($rowData[$i]));
			}
			$sqlmainInt[$mapCSVFieldsTitle[$i]] = addslashes($rowData[$i]);
		}
		//echo '<pre>';
		//print_r($sqlmainInt); exit
		//$filesCsvLastId  // new change : email February 20, 2023 7:04 AM  
        if(isset($sqlmainInt['TransactionType'])) {
            $docType = $sqlmainInt['TransactionType'];
        } else {
            $docType =  $sqlmainInt['TransactionType'] = DOCTYPE;
        }

        $existingLRS = $this->getExistingLRS($sqlmainInt['PartnerFileNumber'], $docType, $companyid);
       //print_r($existingLRS); exit;
        $sqlmainInt['LRS_extension'] = 0; 
        if(!empty($existingLRS['LRSFile'])){  
            $sqlmainInt['NATFileNumber'] = $existingLRS['LRSFile']['NATFileNumber']; 
			$sqlmainInt['InserId'] = $existingLRS['LRSFile']['Id'];
            $sqlmainInt['LRS_extension'] = 1; 
             
        }elseif(!empty($existingLRS['Id'])){  // update fmdId
            $sqlmainInt['InserId'] = $existingLRS['LRSFile']['Id']; 
        }else{  
            $subselect = $this->find()->select(['maxLrs'=>'(COALESCE(MAX(NATFileNumber), 300000)+1)']);
            $sqlmainInt['NATFileNumber'] = $subselect;
        }

		if($companyid != null)
		$sqlmainInt['company_id']=$companyid;
	
		$sqlmainInt['UserId']=$currentUserId;
		$sqlmainInt['FCMId']=$filesCsvLastId;
		$sqlmainInt['DateAdded'] = date("Y-m-d H:i:s");
		$sqlmainInt['ECapable']=$cmFileEnabled; //$CountyTitle[cm_file_enabled]
		
		return $sqlmainInt;
		
	}

    // insert FMD data from checking upload csv 
	public function insertFMDData($sqlmainInt=[]){
     
		//for reject record  "if need to FMD update ?"
        if(isset($sqlmainInt['InserId'])){
         
            $fmdid = $sqlmainInt['InserId'];
            unset($sqlmainInt['InserId']);
            unset($sqlmainInt['NATFileNumber']);
            $LRS_extension = $sqlmainInt['LRS_extension'];
            unset($sqlmainInt['LRS_extension']); 
            
             $query = $this->query()
                    ->update()
                    ->set($sqlmainInt)
                    ->where(['Id' => $fmdid])
                    ->execute();
            if($query){
                return ['success'=>true, 'LRS_extension'=>$LRS_extension,'LRS_PartnerFileNumber'=>$sqlmainInt['PartnerFileNumber'], 'fmdId'=>$fmdid];  
            }  
        }else{
            $LRS_extension = $sqlmainInt['LRS_extension'];
            unset($sqlmainInt['LRS_extension']); 
            unset($sqlmainInt['InserId']);
            // insert new data to FMD table 
            
              $query = $this->query()
                    ->insert(array_keys($sqlmainInt))
                    ->values($sqlmainInt)
                    ->execute();
            $insertID =  $query->lastInsertId($this->getTable()); 
            if($query){
                return ['success'=>true, 'LRS_extension'=>$LRS_extension,'LRS_PartnerFileNumber'=>$sqlmainInt['PartnerFileNumber'], 'fmdId'=>$insertID];
            }   
        }
	}
 
	public function getInsertedMainData($ids){ // array
		$results= [];
        $this->setAlias('FilesMainData');
		$query = $this->find()
					->where(['FilesMainData.Id IN '=>$ids]) 
					->join([
						'table' => 'company_mst',
						'alias' => 'comp_mst',
						'type' => 'LEFT',
						'conditions' => ['comp_mst.cm_id = FilesMainData.company_id']
					])
					->select(['FilesMainData.NATFileNumber','comp_mst.cm_comp_name','FilesMainData.company_id','FilesMainData.PartnerFileNumber','FilesMainData.Grantors','FilesMainData.StreetNumber','FilesMainData.StreetName','FilesMainData.Grantees','FilesMainData.State','FilesMainData.County','FilesMainData.TransactionType']);
		$results = $query->disableHydration()->all()->toArray();

		//if(!empty($results)) $results=$results[0];
		return $results;
		
	}
     
    public function getFieldsByfileId($fmdId, $search=[]){
		$query = $this->find()
				->where(['Id'=>$fmdId])
				->select($search)->disableHydration()
				->limit(1);

		$results = $query->all()->toArray();
		if(!empty($results)){
			$results =  $results[0];
		}
		return $results;
	}

	public function updateFMDByFmdId($fmdId, array $data)
	{
		// expected one record
		$result  = $this->updateAll($data, ['Id'=>$fmdId]);
		
		if($result)
			return true;
		else
			return false;
		
	}
 
	public function distinctCompanyByfilesId($fmdIds){
		//$companyIds = [];
		$query = $this->find('all')
				->where(['Id IN'=>$fmdIds])
				->select(['company_id'])
				->distinct();
		$results = $query->count();
		
		if($results == 1){
			$results = $query->toArray();
			return $results[0]['company_id'];
		}else{
			return false;
		}
		
	}
 
	public function getFileMainTownShipData($FmdIds=[]){
		$results= [];
		if(!empty($FmdIds)){
			$this->setAlias('fmd');
			$query = $this->find()
						->where(['fmd.Id IN '=>$FmdIds, 'fva.DocumentReceived'=>''])
						->join([
							'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
							'alias' => 'fva',
							'type' => 'LEFT',
							'conditions' => 'fva.RecId = fmd.Id'
						])
						->join([
							'table' => 'document_type_mst',
							'alias' => 'dtm',
							'type' => 'LEFT OUTER',
							'conditions' => ['dtm.Id = fva.TransactionType']
						])
						->join([
								'table' => 'company_mst',
								'alias' => 'comp_mst',
								'type' => 'LEFT OUTER',
								'conditions' => ['comp_mst.cm_id = fmd.company_id']
						]) 
						->select(['fmd.Id', 'fmd.NATFileNumber', 'comp_mst.cm_comp_name', 'dtm.Title', 'fmd.company_id', 'fmd.PartnerFileNumber', 'fmd.Grantors', 'fmd.StreetName','fmd.State', 'fmd.County', 'fmd.ECapable', 'fva.TransactionType', 'fva.lock_status'])
						->order(['fmd.PartnerFileNumber'=>'desc']);

			$results = $query->disableHydration()->all()->toArray();
		}
		return $results;
		
	}



    // $fmdIdDoctype value change from differant call 
	// 1) component 2) Recording controller
	
	public function recordingKNIcheckDataQuery(array $fmdIdDoctype, $count=false){
		
		$this->setAlias('fmd');
		$this->setprifix = 'frd';
		
		// FMD fields
		$fmdFld = $this->getAllFmdFields();
		
		if($count){
			$selectFld = ["frd.Id"]; 
		}else{
			$selectFld = [			
					"frd.Id",
					"frd.RecId",
					"frd.TransactionType",
					"frd.RecordingProcessingDate",
					"frd.InstrumentNumber",
					"frd.Book",
					"frd.Page",
					"frd.RecordingDate",
					"frd.RecordingTime",
					"frd.DocumentNumber",
					"frd.EffectiveDate",
					"frd.hard_copy_received",

					"cpm.cm_comp_name",
					"dtm.Title",

					"fva.search_status",
					"fva.barcode_generated"
				];

			$selectFld = array_merge($fmdFld, $selectFld);
		}
		
		$query = $this->find()
					->select($selectFld)
					->join([
						'table' => 'files_recording_data'.ARCHIVE_PREFIX,
						'alias' => 'frd',
						'type' => 'LEFT OUTER',
						'conditions' => ['frd.RecId = fmd.Id']
					])
					->join([
						'table' => 'document_type_mst',
						'alias' => 'dtm',
						'type' => 'LEFT',
						'conditions' => ['dtm.Id = frd.TransactionType']
					])
					->join([
						'table' => 'company_mst',
						'alias' => 'cpm',
						'type' => 'LEFT OUTER',
						'conditions' => ['cpm.cm_id = fmd.company_id']
					])
					->join([
						'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
						'alias' => 'fva',
						'type' => 'LEFT OUTER',
						'conditions' => ['fva.RecId = frd.RecId','fva.TransactionType = frd.TransactionType']
					]);
			
			// call from recording coversheet $count == true
			if(isset($fmdIdDoctype['companyId'])){

				$query = $query->where(['frd.KNI != '=>1, 'frd.File !='=>'', 'frd.hard_copy_received' => 'Y', 'fmd.company_id'=>$fmdIdDoctype['companyId']]);

				if(isset($fmdIdDoctype['fromDate']) && isset($fmdIdDoctype['toDate'])){
					$query = $this->dateBetween($query, $fmdIdDoctype['fromDate'], $fmdIdDoctype['toDate'], 'frd.RecordingProcessingDate');
				}
				
				// enhancement for new confirmation coversheet 
					if(isset($fmdIdDoctype['eCapable']) && !empty($fmdIdDoctype['eCapable'])){
						//if($fmdIdDoctype['eCapable'] != 'N'){
							if($fmdIdDoctype['eCapable'] == 'Y') $ecapable = ['fmd.ECapable'=>'Y'];
							if($fmdIdDoctype['eCapable'] == 'N') $ecapable = ['fmd.ECapable !='=>'Y'];
							$query = $query->where($ecapable);
						//}
					}

					if(isset($fmdIdDoctype['addedfromDate']) && isset($fmdIdDoctype['addedtoDate'])){
						$query = $this->dateBetween($query, $fmdIdDoctype['addedfromDate'], $fmdIdDoctype['addedtoDate'], 'frd.RecordingDate');
					}
				/*********************************************************************/
				
				// Manual confirmation coversheet 
				if(isset($fmdIdDoctype['field']) && isset($fmdIdDoctype['filenumber'])){
					$field = $fmdIdDoctype['field'];
					$filenumber = explode(",",$fmdIdDoctype['filenumber']);
					$sqlWhere = [" fmd.".$field." in" => $filenumber]; // ('".implode("','",$filenumber)."')"
					
					$query = $query->where($sqlWhere);
					
				}
				//END
				
			}
			
			// call from initial coversheet
			if(isset($fmdIdDoctype['fmdId']) && isset($fmdIdDoctype['docId'])){
				$query = $query->where(['frd.RecId IN '=>$fmdIdDoctype['fmdId'], 'frd.TransactionType IN ' =>$fmdIdDoctype['docId'], 'frd.KNI != '=>1, 'frd.File !='=>'']);
			}
			
			$query = $query->group(['frd.RecId', 'frd.TransactionType']);
			
		return $query;
	}
	
 
	public function fileMainDataPublic($recordMainId, $doctype){
		$this->setAlias('FilesMainData');
		
		$fmdFld = $this->getAllFmdFields('FilesMainData');
		$selectFld = ['DocumentTypeMst.Title', 'CompanyMst.cm_comp_name'];
		
		$selectFld = array_merge($fmdFld, $selectFld);

		$query = $this->find()
					->select($selectFld)
					->join([
							'table' => 'document_type_mst',
							'alias' => 'DocumentTypeMst',
							'type' => 'LEFT OUTER',
							'conditions' => ['DocumentTypeMst.Id'=>$doctype]
						])
					->join([
							'table' => 'company_mst',
							'alias' => 'CompanyMst',
							'type' => 'LEFT OUTER',
							'conditions' => ['CompanyMst.cm_id = FilesMainData.company_id']
						])
					->where(['FilesMainData.Id'=>$recordMainId])
					->limit(1);

		$result =  $query->toArray();
		if(!empty($result)){
			$result =  $result[0];
		}
		return $result;
	}


    public function shipCountyQuery($whereCondition, array $pdata){
		 
		$this->setAlias('fmd');
		//$this->setprifix = 'fad';
		$query = $this->find('search', $pdata)
                ->join([
                    'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
                    'alias' => 'fva',
                    'type' => 'INNER',
                    'conditions' => ['fva.RecId = fmd.Id'] 
                ])
                ->join([
                    'table' => 'files_shiptoCounty_data'.ARCHIVE_PREFIX,
                    'alias' => 'fsad',
                    'type' => 'LEFT OUTER',
                    'conditions' => ['fva.RecId = fsad.RecId','fva.TransactionType = fsad.TransactionType']
                ])
				->join([
					'table' => 'document_type_mst',
					'alias' => 'dtm',
					'type' => 'LEFT OUTER',
					'conditions' => ['dtm.Id = fva.TransactionType']
				])
				->join([
						'table' => 'company_mst',
						'alias' => 'cpm',
						'type' => 'LEFT OUTER',
						'conditions' => ['cpm.cm_id = fmd.company_id']
				]);
            
            if(!empty($pdata['search']['AccountingStartDate']) || !empty($pdata['search']['AccountingEndDate'])) {
                $query = $query->join([
                    'table' => 'files_accounting_data'.ARCHIVE_PREFIX,
                    'alias' => 'fad',
                    'type' => 'LEFT OUTER',
                    'conditions' => ['fad.RecId = fva.RecId']
                ]);
            }   
            if(!empty($pdata['search']['QCStartDate']) || !empty($pdata['search']['QCEndDate'])) {
                $query = $query->join([
                    'table' => 'files_qc_data'.ARCHIVE_PREFIX,
                    'alias' => 'fqcd',
                    'type' => 'LEFT OUTER',
                    'conditions' => ['fqcd.RecId = fva.RecId','fqcd.TransactionType = fva.TransactionType']
                ]);
            }
            

		$query= $query->where($whereCondition);
			
		return $query;
	}
	
	public function getMaxLRSfileno(){
		$query = $this->find('all');
		//$results =  $query->select('NATFileNumber')->hydrate(false)->max('NATFileNumber');
		$results =  $query->select(['NATFileNumber'=> $query->func()->max('NATFileNumber')])->disableHydration()->all()->toArray();
		
		$maxNATFileNumber='';
		if(isset($results[0])){
			$maxNATFileNumber = $results[0];
		}
		
		return $maxNATFileNumber;
	}
 
	public function updateFileMainData(array $updateData,$id)
	{

		$updateData['TransactionType'] = $updateData['TransactionType'];
		$updateData['FileStartDate'] =  date("Y-m-d H:i:s",strtotime($updateData['FileStartDate']));
		
		unset($updateData['Public_Internal']);
		unset($updateData['Regarding']);
		unset($updateData['DocumentReceived']);
		unset($updateData['TransactionType']);
		unset($updateData['documentTypeHidden']);
		unset($updateData['fmd_id']);
		
		if(isset($updateData['saveBtn'])) unset($updateData['saveBtn']);
		if(isset($updateData['saveOpenBtn'])) unset($updateData['saveOpenBtn']);
		
		$this->updateAll($updateData, ['Id' =>$id]);
		return true;
	}
	
	public function getFileMainData($id=null){
		$results= [];
		
		$this->setprifix = 'fva';
		 
			$query = $this->find()
			->where(['fva.Id'=>$id])
			  ->join([
				'table' => 'files_vendor_assignment',
				'alias' => 'fva',
				'type' => 'LEFT OUTER ',
				'conditions' => ['fva.RecId = fmd.Id']  // need to change
			])  
			  ->join([
				'table' => 'public_notes_fva',
				'alias' => 'pn',
				'type' => 'LEFT OUTER',
				'conditions' => ['pn.RecId = fmd.Id']
			])   
			->select($this->getTableAllFileds())
			->limit(1);
 
		$results = $query->all()->toArray();
	//print_r($results);
	//exit;
		if(!empty($results)) $results=$results[0];
		return $results;
	}
    
    public function getFileExamMainData($id=null){
        $results= [];
        
        $this->setprifix = 'fmd';
         
            $query = $this->find()
            ->where(['fmd.id'=>$id])
              ->join([
                'table' => 'files_exam_receipt',
                'alias' => 'fer',
                'type' => 'LEFT OUTER ',
                'conditions' => ['fer.RecId = fmd.Id']  // need to change
            ])  
              ->join([
                'table' => 'public_notes_fva',
                'alias' => 'pn',
                'type' => 'LEFT OUTER',
                'conditions' => ['pn.RecId = fmd.Id']
            ])   
            ->select($this->getTableAllFiledsExamReceipt())
            ->limit(1);
 
        $results = $query->all()->toArray();
  
        if(!empty($results)) $results=$results[0];
        return $results;
    }
    
    public function getFileRecordingMainData($id=null){
        $results= [];
        
        $this->setprifix = 'fmd';
         
            $query = $this->find()
            ->where(['fmd.id'=>$id])
              ->join([
                'table' => 'files_recording_data',
                'alias' => 'frd',
                'type' => 'LEFT OUTER ',
                'conditions' => ['frd.RecId = fmd.Id']  // need to change
            ])  
              ->join([
                'table' => 'public_notes_fva',
                'alias' => 'pn',
                'type' => 'LEFT OUTER',
                'conditions' => ['pn.RecId = fmd.Id']
            ])   
            ->select($this->getTableAllFiledsRecordingData())
            ->limit(1);
 
        $results = $query->all()->toArray();
  
        if(!empty($results)) $results=$results[0];
        return $results;
    }


    public function getMainDataAll($recordMainId) {
        
        $search =[  
                    "fmd.Id",
                    "fmd.NATFileNumber",
                    "fmd.PartnerFileNumber",
                    "fmd.FileStartDate",
                    "fmd.LoanAmount",
                    "fmd.loanNumber",
                    "fmd.APNParcelNumber",

                    "fmd.Grantors",
                    "fmd.GrantorFirstName1",
                    "fmd.GrantorLastName1",
                    "fmd.GrantorFirstName2",
                    "fmd.GrantorLastName2",
                    "fmd.GrantorMaritalStatus",
                    "fmd.GrantorCorporationName",

                    "fmd.Grantees",
                    "fmd.GranteeFirstName1",
                    "fmd.GranteeLastName1",
                    "fmd.GranteeFirstName2",
                    "fmd.GranteeLastName2",
                    "fmd.GranteeMaritalStatus",
                    "fmd.GranteeCorporationName",

                    "fmd.MortgagorGrantors",
                    "fmd.MortgagorGrantorFirstName1",
                    "fmd.MortgagorGrantorLastName1",
                    "fmd.MortgagorGrantorFirstName2",
                    "fmd.MortgagorGrantorLastName2", 
                    "fmd.MortgagorGrantorMaritalStatus",
                    "fmd.MortgagorGrantorCorporationName", 
                                      
                    "fmd.MortgageeLenderCompanyName",
                    "fmd.MortgageeFirstName1",
                    "fmd.MortgageeLastName1",
                    "fmd.MortgageeFirstName2",
                    "fmd.MortgageeLastName2", 
                    "fmd.MortgageeMaritalStatus",                   
                    "fmd.StreetNumber",
                    "fmd.StreetName",
                    "fmd.City",
                    "fmd.County",
                    "fmd.State",
                    "fmd.Zip",
                    "fmd.company_id",
                    "fmd.PurchasePriceConsideration",
                    "fmd.LegalDescriptionShortLegal",
                    "fmd.CenterBranch",
                    "comp_mst.cm_comp_name",

                    "document_type.title",

                    "frd.Id",
                    "frd.RecordingProcessingDate",
                    "frd.RecordingDate",
                    "frd.RecordingTime",
                    "frd.InstrumentNumber",
                    "frd.Book",
                    "frd.Page",

                    "returned_to_partner.CarrierTrackingNo",
                    "returned_to_partner.dateDelivered",
                    "returned_to_partner.receipient",
                    "returned_to_partner.deliveredTo",
                    "returned_to_partner.receivedBy",

                    "fer.id",
                    "fer.OfficialPropertyAddress",
                    "fer.vesting_attributes",
                    "fer.open_mortgage_attributes",
                    "fer.open_judgments_attributes",
                    "fer.LegalDescription",
                    "fer.created",
                    "fer.modified",

                    "faa.Id"


                ];

        $query = $this->find()->where(['fmd.Id'=>$recordMainId])
                        ->join([
                                'table' => 'company_mst',
                                'alias' => 'comp_mst',
                                'type' => 'LEFT OUTER',
                                'conditions' => ['comp_mst.cm_id = fmd.company_id']
                            ])
                        ->join([
                                'table' => 'document_type_mst',
                                'alias' => 'document_type',
                                'type' => 'LEFT',
                                'conditions' => ['document_type.Id = fmd.TransactionType']
                            ])
                        ->join([
                                'table' => 'files_recording_data',
                                'alias' => 'frd',
                                'type' => 'LEFT',
                                'conditions' => ['frd.RecId = fmd.Id']
                            ])
                        ->join([
                                'table' => 'files_exam_receipt',
                                'alias' => 'fer',
                                'type' => 'LEFT',
                                'conditions' => ['fer.RecId = fmd.Id']
                            ])
                        ->join([
                                'table' => 'files_attorney_assignment',
                                'alias' => 'faa',
                                'type' => 'LEFT',
                                'conditions' => ['faa.RecId = fmd.Id']
                            ])
                        ->join([
                                'table' => 'files_returned2partner',
                                'alias' => 'returned_to_partner',
                                'type' => 'LEFT',
                                'conditions' => ['returned_to_partner.RecId = fmd.Id']
                            ])
                        ->select($search)->limit(1);
        $results = $query->toArray();
        return (!empty($results)) ? $results[0] : []; 
    }


    public function searchMainDataForAll($recordMainId, $is_all=false){
        if($is_all){
            // FMD fields
            $fmdFld = $this->getAllFmdFields('FilesMainData');
            $search = array_merge($fmdFld ,["comp_mst.cm_comp_name"]);
            
        }else{
        
            $search =[  
                    "fmd.Id",
                    "fmd.NATFileNumber",
					"fmd.LegalDescriptionShortLegal",
                    "fmd.PartnerFileNumber",
                    "fmd.LoanAmount",
                    "fmd.APNParcelNumber",
                    "fmd.Grantors",
                    "fmd.CenterBranch",
                    "fmd.GrantorFirstName1",
                    "fmd.GrantorLastName1",
					"fmd.GrantorFirstName2",
					"fmd.GrantorLastName2",
                    "fmd.Grantees",
                    "fmd.GranteeFirstName1",
                    "fmd.GranteeLastName1",
					"fmd.GranteeFirstName2",
                    "fmd.GranteeLastName2",
					"fmd.MortgagorGrantors",
                    "fmd.MortgagorGrantorFirstName1",
                    "fmd.MortgagorGrantorLastName1",
					"fmd.MortgagorGrantorFirstName2",
                    "fmd.MortgagorGrantorLastName2",					
					"fmd.MortgageeLenderCompanyName",
                    "fmd.MortgageeFirstName1",
                    "fmd.MortgageeLastName1",
					"fmd.MortgageeFirstName2",
                    "fmd.MortgageeLastName2",					
                    "fmd.StreetNumber",
                    "fmd.StreetName",
                    "fmd.City",
                    "fmd.County",
                    "fmd.State",
                    "fmd.Zip",
                    "fmd.company_id",
                    "comp_mst.cm_comp_name"
                ];
        }
            
        $query = $this->find()->where(['fmd.Id'=>$recordMainId])
                        ->join([
                                'table' => 'company_mst',
                                'alias' => 'comp_mst',
                                'type' => 'LEFT OUTER',
                                'conditions' => ['comp_mst.cm_id = fmd.company_id']
                            ])
                        ->select($search)->limit(1);
        $results = $query->toArray();
        return (!empty($results)) ? $results[0] : []; 
    }

	
	public function masterSearchQuery($whereCondition, array $pdata){
		
		$this->setAlias('fmd');
		$this->setprifix = 'frd';
		$query = $this->find('search', $pdata)
						->join([
							'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
							'alias' => 'fva',
							'type' => 'INNER',
							'conditions' => ['fva.RecId = fmd.Id']
						])
						->join([
							'table' => 'document_type_mst',
							'alias' => 'dtm',
							'type' => 'LEFT',
							'conditions' => ['dtm.Id = fva.TransactionType'] // ????
						])
						->join([
							'table' => 'company_mst',
							'alias' => 'cpm',
							'type' => 'LEFT OUTER',
							'conditions' => ['cpm.cm_id = fmd.company_id']
						])->join([
							'table' => 'files_recording_data'.ARCHIVE_PREFIX,
							'alias' => 'frd',
							'type' => 'LEFT OUTER',
							'conditions' => ['frd.RecId = fva.RecId','frd.TransactionType = fva.TransactionType']
						]);

		 $query= $query->where($whereCondition);

		return $query;
	}
	 
    public function accountingQuery($whereCondition, array $pdata, $callfrom=null){
	
		$this->setAlias('fmd');
		 
        $this->setprifix = 'fva';
        if($callfrom != 'sheetGenerate') {
            unset($pdata['fields']['CountyCode']);
        }
        
        $query = $this->find('search', $pdata)
                    ->join([
                        'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
                        'alias' => $this->setprifix,
                        'type' => 'INNER',
                        'conditions' => ['fmd.Id = '.$this->setprifix.'.RecId']
                    ]); 
		$query = $query
				->join([
					'table' => 'files_accounting_data'.ARCHIVE_PREFIX,
					'alias' => 'fad',
					'type' => 'LEFT',
					'conditions' => [$this->setprifix.'.RecId = fad.RecId', $this->setprifix.'.TransactionType = fad.TransactionType']
                ]);
        if($callfrom == 'sheetGenerate') {
            $query = $query
                    ->join([
                        'table' => 'County_mst',
                        'alias' => 'cnt',
                        'type' => 'LEFT',
                        'conditions' => ['fmd.County = cnt.cm_title', 'fmd.State = cnt.cm_State']
                    ]);
        }
        $query = $query        
                ->join([
					'table' => 'company_mst',
					'alias' => 'cpm',
					'type' => 'LEFT',
					'conditions' => ['fmd.company_id = cpm.cm_id']
				])
                ->join([
					'table' => 'document_type_mst',
					'alias' => 'dtm',
					'type' => 'LEFT',
					'conditions' => [$this->setprifix.'.TransactionType = dtm.Id']
				])
				->where($whereCondition);
	
		return $query;
	}

    public function qcMasterQuery($whereCondition, array $pdata, $add_checkin=true){
		
		$this->setAlias('fmd');
		$this->setprifix = 'fva';
		$query = $this->find('search', $pdata)
					->join([
						'table' => 'files_qc_data'.ARCHIVE_PREFIX,
						'alias' => 'fqcd',
						'type' => 'INNER',
						'conditions' => ['fqcd.RecId = fmd.Id']
					])->join([
						'table' => 'document_type_mst',
						'alias' => 'dtm',
						'type' => 'LEFT',
						'conditions' => ['dtm.Id = fqcd.TransactionType']
					])
					->join([
						'table' => 'company_mst',
						'alias' => 'cpm',
						'type' => 'LEFT OUTER',
						'conditions' => ['cpm.cm_id = fmd.company_id']
					])->where($whereCondition);
					 
					//if($add_checkin){
						$query = $query->join([
							'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
							'alias' => 'fva',
							'type' => 'LEFT',
							'conditions' => ['fva.RecId = fqcd.RecId','fva.TransactionType = fqcd.TransactionType']
						]);
					//}

		return $query;
	} 
    
    // new fucntion call for export data for export setting page
    public function dataExportNew(array $columnFields, array $condition){
        $limit = 200;
        //$this->setAlias('fmd');
        $query = $this->find()->join([
            'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
            'alias' => 'fva',
            'type' => 'INNER',
            'conditions' => ['fva.RecId = fmd.Id']
        ])
        ->join([
            'table' => 'document_type_mst',
            'alias' => 'dtm',
            'type' => 'LEFT',
            'conditions' => ['dtm.Id = fva.TransactionType'] // ????
        ])
        ->join([
            'table' => 'company_mst',
            'alias' => 'cpm',
            'type' => 'LEFT OUTER',
            'conditions' => ['cpm.cm_id = fmd.company_id']
        ])->select(array_merge(['dtm.Title', 'cpm.cm_comp_name'], $columnFields))->where($condition); 
        

        $tableFldCount = $this->tblFldCountExport($columnFields); 
        $query = $this->getOtherTableJoin($query, $tableFldCount,null, null, null, ['files_vendor_assignment'.ARCHIVE_PREFIX]); 
            //->limit($limit)
            //echo $query;
           //debug($query); exit;
        $data = $query->disableHydration()->all()->toArray();
 
        return $data;
    }


    public function filesRecordingQuery($whereCondition, array $pdata, $callpage=NULL){
		
		$this->setAlias('fmd');
		$this->setprifix = 'frd';
		
		$CountyCondition = ['fmd.County = cm.cm_title', 'fmd.State = cm.cm_State'];
		  
		$query = $this->find('search', $pdata)
                    ->join([
                        'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
                        'alias' => 'fva',
                        'type' => 'INNER',
                        'conditions' => ['fva.RecId = fmd.Id']
                    ])
                    ->join([
						'table' => 'files_recording_data'.ARCHIVE_PREFIX,
						'alias' => 'frd',
						'type' => 'LEFT OUTER',
						'conditions' => ['fva.RecId = frd.RecId','fva.TransactionType = frd.TransactionType']
					])
                    ->join([
						'table' => 'County_mst',
						'alias' => 'cm',
						'type' => 'LEFT OUTER',
						'conditions' => $CountyCondition
					])
                    ->join([
						'table' => 'company_mst',
						'alias' => 'cpm',
						'type' => 'LEFT OUTER',
						'conditions' => ['fmd.company_id = cpm.cm_id']
					])
                    ->join([
						'table' => 'document_type_mst',
						'alias' => 'dtm',
						'type' => 'LEFT OUTER',
						'conditions' => ['fva.TransactionType = dtm.Id']
					])
                    ->join([
						'table' => 'files_shiptoCounty_data'.ARCHIVE_PREFIX,
						'alias' => 'fsad',
						'type' => 'LEFT OUTER',
						'conditions' => ['fva.RecId = fsad.RecId','fva.TransactionType = fsad.TransactionType']
					]);
 
        $query = $query->group(['IF(frd.RecId IS NULL,fva.TransactionType,frd.TransactionType)', 'IF(frd.RecId IS NULL,fva.RecId,frd.RecId)']);

		$query= $query->where($whereCondition);

		return $query;
	}


    public function filesRecordingQueryNew($whereCondition, array $pdata, $callpage=NULL){
		
		$this->setAlias('fmd');
		$this->setprifix = 'frd';
		
		$CountyCondition = ['fmd.County = cm.cm_title', 'fmd.State = cm.cm_State'];
		  
		$query = $this->find('search', $pdata)
                    ->join([
                        'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
                        'alias' => 'fva',
                        'type' => 'INNER',
                        'conditions' => ['fva.RecId = fmd.Id']
                    ])
                    ->join([
						'table' => 'files_recording_data'.ARCHIVE_PREFIX,
						'alias' => 'frd',
						'type' => 'LEFT OUTER',
						'conditions' => ['fva.RecId = frd.RecId','fva.TransactionType = frd.TransactionType']
					])
                    ->join([
						'table' => '(select * from County_mst group by cm_title,cm_State)',
						'alias' => 'cm',
						'type' => 'LEFT OUTER',
						'conditions' => $CountyCondition
					])
                    ->join([
						'table' => 'company_mst',
						'alias' => 'cpm',
						'type' => 'LEFT OUTER',
						'conditions' => ['fmd.company_id = cpm.cm_id']
					])
                    ->join([
						'table' => 'document_type_mst',
						'alias' => 'dtm',
						'type' => 'LEFT OUTER',
						'conditions' => ['fva.TransactionType = dtm.Id']
					])
                    ->join([
						'table' => 'files_shiptoCounty_data'.ARCHIVE_PREFIX,
						'alias' => 'fsad',
						'type' => 'LEFT OUTER',
						'conditions' => ['fva.RecId = fsad.RecId','fva.TransactionType = fsad.TransactionType']
					]);
 
         

		$query= $query->where($whereCondition);

		return $query;
	}
 
// same as comlpetemaster query
    public function return2PartnerQuery($whereCondition, array $pdata){
            
        $this->setAlias('fmd');
        $this->setprifix = 'frd';
       
      
         
        $query = $this->find('search', $pdata)
                    ->join([
                        'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
                        'alias' => 'fva',
                        'type' => 'INNER',
                        'conditions' => ['fva.RecId = fmd.Id']
                    ])
                    ->join([
                        'table' => 'files_recording_data'.ARCHIVE_PREFIX,
                        'alias' => 'frd',
                        'type' => 'LEFT OUTER',
                        'conditions' => ['fva.RecId = frd.RecId','fva.TransactionType = frd.TransactionType']
                    ])
                    ->join([
                        'table' => 'files_returned2partner'.ARCHIVE_PREFIX,
                        'alias' => 'frtp',
                        'type' => 'LEFT OUTER',
                        'conditions' => ['frd.RecId = frtp.RecId','frd.TransactionType = frtp.TransactionType']
                    ])
                    ->join([
                        'table' => 'document_type_mst',
                        'alias' => 'dtm',
                        'type' => 'LEFT OUTER',
                        'conditions' => ['dtm.Id = fva.TransactionType']
                    ])
                    ->join([
                        'table' => 'company_mst',
                        'alias' => 'cpm',
                        'type' => 'LEFT OUTER',
                        'conditions' => ['cpm.cm_id = fmd.company_id']
                    ])
                    ->join([
                        'table' => 'files_qc_data'.ARCHIVE_PREFIX,
                        'alias' => 'fqcd',
                        'type' => 'LEFT OUTER',
                        'conditions' => ['frd.RecId = fqcd.RecId','frd.TransactionType = fqcd.TransactionType']
                    ]);

    $query= $query->where($whereCondition);
    return $query;

    }
 
    public function CheckPartnerFileNumber($PartnerFileNumber,$company_id=null)
    {
        $results= [];
        if(!empty($company_id)) {
            $where = ['fmd.PartnerFileNumber'=>addslashes($PartnerFileNumber), 'company_id' => $company_id];
        } else {
            $where = ['fmd.PartnerFileNumber'=>addslashes($PartnerFileNumber)];
        }
        
		$query = $this->find()
					->where($where)
					->select(['fmd.Id'])->disableHydration();
        //debug($query->sql());
		$results = $query->all()->toArray();
		
		if(!empty($results)) $results=$results[0];
		return $results;
			
    }
 

	public function completeMasterQuery($whereCondition, array $pdata){
		
		$this->setAlias('fmd');
		$this->setprifix = 'frtp';
	
		//unset($pdata['order']); //???
		$query = $this->find('search', $pdata)
                    ->join([
                        'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
                        'alias' => 'fva',
                        'type' => 'INNER',
                        'conditions' => ['fva.RecId = fmd.Id']
                    ])
					->join([
						'table' => 'files_returned2partner'.ARCHIVE_PREFIX,
						'alias' => 'frtp',
						'type' => 'LEFT',
						'conditions' => ['frtp.RecId = fva.RecId', 'frtp.TransactionType = fva.TransactionType']
					])
					->join([
						'table' => 'document_type_mst',
						'alias' => 'dtm',
						'type' => 'LEFT',
						'conditions' => ['dtm.Id = frtp.TransactionType']
					])
					->join([
						'table' => 'company_mst',
						'alias' => 'cpm',
						'type' => 'LEFT OUTER',
						'conditions' => ['cpm.cm_id = fmd.company_id']
					])
					->join([
						'table' => 'files_qc_data'.ARCHIVE_PREFIX,
						'alias' => 'fqcd',
						'type' => 'LEFT OUTER',
						'conditions' => ['fqcd.RecId = frtp.RecId', 'fqcd.TransactionType = frtp.TransactionType']
					])
					->join([
						'table' => 'files_recording_data'.ARCHIVE_PREFIX,
						'alias' => 'frd',
						'type' => 'LEFT OUTER',
						'conditions' => ['frd.RecId = frtp.RecId', 'frd.TransactionType = frtp.TransactionType']
					]);

	    $query= $query->where($whereCondition);
		return $query;

	}


    public function averageCountyAccountQuery(Query $query){
			$query = $query
						->select(
						 ['TransactionType' =>'dtm.Title','fmd.State','fmd.County','fmd.ECapable',
						 'jrf_final_fees' => $query->func()->avg('fad.jrf_final_fees'),
						 'it_final_fees' => $query->func()->avg('fad.it_final_fees'),
						 'of_final_fees' => $query->func()->avg('fad.of_final_fees'),
						 'total_final_fees' => $query->func()->avg('fad.total_final_fees')
						 ])
						->group(['fad.TransactionType','fmd.County','fmd.State'])
						->order(['fmd.County'=>'ASC', 'fmd.State'=>'ASC']);
	
		$results = $query->All()->toArray();
		
		return $results;
	}

    public function queryAfPendingFee($fromDate=''){
		
		$this->setAlias('fmd');
		$this->setprifix = 'fad';
		
		$query = $this->find();
		$fromDate = (empty($fromDate)) ? 'NOW()' : date('Y-m-d',strtotime($fromDate));
		$query = $query->select(
								 ['dtm.Title','fmd.State','fmd.County','avg_jrf_final_fees' => $query->func()->avg('fad.jrf_final_fees'),
								 'avg_it_final_fees' => $query->func()->avg('fad.it_final_fees'),
								 'avg_of_final_fees' => $query->func()->avg('fad.of_final_fees'),
								 'avg_total_final_fees' => $query->func()->avg('fad.total_final_fees')
								 ])
						->where(function ($exp, $q) {
							return $exp->isNotNull('fad.AccountingProcessingDate');
						})
						->where(function ($exp, $q) {
							return $exp->gt('fad.total_final_fees', '0.00');
						})
						// diff 180 days
						->where(["DATEDIFF('$fromDate',fva.CheckInProcessingDate) < " => 180])  
						->join([
                            'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
                            'alias' => 'fva',
                            'type' => 'INNER',
                            'conditions' => ['fmd.Id = fva.RecId']  
                        ])
						->join([
								'table' => 'files_accounting_data'.ARCHIVE_PREFIX,
								'alias' => 'fad',
								'type' => 'LEFT OUTER',
								'conditions' => ['fva.RecId = fad.RecId','fva.TransactionType = fad.TransactionType']
							])
						->join([
								'table' => 'document_type_mst',
								'alias' => 'dtm',
								'type' => 'LEFT',
								'conditions' => ['fad.TransactionType = dtm.Id']
							])
						->group(['fad.TransactionType','fmd.County','fmd.State'])
						->order(['fad.TransactionType'=>'ASC','fmd.State'=>'ASC','fmd.County'=>'ASC']);
        //debug($query->sql()); exit;
		$results = $query->All()->toArray();

		return $results;
	}
	
	public function filesRecordingEditData($fmdId, $docId){
		
		$fmdFld = $this->getAllFmdFields();

		$this->setAlias('fmd');
		
		$search = array_merge($fmdFld ,['comp_mst.cm_comp_name','fqcd.Status','fva.search_status','fva.search_status_updated_date','fsad.ShippingProcessingDate','recordId'=>'frd.Id','frd.File','frd.RecordingDate','frd.RecordingTime','frd.DocumentNumber','frd.Book','frd.Page','frd.EffectiveDate','frd.RecordingNotes','frd.RecordingProcessingDate','frd.RejectionFromCounty','frd.RejectionReason']);
		
			
		$query = $this->find()->select($search)
					->join([
						'table' => 'files_shiptoCounty_data'.ARCHIVE_PREFIX,
						'alias' => 'fsad',
						'type' => 'LEFT OUTER',
						'conditions' => ['fsad.RecId = fmd.Id']
					])
					->join([
						'table' => 'company_mst',
						'alias' => 'comp_mst',
						'type' => 'LEFT OUTER',
						'conditions' => ['comp_mst.cm_id = fmd.company_id']
					])
					->join([
						'table' => 'files_qc_data'.ARCHIVE_PREFIX,
						'alias' => 'fqcd',
						'type' => 'LEFT OUTER',
						'conditions' => ['fqcd.RecId = fsad.RecId','fqcd.TransactionType = fsad.TransactionType']
					])
					->join([
						'table' => 'files_recording_data'.ARCHIVE_PREFIX,
						'alias' => 'frd',
						'type' => 'LEFT OUTER',
						'conditions' => ['frd.RecId = fsad.RecId','frd.TransactionType = fsad.TransactionType']
					])->join([
						'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
						'alias' => 'fva',
						'type' => 'LEFT OUTER',
						'conditions' => ['fva.RecId = fsad.RecId','fva.TransactionType = fsad.TransactionType']
					]);
		$query= $query->where(['fsad.RecId'=>$fmdId, 'fsad.TransactionType'=>$docId]);
		$results = $query->all()->toArray();
		
		if(!empty($results)) return $results[0];

	}

    public function accountingCountyQuery($whereCondition, array $pdata, $callfrom=null){
	
		$this->setAlias('fmd');
		 
        $this->setprifix = 'fva';

        $query = $this->find('search', $pdata); 
		$query = $query->select( 
                            ['dtm.Title','fmd.State','fmd.County','jrf_final_fees' => $query->func()->avg('fad.jrf_final_fees'),
                            'it_final_fees' => $query->func()->avg('fad.it_final_fees'),
                            'of_final_fees' => $query->func()->avg('fad.of_final_fees'),
                            'total_final_fees' => $query->func()->avg('fad.total_final_fees'),
                            'Count' => $query->func()->count('fmd.County')
                            ]) 
                ->join([
                    'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
                    'alias' => $this->setprifix,
                    'type' => 'INNER',
                    'conditions' => ['fmd.Id = '.$this->setprifix.'.RecId']
                ]) 
                ->join([
                    'table' => 'files_accounting_data'.ARCHIVE_PREFIX,
                    'alias' => 'fad',
                    'type' => 'LEFT',
                    'conditions' => [$this->setprifix.'.RecId = fad.RecId',$this->setprifix.'.TransactionType = fad.TransactionType']
                ])
                ->join([
                    'table' => 'company_mst',
                    'alias' => 'cpm',
                    'type' => 'LEFT',
                    'conditions' => ['fmd.company_id = cpm.cm_id']
                ]) 
                ->join([
					'table' => 'document_type_mst',
					'alias' => 'dtm',
					'type' => 'LEFT',
					'conditions' => [$this->setprifix.'.TransactionType = dtm.Id']
				]) 
				->where($whereCondition);
	
		return $query;
	}
	

    public function pendingFileAnalysisQuery(array $whereCondition, array $selectFld, $prifix='fsad'){
        $this->setAlias('fmd'); 
        
        $query = $this->find()->select($selectFld);
        $query = $query->join([
            'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
            'alias' => 'fva',
            'type' => 'LEFT OUTER',
            'conditions' => ['fva.RecId =  fmd.Id']  
        ]);
        
        if($prifix == 'fsad'){
            $query = $query->join([
                    'table' => 'files_shiptoCounty_data'.ARCHIVE_PREFIX,
                    'alias' => 'fsad',
                    'type' => 'LEFT OUTER', 
                    'conditions' => ['fsad.RecId = fva.RecId','fsad.TransactionType = fva.TransactionType']
                ]);
        }
          
        if($prifix == 'fqcd'){
            $query = $query->join([
                    'table' => 'files_qc_data'.ARCHIVE_PREFIX,
                    'alias' => 'fqcd',
                    'type' => 'LEFT OUTER',
                    'conditions' => ['fqcd.RecId = fva.RecId','fqcd.TransactionType = fva.TransactionType']
                ]);
        }
        if($prifix == 'frd'){
            $query = $query->join([
                    'table' => 'files_recording_data'.ARCHIVE_PREFIX,
                    'alias' => 'frd',
                    'type' => 'LEFT OUTER',
                    'conditions' => ['frd.RecId = fva.RecId','frd.TransactionType = fva.TransactionType']
                ]); 
        }
          
        $query= $query->where($whereCondition)->disableHydration();
        //debug($query);exit;
        return $query->All()->toArray();
        //->limit(10)
    }
    
        
    public function pendingFileReportQuery(array $whereCondition, array $pdata, $prifix = 'fsad'){
        
        $this->setAlias('fmd'); 
        
        $query = $this->find('search', $pdata);
        $query = $query->join([
            'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
            'alias' => 'fva',
            'type' => 'LEFT OUTER',
            'conditions' => ['fva.RecId =  fmd.Id'] 
        ]);
        
        if($prifix == 'fsad'){
            $query = $query->join([
                    'table' => 'files_shiptoCounty_data'.ARCHIVE_PREFIX,
                    'alias' => 'fsad',
                    'type' => 'LEFT OUTER', 
                    'conditions' => ['fsad.RecId = fva.RecId','fsad.TransactionType = fva.TransactionType']
                ]);
        }
         
        if($prifix == 'fqcd'){
            $query = $query->join([
                    'table' => 'files_qc_data'.ARCHIVE_PREFIX,
                    'alias' => 'fqcd',
                    'type' => 'LEFT OUTER',
                    'conditions' => ['fqcd.RecId = fva.RecId','fqcd.TransactionType = fva.TransactionType']
                ]);
        }

        if($prifix == 'frd'){
            $query = $query->join([
                    'table' => 'files_recording_data'.ARCHIVE_PREFIX,
                    'alias' => 'frd',
                    'type' => 'LEFT OUTER',
                    'conditions' => ['frd.RecId = fva.RecId','frd.TransactionType = fva.TransactionType']
                ]); 
        }
            
        $query= $query->where($whereCondition);
    
        return $query;
    
    }	
    
    
    
    public function fetchCompanyFromFile($fileName =''){
        if(empty($fileName)) return '';
     
        $this->setAlias('fmd'); 
        
        $query = $this->find()->select(['fmd.company_id', 'frd.Id', 'fva.RecId','fva.TransactionType']);
                $query = $query->join([
                    'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
                    'alias' => 'fva',
                    'type' => 'LEFT OUTER',
                    'conditions' => ['fva.RecId = fmd.Id']
                ]); 
                $query = $query->join([
                        'table' => 'files_recording_data'.ARCHIVE_PREFIX,
                        'alias' => 'frd',
                        'type' => 'LEFT OUTER',
                        'conditions' => ['fva.RecId = frd.RecId','fva.TransactionType = frd.TransactionType']
                    ]); 
        
        $query= $query->where(['frd.File'=>$fileName])->disableHydration();
     
        $fileCompanyData =  $query->first();

        return $fileCompanyData;
 
    }
 
    // return direct fmd id if found else 0    FRD controller
 
    public function findQRcodeLRSnumber($lrsId){
        $query = $this->find()
                ->where(['NATFileNumber'=>$lrsId])
                ->select(['Id']);
        $results = $query->disableHydration(false)->all()->toArray();
        if(!empty($results[0])){
            return $results[0]['Id'];
        }else{
            return 0;
        }
    } 

     // return direct fmd id if found else 0   FRD controller
     public function findFMDPartnerFileNumber($PartnerFileNumber, $docId=''){
        $where  =['PartnerFileNumber'=>$PartnerFileNumber];
        if(!empty($docId)){
            $where = array_merge($where, ['TransactionType'=>$docId]);
        }
        $query = $this->find()
                ->where($where)
                ->select(['Id','TransactionType']);
        $results = $query->order(['DateAdded'=>'desc'])->limit(1)->disableHydration(false)->all()->toArray();
        if(!empty($results[0])){
            return $results[0];
        }else{
            return 0;
        }
    }

  
	public function recordingDataQuery($fmdId, $doctype){
		
		$this->setAlias('fmd');
		$this->setprifix = 'frd';
		$query = $this->find()
					->select([
								"fmd.NATFileNumber",
								"fmd.PartnerFileNumber",
								"fmd.PartnerFileNumber",
								"fmd.company_id",
								"cpm.cm_comp_name",
								"dtm.Title",
								"fmd.ECapable",
								"frd.Id",
								"frd.RecId",
								"frd.TransactionType",
								"frd.RecordingProcessingDate",
								"frd.InstrumentNumber",
								"frd.Book",
								"frd.Page"
                    ]);
                    $query = $query->join([
                        'table' => 'files_vendor_assignment'.ARCHIVE_PREFIX,
                        'alias' => 'fva',
                        'type' => 'LEFT OUTER',
                        'conditions' => ['fva.RecId =  fmd.Id']
                    ]);
                    $query = $query->join([
				    	'table' => 'files_recording_data'.ARCHIVE_PREFIX,
						'alias' => 'frd',
						'type' => 'LEFT OUTER',
						'conditions' => ['frd.RecId = fva.RecId','frd.TransactionType = fva.TransactionType']
					]);
					$query = $query->join([
						'table' => 'document_type_mst',
						'alias' => 'dtm',
						'type' => 'LEFT',
						'conditions' => ['dtm.Id = frd.TransactionType']
					])
					->join([
						'table' => 'company_mst',
						'alias' => 'cpm',
						'type' => 'LEFT OUTER',
						'conditions' => ['cpm.cm_id = fmd.company_id']
					]);
					
			$query = $query->where(['frd.RecId'=>$fmdId, 'frd.TransactionType'=>$doctype]);	

			$result =$query->disableHydration(false)->all()->toArray();
			
		return $result;
	}
	
	public function getCountyCalRequestData($FmdIds=''){
		$results= [];
		if(!empty($FmdIds)){
			$this->setAlias('fmd');
			$query = $this->find()
						->where(['fmd.Id'=>$FmdIds])
						
						->join([
							'table' => 'States',
							'alias' => 'st',
							'type' => 'INNER',
							'conditions' => ['st.State_code = fmd.State']
						])
						->join([
								'table' => 'County_mst',
								'alias' => 'cou_mst',
								'type' => 'INNER',
								'conditions' => ['cou_mst.cm_title = fmd.County', 'cou_mst.cm_State = fmd.State']
						]) 
						->select(['fmd.Id', 'st.id', 'cou_mst.cm_id', 'fmd.LoanAmount']);

			$results = $query->disableHydration()->all()->toArray();
		}
		return $results;
		
	}
	 
}