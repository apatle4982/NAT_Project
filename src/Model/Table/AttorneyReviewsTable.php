<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AttorneyReviewsTable extends Table{

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('attorney_reviews');
        $this->setPrimaryKey('RecId');
        $this->addBehavior('Timestamp');

        $this->addBehavior('Timestamp');

        $this->setEntityClass('App\Model\Entity\AttorneyReview');
        $this->addBehavior('Search.Search');
        $this->searchManagerConfig();
    }

    public function searchManagerConfig()
    {
        $search = $this->searchManager();
		$search->Like('RecId');
		$search->Like('status');
        return $search;
    }

    public function get_fmd_data($id) {
        $this->loadModel("FilesMainData");
        return $this->FilesMainData->find()
            ->where(['Id' => $id])
            ->first(); // Fetches only one result instead of a ResultSet
    }

}
