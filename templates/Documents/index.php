<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Document> $documents
 */
?>
<div class="documents index content">
    <?= $this->Html->link(__('New Document'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Documents') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('event_id') ?></th>
                    <th><?= $this->Paginator->sort('doc_type_id') ?></th>
                    <th><?= $this->Paginator->sort('company_info') ?></th>
                    <th><?= $this->Paginator->sort('file_path') ?></th>
                    <th><?= $this->Paginator->sort('uploaded_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documents as $document): ?>
                <tr>
                    <td><?= $this->Number->format($document->id) ?></td>
                    <td><?= $document->hasValue('event') ? $this->Html->link($document->event->event_name, ['controller' => 'Events', 'action' => 'view', $document->event->id]) : '' ?></td>
                    <td><?= $document->hasValue('doc_type') ? $this->Html->link($document->doc_type->type_name, ['controller' => 'DocumentTypes', 'action' => 'view', $document->doc_type->id]) : '' ?></td>
                    <td><?= h($document->company_info) ?></td>
                    <td><?= h($document->file_path) ?></td>
                    <td><?= h($document->uploaded_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $document->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $document->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $document->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $document->id),
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