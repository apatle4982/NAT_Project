<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class VendorsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('vendors'); // Name of your database table
        $this->setDisplayField('name'); // Field to be used as the display field
        $this->setPrimaryKey('id');

		$this->addBehavior('Search.Search');

		// Setup search filter using search manager
        $this->searchManagerConfig();
    }

    public function searchManagerConfig()
    {
        $search = $this->searchManager();
		$search->Like('name');
		$search->Like('city');
		$search->Like('state');
        return $search;
    }

      public function validationDefault(Validator $validator): Validator
      {
          $validator
              // Vendor Name
              ->requirePresence('name', 'create')
              ->notEmptyString('name', 'Vendor Name is required')
              ->maxLength('name', 255, 'Vendor Name cannot exceed 255 characters')

              // Address
              ->requirePresence('address', 'create')
              ->notEmptyString('address', 'Address is required')
              ->maxLength('address', 255, 'Address cannot exceed 255 characters')

              // City
              ->requirePresence('city', 'create')
              ->notEmptyString('city', 'City is required')
              ->maxLength('city', 100, 'City cannot exceed 100 characters')

              // State
              ->requirePresence('state', 'create')
              ->notEmptyString('state', 'State is required')
              ->maxLength('state', 100, 'State cannot exceed 100 characters')

              // Zip Code
              ->requirePresence('zip', 'create')
              ->notEmptyString('zip', 'Zip code is required')
              ->add('zip', 'validFormat', [
                  'rule' => ['custom', '/^\d{5}(-\d{4})?$/'],
                  'message' => 'Enter a valid ZIP code (e.g., 12345 or 12345-6789)'
              ])
              ->maxLength('zip', 10, 'Zip code cannot exceed 10 characters');

          return $validator;
      }

    /*public function vendorCompanyList(){

		return $this->find('list', [
					'keyField' => 'id',
					'valueField' => 'name'
				])->where(['name !=' => ''])
				->order(['name' => 'ASC']);
				//->limit(100);

	}*/

    /*public function ListArray(){
		return $this->find('list', [
					'keyField' => 'id',
					'valueField' => 'name'
				])
				->order(['name' => 'ASC']);

	}*/
    public function ListArray($type = ""){
        $conditions = [];

        if ($type == "V") {
            $conditions['title_exam_services <>'] = '';
        }
        if ($type == "A") {
            $conditions['aol_generation <>'] = '';
        }
        if ($type == "E") {
            $conditions['full_escrow_closing <>'] = '';
        }

        $query = $this->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])
        ->where($conditions)
        ->order(['name' => 'ASC']);
        return $query;
    }

    public function get_vendor($id) {
        return $this->find()
            ->where(['id' => $id])
            ->first(); // Fetches only one result instead of a ResultSet
    }

    public function get_vendor_services($id) {
        $query = $this->find()
        ->select([
            'id' => 'ns.id',
            'sub_service' => 'ns.sub_service',
            'time' => 'ns.turn_around_time'
        ])
        ->leftJoin(
            ['ns' => 'nat_services'], // Alias for nat_services
            [
                'OR' => [
                    'FIND_IN_SET(ns.id, Vendors.title_exam_services) > 0'
                    //'FIND_IN_SET(ns.id, Vendors.aol_generation) > 0',
                    //'FIND_IN_SET(ns.id, Vendors.full_escrow_closing) > 0'
                ]
            ]
        )
        ->where(['Vendors.id' => $id]);
        $results = $query->all();
        return $results; // Filter by id
    }

    public function get_att_services($id) {
        $query = $this->find()
        ->select([
            'id' => 'ns.id',
            'sub_service' => 'ns.sub_service',
            'time' => 'ns.turn_around_time'
        ])
        ->leftJoin(
            ['ns' => 'nat_services'], // Alias for nat_services
            [
                'OR' => [
                    //'FIND_IN_SET(ns.id, Vendors.title_exam_services) > 0',
                    'FIND_IN_SET(ns.id, Vendors.aol_generation) > 0'
                    //'FIND_IN_SET(ns.id, Vendors.full_escrow_closing) > 0'
                ]
            ]
        )
        ->where(['Vendors.id' => $id]);
        $results = $query->all();

        return $results; // Filter by id
    }

    public function get_ess_services($id) {
        $query = $this->find()
        ->select([
            'id' => 'ns.id',
            'sub_service' => 'ns.sub_service',
            'time' => 'ns.turn_around_time'
        ])
        ->leftJoin(
            ['ns' => 'nat_services'], // Alias for nat_services
            [
                'OR' => [
                    //'FIND_IN_SET(ns.id, Vendors.title_exam_services) > 0',
                    //'FIND_IN_SET(ns.id, Vendors.aol_generation) > 0',
                    'FIND_IN_SET(ns.id, Vendors.full_escrow_closing) > 0'
                ]
            ]
        )
        ->where(['Vendors.id' => $id]);
        $results = $query->all();
        return $results; // Filter by id
    }

}
