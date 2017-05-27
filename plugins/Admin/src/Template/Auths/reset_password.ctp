<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Reset Yor Password</h3>
    </div>
    
    <!-- Panel body start -->
    <div class="panel-body">
        <?= $this->Form->create($user,['id'=>'admin_reset_password_form','class'=>'form-horizontal','novalidate'=>true]) ?>
            <input name="foilautofill" style="display: none;" type="password" />
            <div class="form-group">
                <div class="col-sm-12">
                    <?= $this->Form->input('password',['class'=>'form-control','placeholder'=>'New Password','label'=>false]) ?>
                    <span class="text-danger"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <?= $this->Form->input('confirm_password',['type'=>'password','class'=>'form-control','placeholder'=>'Confirm Password','label'=>false]) ?>
                    <span class="text-danger"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="submit" value="Reset" class="btn btn-primary btn-block">
                </div>                    
            </div>
        <?= $this->Form->end() ?>
    </div>
    <!-- Panel body start -->
</div>
<!-- Panel end -->