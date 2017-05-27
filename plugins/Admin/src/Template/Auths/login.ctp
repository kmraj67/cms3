<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Admin Login</h3>
    </div>
    
    <!-- Panel body start -->
    <div class="panel-body">
        <?= $this->Form->create($user,['id'=>'admin_login_form','class'=>'form-horizontal','novalidate'=>true]) ?>
            <div class="form-group">
                <div class="col-sm-12">
                    <?= $this->Form->input('email',['class'=>'form-control','placeholder'=>'Email','label'=>false]) ?>
                    <span class="text-danger"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <?= $this->Form->input('password',['class'=>'form-control','placeholder'=>'Password','label'=>false]) ?>
                    <span class="text-danger"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="submit" value="Login" class="btn btn-primary btn-block">
                </div>                    
            </div>
            <div class="forgot-password pull-right">
                <a href="<?php echo $base_url ?>admin/forgot-password" class="forgot-link">Forgot Password</a>
            </div>
        <?= $this->Form->end() ?>
    </div>
    <!-- Panel body start -->
</div>
<!-- Panel end -->