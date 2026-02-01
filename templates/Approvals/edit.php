<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Approval $approval
 * @var string[]|\Cake\Collection\CollectionInterface $events
 * @var string[]|\Cake\Collection\CollectionInterface $admins
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $approval->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $approval->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Approvals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="approvals form content">
            <?= $this->Form->create($approval) ?>
            <fieldset>
                <legend><?= __('Edit Approval') ?></legend>
                <?php
                    echo $this->Form->control('event_id', ['options' => $events]);
                    echo $this->Form->control('admin_id', ['options' => $admins]);
                    echo $this->Form->control('comments');
                    echo $this->Form->control('approval_status');
                    echo $this->Form->control('decision_letter');
                    echo $this->Form->control('approved_at', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
