<?php
    $breadcrumb = [
        'page_heading'=>'Email Templates',
        'small_page_heading'=>'Details',
        'links'=>[
            'email-templates'=>['icon'=>'<i class="fa fa-envelope"></i>','title'=>'Email Templates'],
            'email-templates/view'=>['icon'=>'<i class="fa fa-book"></i>','title'=>' View Details']
        ]
    ];
    echo $this->element('Layout/breadcrumb', $breadcrumb);
    echo $this->Flash->render();
?>

<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th width="30%"><?= __('Slug') ?></th>
                    <td><?= h($emailTemplate->slug) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Subject') ?></th>
                    <td><?= h($emailTemplate->slug) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td><?= h($this->Common->dateFormat($emailTemplate->created)) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Modified') ?></th>
                    <td><?= h($this->Common->dateFormat($emailTemplate->modified)) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h4><?= __('Email Content') ?></h4>
        <?= $this->Text->autoParagraph(h($emailTemplate->email_content)); ?>
    </div>
</div>
<div class="row page">
    <div class="col-lg-12">
        <?= $this->Html->link(__('Edit Template'), ['action' => 'edit', $this->Common->encrypt($emailTemplate->id)],['title'=>'Edit Template','class'=>'btn btn-primary']) ?>
    </div>
</div>