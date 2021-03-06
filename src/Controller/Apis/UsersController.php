<?php
namespace App\Controller\Apis;

use App\Controller\Apis\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * Users Controller
 *
 * @property \Apis\V1\Model\Table\UsersTable $Users
 */
class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $response = $this->Common->getResponse('400');
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $request_data = $this->request->input('json_decode', true);
            $user_data = [
                'role_id'    => USER,
                'email'      => isset($request_data['email'])?$request_data['email']:null,
                'password'   => isset($request_data['password'])?$request_data['password']:null,
                'first_name' => isset($request_data['first_name'])?$request_data['first_name']:null,
                'last_name'  => isset($request_data['last_name'])?$request_data['last_name']:null,
                'phone'      => isset($request_data['phone'])?$request_data['phone']:null,
                'status_id'  => ACTIVE,
                'created'    => $this->current_date,
                'modified'   => $this->current_date
            ];
            $user = $this->Users->patchEntity($user, $user_data, ['validate'=>'saveUser']);
            if(empty($user->errors())) {
                if ($this->Users->save($user)) {
                    $response = $this->Common->getResponse('201','success','User registered successfuly.');
                    $response['user'] = $user;
                } else {
                    $response = $this->Common->getResponse('304','error','User could not be registered, try again.');
                }
            } else {
                $response = $this->Common->getResponse('400','error','Validation errors');
                $response['errors'] = $this->Common->getErrors($user->errors());
            }
        } else {
            $response = $this->Common->getResponse('405');
        }
        
        $this->_serializeData($response);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function _delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
