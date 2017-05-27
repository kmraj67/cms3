<?= $this->Form->create($setting,['id'=>'admin_add_setting_form','class'=>'form-horizontal','novalidate'=>true]) ?>
<?= $this->Form->hidden('id',['id'=>'setting_id','value'=>$this->Common->encrypt($id)]) ?>
<div class="modal-header">
    <h4 class="modal-title">Add New Settings</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <div class="col-sm-12">
            <?= $this->Form->input('key_field',['type'=>'text','class'=>'form-control','placeholder'=>'Key','label'=>false]) ?>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-12">
            <?= $this->Form->input('key_value',['type'=>'textarea','maxlength'=>250,'class'=>'form-control','placeholder'=>'Value','label'=>false]) ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save Settings</button>
</div>
<?= $this->Form->end() ?>