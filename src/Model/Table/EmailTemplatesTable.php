<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailTemplates Model
 *
 * @method \App\Model\Entity\EmailTemplate get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmailTemplate newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmailTemplate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmailTemplate|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailTemplate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmailTemplate[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmailTemplate findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmailTemplatesTable extends Table
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

        $this->table('email_templates');
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
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('slug', 'create')
            ->notEmpty('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('subject', 'create')
            ->notEmpty('subject');

        $validator
            ->requirePresence('email_content', 'create')
            ->notEmpty('email_content');

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
        $rules->add($rules->isUnique(['slug']));

        return $rules;
    }
    
    public function isValid($id) {
        if(!empty(trim($id))) {
            $conditions = ['id' => trim($id)];            
            $count = $this->find()->where($conditions)->count('*');
            if($count >= 1) {
                return true;
            }
        }
        return false;
    }
}
