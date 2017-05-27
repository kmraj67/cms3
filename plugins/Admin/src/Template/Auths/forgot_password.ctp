<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Forgot Password</h3>
    </div>
    
    <!-- Panel body start -->
    <div class="panel-body">
        <?= $this->Form->create($user,['id'=>'admin_forgot_password_form','class'=>'form-horizontal','novalidate'=>true]) ?>
            <div class="form-group">
                <div class="col-sm-12">
                    <p class="help-block">Enter your registered email below to receive your password reset instructions. </p>
                    <?= $this->Form->input('email',['class'=>'form-control','placeholder'=>'Email','label'=>false]) ?>
                    <span class="text-danger"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="submit" value="Submit" class="btn btn-primary btn-block">
                </div>                    
            </div>
            <div class="forgot-password pull-right">
                <a href="<?php echo $base_url ?>admin/login" class="forgot-link">Back to Login</a>
            </div>
        <?= $this->Form->end() ?>
    </div>
    <!-- Panel body start -->
</div>
<!-- Panel end -->