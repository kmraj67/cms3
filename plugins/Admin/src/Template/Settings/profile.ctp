<?php
    $breadcrumb = [
        'page_heading'=>'Profile',
        'small_page_heading'=>'Admin Profile',
        'links'=>['icon'=>'<i class="fa fa-user"></i>','title'=>'Profile']
    ];    
    echo $this->element('Layout/breadcrumb', $breadcrumb);
    echo $this->Flash->render();
?>

<div class="row">
    <div class="col-lg-6">
        <?= $this->Form->create($user,['id'=>'admin_profile_form','role'=>'form','novalidate'=>true]) ?>
        <?= $this->Form->hidden('id',['id'=>'user_id']) ?>
            <div class="form-group">
                <?= $this->Form->input('email',['type'=>'text','class'=>'form-control']) ?>
            </div>
            
            <div class="form-group">
                <?= $this->Form->input('first_name',['type'=>'text','class'=>'form-control']) ?>
            </div>
            
            <div class="form-group">
                <?= $this->Form->input('last_name',['type'=>'text','class'=>'form-control']) ?>
            </div>
            
            <div class="form-group">
                <?= $this->Form->input('phone',['type'=>'text','class'=>'form-control']) ?>
            </div>
            
            <?= $this->Form->button(__('Update'),['class'=>'btn btn-success']) ?>
            
        <?= $this->Form->end() ?>
    </div>
</div>