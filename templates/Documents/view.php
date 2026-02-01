<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Document'), ['action' => 'edit', $document->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Document'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Documents'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Document'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="documents view content">
            <h3><?= h($document->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Event') ?></th>
                    <td><?= $document->hasValue('event') ? $this->Html->link($document->event->event_name, ['controller' => 'Events', 'action' => 'view', $document->event->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Doc Type') ?></th>
                    <td><?= $document->hasValue('doc_type') ? $this->Html->link($document->doc_type->type_name, ['controller' => 'DocumentTypes', 'action' => 'view', $document->doc_type->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Company Info') ?></th>
                    <td><?= h($document->company_info) ?></td>
                </tr>
                <tr>
                    <th><?= __('File Path') ?></th>
                    <td><?= h($document->file_path) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($document->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Uploaded At') ?></th>
                    <td><?= h($document->uploaded_at) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>