<?= $this->Form->create($user,['id'=>'admin_change_password_form','method'=>'put','class'=>'form-horizontal','novalidate'=>true]) ?>
<input name="foilautofill" style="display: none;" type="password" />
<div class="modal-header">
    <h4 class="modal-title">Change Password</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <div class="col-sm-12">
            <?= $this->Form->input('old_password',['type'=>'password','class'=>'form-control','placeholder'=>'Old Password','label'=>false]) ?>
            <span class="text-danger"></span>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-12">
            <?= $this->Form->input('new_password',['type'=>'password','class'=>'form-control','placeholder'=>'New Password','label'=>false]) ?>
            <span class="text-danger"></span>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-12">
            <?= $this->Form->input('confirm_password',['type'=>'password','class'=>'form-control','placeholder'=>'Confirm Password','label'=>false]) ?>
            <span class="text-danger"></span>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save Password</button>
</div>
<?= $this->Form->end() ?>