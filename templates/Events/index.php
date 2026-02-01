<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Event> $events
 */
?>
<div class="events index content">
    <?= $this->Html->link(__('New Event'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Events') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('organizer_id') ?></th>
                    <th><?= $this->Paginator->sort('event_name') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('time_start') ?></th>
                    <th><?= $this->Paginator->sort('time_end') ?></th>
                    <th><?= $this->Paginator->sort('venue_id') ?></th>
                    <th><?= $this->Paginator->sort('content_type') ?></th>
                    <th><?= $this->Paginator->sort('scope') ?></th>
                    <th><?= $this->Paginator->sort('status_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= $this->Number->format($event->id) ?></td>
                    <td><?= $event->hasValue('organizer') ? $this->Html->link($event->organizer->name, ['controller' => 'Users', 'action' => 'view', $event->organizer->id]) : '' ?></td>
                    <td><?= h($event->event_name) ?></td>
                    <td><?= h($event->date) ?></td>
                    <td><?= h($event->time_start) ?></td>
                    <td><?= h($event->time_end) ?></td>
                    <td><?= $event->hasValue('venue') ? $this->Html->link($event->venue->venue_name, ['controller' => 'Venues', 'action' => 'view', $event->venue->id]) : '' ?></td>
                    <td><?= h($event->content_type) ?></td>
                    <td><?= h($event->scope) ?></td>
                    <td><?= $event->status_id === null ? '' : $this->Number->format($event->status_id) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $event->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $event->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $event->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $event->id),
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