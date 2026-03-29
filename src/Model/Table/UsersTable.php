<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsToMany $Groups
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey('user_id');

        $this->addBehavior('Search.Search');

        // Setup search filter using search manager
        $this->searchManagerConfig();

        $this->belongsToMany('Groups', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'group_id',
            'joinTable' => 'users_groups',
        ]);
        
        $this->belongsTo('CompanyMst', [
            'foreignKey' => 'user_companyid',
            'targetForeignKey' => 'cm_id',
            'joinType' => 'INNER'
        ]);
        
        $this->setEntityClass(\App\Model\Entity\User::class); // 👈 force entity
    }

    public function searchManagerConfig()
    {
        $search = $this->searchManager(); 
       
        $search->Like('user_name');
        $search->Like('user_lastname'); 
        $search->Like('user_email',); 
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
        $validator
            ->scalar('user_name')
            ->maxLength('user_name', 255)
            ->requirePresence('user_name', 'create')
            ->notEmptyString('user_name');

        /* $validator
            ->scalar('user_lastname')
            ->maxLength('user_lastname', 50)
            ->requirePresence('user_lastname', 'create')
            ->notEmptyString('user_lastname');

        $validator
            ->scalar('user_phone')
            ->maxLength('user_phone', 50)
            ->requirePresence('user_phone', 'create')
            ->notEmptyString('user_phone'); */

        $validator
            ->scalar('user_email')
            ->maxLength('user_email', 255)
            ->requirePresence('user_email', 'create')
            ->notEmptyString('user_email')
            ->add('user_email', 'valid', ['rule' => 'email'])
            ->add('user_email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table','message' => __('Sorry, the email already exists. Please specify an alternate email.'),]);

        $validator
            ->scalar('user_username')
            ->maxLength('user_username', 32)
            ->requirePresence('user_username', 'create')
            ->notEmptyString('user_username');
 
            
        $validator
            ->scalar('password', __('Valid password is required.'))
            ->minLength('password', 8, __('Password should count at least 8 characters.'))
            ->maxLength('password', 60, __('Password should count at most 60 characters.'))
            ->requirePresence('password', 'create')
            ->notEmptyString('password', __('Password is required.'));

        $validator
            ->scalar('confirm_password', __('Password check is required.'))
            ->minLength('confirm_password', 8, __('Password check should count at least 8 characters.'))
            ->maxLength('confirm_password', 60, __('Password check should count at most 60 characters.'))
            ->requirePresence('confirm_password', 'create')
            ->notEmptyString('confirm_password', __('Password check is required.'))
            ->sameAs('confirm_password', 'password', __('Password check and password should be identical.'));
        
      /*  
        $validator
            ->scalar('original_password')
            ->maxLength('original_password', 255)
            ->requirePresence('original_password', 'create')
            ->notEmptyString('original_password');

         $validator
 
            ->integer('user_companyid')
            ->requirePresence('user_companyid', 'create')
            ->notEmptyString('user_companyid'); */

 
        $validator
            ->scalar('user_active')
            ->maxLength('user_active', 1)
            ->requirePresence('user_active', 'create')
            ->notEmptyString('user_active');

        $validator
            ->scalar('user_deleted')
            ->maxLength('user_deleted', 1)
            ->notEmptyString('user_deleted');

        /* $validator
            ->scalar('privileges2add')
            ->maxLength('privileges2add', 1)
            ->requirePresence('privileges2add', 'create')
            ->notEmptyString('privileges2add');

        $validator
            ->scalar('privileges2edit')
            ->maxLength('privileges2edit', 1)
            ->requirePresence('privileges2edit', 'create')
            ->notEmptyString('privileges2edit');

        $validator
            ->scalar('privileges2delete')
            ->maxLength('privileges2delete', 1)
            ->requirePresence('privileges2delete', 'create')
            ->notEmptyString('privileges2delete'); */

        return $validator;
    }

    public function validationPassword(Validator $validator)
    {

	   $validator
			->add('old_password','custom',[
				'rule' => function($value, $context){
					$user = $this->get($context['data']['id']);
					if($user)
					{
						if((new DefaultPasswordHasher)->check($value, $user->password))
						{
							return true;
						}
					}
					return false;
				},
				'message' => 'Your old password does not match the entered password!',
			])
			->notEmpty('old_password');
        $validator
                ->add('new_password',[
                    'length' => [
                        'rule' => ['minLength',6],
                        'message' => 'Please enter atleast 6 characters in password your password.'
                    ]
                ]) 
                ->notEmpty('new_password');
        
        $validator
                ->add('confirm_password',[
                    'length' => [
                        'rule' => ['minLength',6],
                        'message' => 'Please enter atleast 6 characters in password your password.'
                    ]
                ])
                ->add('confirm_password',[
                    'match' => [
                        'rule' => ['compareWith','new_password'],
                        'message' => 'Sorry! Password dose not match. Please try again!'
                    ]
                ])
                ->notEmpty('confirm_password');
        
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['user_username']), ['errorField' => 'user_username','message' => 'Sorry, the username already exists. Please specify an alternate username.']);

        return $rules;
    }
}