<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Validation\Validation;

/**
 * Settings Model
 *
 * @method \App\Model\Entity\Setting get($primaryKey, $options = [])
 * @method \App\Model\Entity\Setting newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Setting[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Setting|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Setting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Setting[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Setting findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SettingsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('settings');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('key_field', 'create')
            ->notEmpty('key_field','Key field is required.')
            ->add('key_field', [
                'minLength' => [
                    'rule' => ['minLength', 2],
                    'last' => true,
                    'message' => 'Key field should contain atleast 2 characters.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 100],
                    'last' => true,
                    'message' => 'Key field should contain atmost 100 characters.'
                ],
                'unique' => [
                    'rule' => ['validateUnique'],
                    'provider' => 'table',
                    'last' => true,
                    'message' => 'This key field is already used.'
                ],
                'checkString' => [
                    'rule' => ['checkString'],
                    'provider' => 'table',
                    'last' => true,
                    'message' => 'Only characters allowed with underscore ex(abc_de).'
                ]
            ]);

        $validator
            ->requirePresence('key_value', 'create')
            ->notEmpty('key_value','Value field is required.');

        return $validator;
    }
    
    public function validationSaveSetting(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('key_field', 'create')
            ->notEmpty('key_field','Key field is required.')
            ->add('key_field', [
                'minLength' => [
                    'rule' => ['minLength', 2],
                    'last' => true,
                    'message' => 'Key should contain atleast 2 characters.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 100],
                    'last' => true,
                    'message' => 'Key should contain atmost 100 characters.'
                ],
                'unique' => [
                    'rule' => ['validateUnique'],
                    'provider' => 'table',
                    'last' => true,
                    'message' => 'This key is already used.'
                ],
                'checkString' => [
                    'rule' => ['checkString'],
                    'provider' => 'table',
                    'last' => true,
                    'message' => 'Only characters allowed with underscore ex(abc_de).'
                ]
            ]);

        $validator
            ->requirePresence('key_value', 'create')
            ->notEmpty('key_value','Value field is required.');

        return $validator;
    }
    
    public function checkString($check) {
        return Validation::custom($check,'/^[a-zA-Z_]+$/');
    }
    
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->isUnique(['key_field']));

        return $rules;
    }
    
    public function isUniqueKey($key,$id=null) {
        $options = [
            'conditions' => ['Settings.key_field'=>$key]
        ];
        if(!empty($id)) {
            $options['conditions']['Settings.id !='] = $id;
        }
        $count = $this->find('all',$options)->count();
        if($count < 1) {
            return true;
        }
        return false;
    }
}
