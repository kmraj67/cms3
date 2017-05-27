<?= $this->Form->create($emailTemplate,['id'=>'email_template_form','role'=>'form','novalidate'=>true]) ?>
    <?= $this->Form->hidden('id',['id'=>'email_template_id']) ?>
    <div class="col-lg-6">
        <div class="form-group">
            <?= $this->Form->input('slug',['type'=>'text','class'=>'form-control']) ?>
        </div>
        
        <div class="form-group">
            <?= $this->Form->input('subject',['type'=>'text','class'=>'form-control']) ?>
        </div>
    </div>
    
    <div class="col-lg-12">
        <div class="form-group">
            <?= $this->Form->input('email_content',['class'=>'form-control','id'=>'editor1']) ?>
        </div>
    </div>
    
    <div class="col-lg-6">
        <?= $this->Form->button(__('Save Template'),['class'=>'btn btn-success']) ?>
    </div>
<?= $this->Form->end() ?>