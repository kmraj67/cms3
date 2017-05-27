<?php
    $breadcrumb = [
        'page_heading'=>'Email Templates',
        'small_page_heading'=>'Edit',
        'links'=>[
            'email-templates'=>['icon'=>'<i class="fa fa-user"></i>','title'=>' Email Templates'],
            'email-templates/edit'=>['icon'=>'<i class="fa fa-edit"></i>','title'=>' Edit']
        ]
    ];
    
    echo $this->element('Layout/breadcrumb', $breadcrumb);
?>

<?= $this->Flash->render() ?>

<div class="row">
    <?= $this->element('EmailTemplates/form'); ?>
</div>