<?php
    //pr($users->toArray()); die;
    $breadcrumb = [
        'page_heading'=>'Users',
        'small_page_heading'=>'List',
        'links'=>[
            'users'=>['icon'=>'<i class="fa fa-user"></i>','title'=>' Users'],
            'users/index'=>['icon'=>'<i class="fa fa-list"></i>','title'=>' List']
        ]
    ];
    echo $this->element('Layout/breadcrumb', $breadcrumb);
?>

<?= $this->Flash->render() ?>

<div class="row search-box-row">
    <div class="col-sm-4 col-md-4">&nbsp;</div>
    <div class="col-sm-4 col-md-4">&nbsp;</div>
    <div class="col-sm-4 col-md-4">
        <form class="navbar-form pull-right" method="get" role="search">
            <div class="input-group">
                <?= $this->Form->input('key',['div'=>false,'label'=>false,'class'=>'form-control','placeholder'=>'Search by name and email','value'=>$search_key]) ?>
                <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row page">
    <div class="col-lg-12">
        <?php if(!empty($users->toArray())): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('Roles.title','Role') ?></th>
                        <th><?= $this->Paginator->sort('Users.email','Email') ?></th>
                        <th><?= $this->Paginator->sort('name','Name') ?></th>
                        <th class="text-center"><?= $this->Paginator->sort('Statuses.title','Status') ?></th>
                        <th class="text-center"><?= $this->Paginator->sort('Users.last_login','Last Login') ?></th>
                        <th class="text-center"><?= $this->Paginator->sort('Users.created','Added On') ?></th>
                        <th><!--Action--></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): //pr($user); ?>
                <tr>
                    <td><?= h($user->role->title) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= h($user->name) ?></td>
                    <td class="text-center status-td"><?= h($user->status->title) ?></td>
                    <td class="text-center"><?= h($this->Common->dateFormat($user->last_login)) ?></td>
                    <td class="text-center"><?= h($this->Common->dateFormat($user->created)) ?></td>
                    <td class="actions text-center">
                        <div class="btn-group list-actions-dropdown">
                            <a data-target="#" href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">
                                <i class="glyphicon glyphicon-option-vertical"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <?= $this->Html->link(__('<i class="fa fa-eye"></i>&nbsp;View Deatils'), ['action' => 'view', $this->Common->encrypt($user->id)],['title'=>'View User','escape'=>false]) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link(__('<i class="fa fa-edit"></i>&nbsp;Edit User'), ['action' => 'edit', $this->Common->encrypt($user->id)],['title'=>'Edit User','escape'=>false]) ?>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-id="<?php echo $this->Common->encrypt($user->id); ?>" title="Send Reset Password Link" class="user_send_pass_link"><i class="fa fa-unlock-alt"></i>&nbsp;Send Reset Password Link</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="javascript:void(0)" <?php if($user->status_id==INACTIVE){echo 'style="display: none;"';} ?> class="user_status_action user_inactive red-text" data-id="<?= $this->Common->encrypt($user->id) ?>" title="De-Activate"><i class="fa fa-ban"></i>&nbsp;De-Activate</a>
                                    <a href="javascript:void(0)" <?php if($user->status_id==ACTIVE){echo 'style="display: none;"';} ?> class="user_status_action user_active green-text" data-id="<?= $this->Common->encrypt($user->id) ?>" title="Activate"><i class="fa fa-check-circle-o"></i>&nbsp;Activate</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?= $this->element('pagination') ?>
        <?php else: ?>
        <div class="no-details-found">
            <?php if(!empty($search_key)): ?>
            <h1>No match found.</h1>
            <?php else: ?>
            <h1>No record found.</h1>
            <?php endif; ?>
        </div><!-- no-details-found -->
        <?php endif; ?>
    </div>
</div>