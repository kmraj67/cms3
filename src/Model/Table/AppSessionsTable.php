<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AppSessions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\AppSession get($primaryKey, $options = [])
 * @method \App\Model\Entity\AppSession newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AppSession[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AppSession|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AppSession patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AppSession[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AppSession findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AppSessionsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('app_sessions');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('token', 'create')
            ->notEmpty('token');

        $validator
            ->allowEmpty('ip_address');

        $validator
            ->allowEmpty('http_user_agent');

        $validator
            ->dateTime('last_active')
            ->requirePresence('last_active', 'create')
            ->notEmpty('last_active');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
    
    public function isValidToken($token) {
        if(!empty(trim($token))) {
            $count = $this->findByToken($token)->count();
            if($count >= 1) {
                return true;
            }
        }
        return false;
    }
    
    public function deleteSession($token) {
        $appSession = $this->findByToken($token)->first();
        if($this->delete($appSession)) {
            return true;
        }
        return false;
    }
}
