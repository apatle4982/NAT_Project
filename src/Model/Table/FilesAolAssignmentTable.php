<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Log\Log;

class FilesAolAssignmentTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('files_aol_assignment'); // Table name
        $this->setPrimaryKey('Id'); // Primary key
        $this->setDisplayField('Id'); // Display field
    }

    /*public function deleteByRecId($recId): bool
    {
        $record = $this->find()
            ->where(['RecId' => $recId])
            ->first();

        if ($record) {
            return $this->delete($record);
        }

        return false;
    }*/

    public function deleteByRecId($recId): bool
{
    $record = $this->find()
        ->where(['RecId' => $recId])
        ->first();

    if (!$record) {
        return false;
    }

    $data = $record->toArray();

    $archiveTable = \Cake\ORM\TableRegistry::getTableLocator()->get('FilesAolAssignmentArchieve');
    $archived = $archiveTable->newEntity($data);

    if ($archiveTable->save($archived, ['validate' => false])) {
        return $this->delete($record);
    } else {
        Log::debug('Failed to save to archive. Errors: ' . json_encode($archived->getErrors()));
        Log::debug('Raw data being saved: ' . json_encode($data));
    }

    return false;
}
}
