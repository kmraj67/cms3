<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= isset($page_heading)?$page_heading:'' ?> <small><?= isset($small_page_heading)?$small_page_heading:'' ?></small></h1>
        <ol class="breadcrumb">
            <?php if(isset($links['title'])): ?>
            <li class="active">
                <?= isset($links['icon'])?$links['icon']:'' ?>
                <?= isset($links['title'])?$links['title']:'' ?>
            </li>
            <?php else: ?>
            <?php $i=0; foreach($links as $key=>$val): ?>
            <?php if($i==0): ?>
            <li>
                <?= isset($val['icon'])?$val['icon']:'' ?>
                <a href="<?= $base_url ?>admin/<?= $key ?>"><?= isset($val['title'])?$val['title']:'' ?></a>
            </li>
            <?php else: ?>
            <li class="active">
                <?= isset($val['icon'])?$val['icon']:'' ?>
                <?= isset($val['title'])?$val['title']:'' ?>
            </li>
            <?php endif; ?>
            <?php $i++; endforeach; ?>
            <?php endif; ?>
        </ol>
    </div>
</div>
<!-- /.row -->