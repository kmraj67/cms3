<?php
    $breadcrumb = [
        'page_heading'=>'User',
        'small_page_heading'=>'Add',
        'links'=>[
            'users'=>['icon'=>'<i class="fa fa-user"></i>','title'=>' Users'],
            'users/add'=>['icon'=>'<i class="fa fa-plus"></i>','title'=>' Add']
        ]
    ];
    
    echo $this->element('Layout/breadcrumb', $breadcrumb);
?>

<?= $this->Flash->render() ?>

<div class="row">
    <div class="col-lg-6">
        <?= $this->element('Users/form'); ?>
    </div>
</div>