<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Venue> $venues
 */
?>
<div class="venues index content">
    <?= $this->Html->link(__('New Venue'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Venues') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('venue_name') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('capacity') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($venues as $venue): ?>
                <tr>
                    <td><?= $this->Number->format($venue->id) ?></td>
                    <td><?= h($venue->venue_name) ?></td>
                    <td><?= h($venue->address) ?></td>
                    <td><?= h($venue->type) ?></td>
                    <td><?= $venue->capacity === null ? '' : $this->Number->format($venue->capacity) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $venue->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $venue->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $venue->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $venue->id),
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