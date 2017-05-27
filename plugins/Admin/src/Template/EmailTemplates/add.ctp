<?php
    $breadcrumb = [
        'page_heading'=>'Email Templates',
        'small_page_heading'=>'Add',
        'links'=>[
            'email-templates'=>['icon'=>'<i class="fa fa-user"></i>','title'=>' Email Templates'],
            'email-templates/add'=>['icon'=>'<i class="fa fa-plus"></i>','title'=>' Add']
        ]
    ];
    
    echo $this->element('Layout/breadcrumb', $breadcrumb);
?>

<?= $this->Flash->render() ?>

<div class="row">
    <?= $this->element('EmailTemplates/form'); ?>
</div>