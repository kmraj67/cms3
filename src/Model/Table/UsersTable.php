<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Validation\Validation;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Roles
 * @property \Cake\ORM\Association\BelongsTo $Statuses
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Statuses', [
            'foreignKey' => 'status_id',
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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message'=>'This email is already used.']);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->allowEmpty('last_name');

        $validator
            ->dateTime('last_login')
            ->allowEmpty('last_login');

        return $validator;
    }
    
    /**
     * Add and update user validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationSaveUser(Validator $validator) {
        $validator
            ->requirePresence('role_id', 'create')
            ->notEmpty('role_id', 'Role is required.')
            ->numeric('role_id','Role should be numeric.');
            
        $validator
            ->email('email', 'Please provide a valid email.')
            ->requirePresence('email', 'create')
            ->notEmpty('email', 'Email is required.')
            ->add('email',
                'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'This email is already used.']);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', 'Password is required.');

        $validator
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name', 'First name is required.')
            ->add('first_name',[
                'minLength' => [
                    'rule' => ['minLength', 2],
                    'last' => true,
                    'message' => 'First name should contain atleast 2 characters.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 50],
                    'last' => true,
                    'message' => 'First name should contain atmost 50 characters.'
                ],
                'checkString' => [
                    'rule' => ['checkString'],
                    'provider' => 'table',
                    'message' => 'First name should contain only characters.'
                ]
            ]);

        $validator
            ->allowEmpty('last_name')
            ->add('last_name',[
                'minLength' => [
                    'rule' => ['minLength', 2],
                    'last' => true,
                    'message' => 'Last name should contain atleast 2 characters.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 50],
                    'last' => true,
                    'message' => 'Last name should contain atmost 50 characters.'
                ],
                'checkString' => [
                    'rule' => ['checkString'],
                    'provider' =>'table',
                    'message' => 'Last name should contain only characters.'
                ]
            ]);
            
        $validator
            ->allowEmpty('phone')
            ->numeric('phone','Please enter a valid phone number.')
            ->add('phone',[
                'minLength' => [
                    'rule' => ['minLength', 8],
                    'message' => 'Phone should contain atleast 8 digits.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 12],
                    'message' => 'Phone should contain atmost 12 digits.'
                ]
            ]);

        return $validator;
    }
    
    public function validationProfile(Validator $validator) {
        $validator
            ->email('email', 'Please provide a valid email.')
            ->requirePresence('email', 'create')
            ->notEmpty('email', 'Email is required.')
            ->add('email',
                'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'This email is already used.']);

        $validator
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name', 'First name is required.')
            ->add('first_name',[
                'minLength' => [
                    'rule' => ['minLength', 2],
                    'last' => true,
                    'message' => 'First name should contain atleast 2 characters.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 50],
                    'last' => true,
                    'message' => 'First name should contain atmost 50 characters.'
                ],
                'checkString' => [
                    'rule' => ['checkString'],
                    'provider' => 'table',
                    'message' => 'First name should contain only characters.'
                ]
            ]);

        $validator
            ->allowEmpty('last_name')
            ->add('last_name',[
                'minLength' => [
                    'rule' => ['minLength', 2],
                    'last' => true,
                    'message' => 'Last name should contain atleast 2 characters.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 50],
                    'last' => true,
                    'message' => 'Last name should contain atmost 50 characters.'
                ],
                'checkString' => [
                    'rule' => ['checkString'],
                    'provider' =>'table',
                    'message' => 'Last name should contain only characters.'
                ]
            ]);
            
        $validator
            ->allowEmpty('phone')
            ->numeric('phone','Please enter a valid phone number.')
            ->add('phone',[
                'minLength' => [
                    'rule' => ['minLength', 8],
                    'message' => 'Phone should contain atleast 8 digits.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 12],
                    'message' => 'Phone should contain atmost 12 digits.'
                ]
            ]);

        return $validator;
    }
    
    public function validationLogin(Validator $validator) {
        $validator
            ->notEmpty('email', 'Please enter valid email address.')
            ->notEmpty('password', 'Please enter a valid password.');
        return $validator;
    }
    
    public function checkString($check) {
        return Validation::custom($check,'/^[a-zA-Z ]+$/');
    }
    
    public function isValid($id,$isDeleted=false) {
        if(!empty(trim($id))) {
            $statuses = [ACTIVE,INACTIVE];
            $conditions = ['Users.id' => trim($id)];
            
            if($isDeleted == true) {
                $statuses[] = DELETED;
            }
            
            $conditions['Users.status_id IN'] = $statuses;
            
            $count = $this->find()->where($conditions)->count('*');
            
            if($count >= 1) {
                return true;
            }
        }
        return false;
    }
    
    public function validationForgot(Validator $validator) {
        return $validator
        ->requirePresence('email')
        ->notEmpty('email','Please enter a email address.')
        ->add('email',[
            'validFormat' => [
                'rule' => ['email'],
                'last' => true,
                'message' => 'Please enter a valid email address.'
            ],
            'isEmailExists' => [
                'rule' => ['isEmailExists'],
                'provider'=>'table',
                'message' => 'Please enter a registered email address.'
            ]
        ]);
    }
    
    public function validationReset(Validator $validator) {
        return $validator
        ->requirePresence('password')
        ->notEmpty('password','New password is required.')
        ->add('password',[
            'minLength' => [
                'rule' => ['minLength',8],
                'last' => true,
                'message' => 'New password must be atleast 8 characters long.'
            ],
            'maxLength' => [
                'rule' => ['maxLength',30],
                'last' => true,
                'message' => 'New password must be atmost 30 characters long.'
            ]
        ])
        ->requirePresence('confirm_password')
        ->notEmpty('confirm_password','Confirm password is required.')
        ->add('confirm_password',[
            'maxLength' => [
                'rule' => ['maxLength',30],
                'last' => true,
                'message' => 'Confirm password must be atmost 30 characters long.'
            ],
            'compare' => [
                'rule' => ['compareWith','password'],
                'message' => 'New password and confirm password does not match.'
            ]
        ]);
    }
    
    public function validationChangepassword(Validator $validator) {
        return $validator
        ->requirePresence('old_password')
        ->notEmpty('old_password','Old password is required.')
        ->add('old_password',[
            'isValidOldPassword' => [
                'rule' => ['isValidOldPassword',null],
                'provider'=>'table',
                'message' => 'Please check your password and try again.'
            ]
        ])
        ->requirePresence('new_password')
        ->notEmpty('new_password','New password is required.')
        ->add('new_password',[
            'minLength' => [
                'rule' => ['minLength',8],
                'last' => true,
                'message' => 'New password must be atleast 8 characters long.'
            ],
            'maxLength' => [
                'rule' => ['maxLength',30],
                'last' => true,
                'message' => 'New password must be atmost 30 characters long.'
            ]
        ])
        ->requirePresence('confirm_password')
        ->notEmpty('confirm_password','Confirm password is required.')
        ->add('confirm_password',[
            'maxLength' => [
                'rule' => ['maxLength',30],
                'last' => true,
                'message' => 'Confirm password must be between 8 and 30 characters long.'
            ],
            'compare' => [
                'rule' => ['compareWith','new_password'],
                'message' => 'New password and confirm password does not match.'
            ]
        ]);
    }
    
    public function isValidOldPassword($password,$user_id,$params=[]) {
        if(empty($user_id)) {
           $user_id = $params['data']['id']; 
        }
        $row = $this->findById($user_id)->first();
        if(!empty($row)) {
            return (new DefaultPasswordHasher)->check($password,$row->password);
        }
        return false;
    }
    
    public function isEmailExists($value) {
        $options = [
            'conditions' => ['Users.email'=>$value]
        ];
        $count = $this->find('all',$options)->count();
        if($count >= 1) {
            return true;
        }
        return false;
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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        $rules->add($rules->existsIn(['status_id'], 'Statuses'));

        return $rules;
    }
    
    public function isValidResetToken($forgot_password_token) {
        if(!empty($forgot_password_token)) {
            $options = [
                'conditions' => [
                    'Users.forgot_password_token'=>$forgot_password_token
                ]
            ];
            $count = $this->find('all',$options)->count();
            if($count >= 1) {
                return true;
            }
        }
        return false;        
    }
    
    public function isUniqueEmail($email,$id=null) {
        $options = [
            'conditions' => ['Users.email'=>$email]
        ];
        if(!empty($id)) {
            $options['conditions']['Users.id !='] = $id;
        }
        $count = $this->find('all',$options)->count();
        if($count < 1) {
            return true;
        }
        return false;
    }
}
