<?php
    $breadcrumb = [
        'page_heading'=>'User',
        'small_page_heading'=>'Details',
        'links'=>[
            'users'=>['icon'=>'<i class="fa fa-user"></i>','title'=>' Users'],
            'users/index'=>['icon'=>'<i class="fa fa-book"></i>','title'=>' Details']
        ]
    ];
    echo $this->element('Layout/breadcrumb', $breadcrumb);
?>

<?= $this->Flash->render() ?>

<div class="row page">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th width="30%"><?= __('Role') ?></th>
                    <td><?= h($user->role->title) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('First Name') ?></th>
                    <td><?= h($user->first_name) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Last Name') ?></th>
                    <td><?= h($user->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Status') ?></th>
                    <td><?= h($user->status->title) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Last Login') ?></th>
                    <td><?= h($this->Common->dateFormat($user->last_login,'M j, Y h:i A')) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td><?= h($this->Common->dateFormat($user->created)) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Modified') ?></th>
                    <td><?= h($this->Common->dateFormat($user->modified)) ?></td>
                </tr>
            </table>
        </div>
        
        <div>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $this->Common->encrypt($user->id)],['title'=>'Edit User','class'=>'btn btn-primary']) ?>
        </div>
    </div>
</div>