<?php
    $breadcrumb = [
        'page_heading'=>'Settings',
        'small_page_heading'=>'All Site Constants',
        'links'=>['icon'=>'<i class="fa fa-gear"></i>','title'=>'Settings']
    ];    
    echo $this->element('Layout/breadcrumb', $breadcrumb);
    echo $this->Flash->render();
?>

<div class="row search-box-row">
    <div class="col-sm-4 col-md-4">
        <button class="btn btn-primary" id="change_password_link" type="button">
            <i class="glyphicon glyphicon-lock"></i>&nbsp;Change Password
        </button>
        <button class="btn btn-primary" id="add_new_setting" type="button">
            <i class="glyphicon glyphicon-plus"></i>&nbsp;Add Setting
        </button>
    </div>
    <div class="col-sm-4 col-md-4">&nbsp;</div>
    <div class="col-sm-4 col-md-4">
        <form class="navbar-form pull-right" method="get" role="search">
            <div class="input-group">
                <?= $this->Form->input('key',['div'=>false,'label'=>false,'class'=>'form-control','placeholder'=>'Search by key & value','value'=>$search_key]) ?>
                <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row page">
    <div class="col-lg-12">
        <?php if(!empty($settings->toArray())): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="30%"><?= $this->Paginator->sort('key_field','Key') ?></th>
                        <th><?= $this->Paginator->sort('key_value','Value') ?></th>
                        <th width="15%"><?= $this->Paginator->sort('created') ?></th>
                        <th width="15%"><?= $this->Paginator->sort('modified') ?></th>
                        <th width="5%"><!--Action--></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($settings as $row): ?>
                    <tr>
                        <td><?= h($row->key_field) ?></td>
                        <td><?= h($row->key_value) ?></td>
                        <td><?= h($this->Common->dateFormat($row->created)) ?></td>
                        <td><?= h($this->Common->dateFormat($row->modified)) ?></td>
                        <td class="text-center">
                            <a href="javascript:void(0);" class="edit_site_setting" title="Edit Setting" data-id="<?= $this->Common->encrypt($row->id) ?>"><i class="fa fa-edit"></i></a>
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