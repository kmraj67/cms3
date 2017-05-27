<?= $this->Form->create($user,['id'=>'user_form','role'=>'form','novalidate'=>true]) ?>
    <?= $this->Form->hidden('id',['id'=>'user_id']) ?>
    <div class="form-group">
        <?= $this->Form->input('role_id',['class'=>'form-control','empty'=>'Select']) ?>
    </div>
    
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
    
    <div class="form-group">
        <?php echo $this->Form->radio('status_id',[1=>'Active',2=>'In-Active'],['legend'=>false,'default'=>1,'label'=>['class'=>'radio-inline']]); ?>
    </div>
    
    <?= $this->Form->button(__('Save User'),['class'=>'btn btn-success']) ?>
    
<?= $this->Form->end() ?>