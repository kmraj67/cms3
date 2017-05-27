<?php 
    $params = $this->Paginator->params();
    //pr($params); die;
    $total_records = isset($params['count'])?$params['count']:0;
    $record_limit = isset($params['perPage'])?$params['perPage']:0;
?>

<div class="row pagination-row">
    <div class="col-lg-6">
        <?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?>
    </div>
    <?php if($total_records > $record_limit): ?>
    <div class="col-lg-6">
        <div class="paginator">
            <ul class="pagination pull-right">
                <!-- <?= $this->Paginator->first(__('First')) ?> -->
                <?= $this->Paginator->prev(__('Prev')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('Next')) ?>
                <!-- <?= $this->Paginator->last(__('Last')) ?> -->
            </ul>
        </div>
    </div>
    <?php endif; ?>
</div>