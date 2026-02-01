<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentType $documentType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Document Type'), ['action' => 'edit', $documentType->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Document Type'), ['action' => 'delete', $documentType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentType->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Document Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Document Type'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="documentTypes view content">
            <h3><?= h($documentType->type_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Type Name') ?></th>
                    <td><?= h($documentType->type_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($documentType->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>