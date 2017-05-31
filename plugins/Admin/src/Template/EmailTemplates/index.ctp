<?php
    $breadcrumb = [
        'page_heading'=>'Email Templates',
        'small_page_heading'=>'',
        'links'=>[
            'email-templates'=>['icon'=>'<i class="fa fa-envelope"></i>','title'=>'Email Templates'],
            'email-templates/index'=>['icon'=>'<i class="fa fa-list"></i>','title'=>' All Templates']
        ]
    ];
    echo $this->element('Layout/breadcrumb', $breadcrumb);
    echo $this->Flash->render();
?>

<div class="row search-box-row">
    <div class="col-sm-4 col-md-4">&nbsp;</div>
    <div class="col-sm-4 col-md-4">&nbsp;</div>
    <div class="col-sm-4 col-md-4">
        <form class="navbar-form pull-right" method="get" role="search">
            <div class="input-group">
                <?= $this->Form->input('key',['div'=>false,'label'=>false,'class'=>'form-control','placeholder'=>'Search by subject','value'=>$search_key]) ?>
                <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row page">
    <div class="col-lg-12">
        <?php if(!empty($emailTemplates->toArray())): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="30%"><?= $this->Paginator->sort('slug') ?></th>
                        <th width="30%"><?= $this->Paginator->sort('subject') ?></th>
                        <th width="15%"><?= $this->Paginator->sort('created') ?></th>
                        <th width="15%"><?= $this->Paginator->sort('modified') ?></th>
                        <th><!--Action--></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($emailTemplates as $row): //pr($row); ?>
                <tr>
                    <td><?= h($row->slug) ?></td>
                    <td><?= h($row->subject) ?></td>
                    <td class="text-center"><?= h($this->Common->dateFormat($row->created)) ?></td>
                    <td class="text-center"><?= h($this->Common->dateFormat($row->modified)) ?></td>
                    <td class="actions text-center">
                        <div class="btn-group list-actions-dropdown">
                            <a data-target="#" href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">
                                <i class="glyphicon glyphicon-option-vertical"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <?= $this->Html->link(__('<i class="fa fa-eye"></i>&nbsp;View Deatils'), ['action' => 'view', $this->Common->encrypt($row->id)],['title'=>'View Template','escape'=>false]) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link(__('<i class="fa fa-edit"></i>&nbsp;Edit Template'), ['action' => 'edit', $this->Common->encrypt($row->id)],['title'=>'Edit Template','escape'=>false]) ?>
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