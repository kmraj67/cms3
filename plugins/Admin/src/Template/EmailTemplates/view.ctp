<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Email Template'), ['action' => 'edit', $emailTemplate->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Email Template'), ['action' => 'delete', $emailTemplate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailTemplate->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Email Templates'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email Template'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="emailTemplates view large-9 medium-8 columns content">
    <h3><?= h($emailTemplate->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= h($emailTemplate->slug) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subject') ?></th>
            <td><?= h($emailTemplate->subject) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($emailTemplate->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($emailTemplate->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($emailTemplate->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Email Content') ?></h4>
        <?= $this->Text->autoParagraph(h($emailTemplate->email_content)); ?>
    </div>
</div>
