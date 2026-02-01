<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Guest> $guests
 */
?>
<div class="guests index content">
    <?= $this->Html->link(__('New Guest'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Guests') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('event_id') ?></th>
                    <th><?= $this->Paginator->sort('guest_name') ?></th>
                    <th><?= $this->Paginator->sort('designation') ?></th>
                    <th><?= $this->Paginator->sort('organization') ?></th>
                    <th><?= $this->Paginator->sort('guest_type_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($guests as $guest): ?>
                <tr>
                    <td><?= $this->Number->format($guest->id) ?></td>
                    <td><?= $guest->hasValue('event') ? $this->Html->link($guest->event->event_name, ['controller' => 'Events', 'action' => 'view', $guest->event->id]) : '' ?></td>
                    <td><?= h($guest->guest_name) ?></td>
                    <td><?= h($guest->designation) ?></td>
                    <td><?= h($guest->organization) ?></td>
                    <td><?= $guest->hasValue('guest_type') ? $this->Html->link($guest->guest_type->type_name, ['controller' => 'GuestTypes', 'action' => 'view', $guest->guest_type->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $guest->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $guest->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $guest->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $guest->id),
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