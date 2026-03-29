<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PublicNotesAolTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('public_notes_aol');
        $this->setDisplayField('Id');
        $this->setPrimaryKey('Id');
        
        $this->belongsTo('FilesMainData', [
            'foreignKey' => 'RecId',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('DocumentTypeMst', [
            'foreignKey' => 'TransactionType',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'UserId',
            'joinType' => 'INNER'
        ]);
		
		$this->addBehavior('Search.Search');
        $this->searchManagerConfig();
    }

    public function searchManagerConfig()
    {
        $search = $this->searchManager();
		$search->like('Regarding');
		$search->like('Type');
		$search->like('Section');
		$search->like('Public_Internal');
        return $search;
    }
}
