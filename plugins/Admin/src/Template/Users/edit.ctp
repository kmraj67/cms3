<?php
    $breadcrumb = [
        'page_heading'=>'User',
        'small_page_heading'=>'Edit',
        'links'=>[
            'users'=>['icon'=>'<i class="fa fa-user"></i>','title'=>' Users'],
            'users/add'=>['icon'=>'<i class="fa fa-edit"></i>','title'=>' Edit']
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