<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\GuestType> $guestTypes
 */
?>
<div class="guestTypes index content">
    <?= $this->Html->link(__('New Guest Type'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Guest Types') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('type_name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($guestTypes as $guestType): ?>
                <tr>
                    <td><?= $this->Number->format($guestType->id) ?></td>
                    <td><?= h($guestType->type_name) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $guestType->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $guestType->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $guestType->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $guestType->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>