<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Approval $approval
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Approval'), ['action' => 'edit', $approval->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Approval'), ['action' => 'delete', $approval->id], ['confirm' => __('Are you sure you want to delete # {0}?', $approval->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Approvals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Approval'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="approvals view content">
            <h3><?= h($approval->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Event') ?></th>
                    <td><?= $approval->hasValue('event') ? $this->Html->link($approval->event->event_name, ['controller' => 'Events', 'action' => 'view', $approval->event->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Admin') ?></th>
                    <td><?= $approval->hasValue('admin') ? $this->Html->link($approval->admin->name, ['controller' => 'Users', 'action' => 'view', $approval->admin->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Approval Status') ?></th>
                    <td><?= h($approval->approval_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Decision Letter') ?></th>
                    <td><?= h($approval->decision_letter) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($approval->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved At') ?></th>
                    <td><?= h($approval->approved_at) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Comments') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($approval->comments)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>