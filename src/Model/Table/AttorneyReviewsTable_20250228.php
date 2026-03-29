<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AttorneyReviewsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('attorney_reviews');
        $this->setPrimaryKey('Id');
        $this->addBehavior('Timestamp');

        $this->addBehavior('Timestamp');

        $this->setEntityClass('App\Model\Entity\AttorneyReview');
    }

    public function get_fmd_data($id) {
        $this->loadModel("FilesMainData");
        return $this->FilesMainData->find()
            ->where(['Id' => $id])
            ->first(); // Fetches only one result instead of a ResultSet
    }

}
