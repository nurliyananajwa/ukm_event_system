<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 * @var string[]|\Cake\Collection\CollectionInterface $events
 * @var string[]|\Cake\Collection\CollectionInterface $docTypes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $document->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $document->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Documents'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="documents form content">
            <?= $this->Form->create($document) ?>
            <fieldset>
                <legend><?= __('Edit Document') ?></legend>
                <?php
                    echo $this->Form->control('event_id', ['options' => $events]);
                    echo $this->Form->control('doc_type_id', ['options' => $docTypes, 'empty' => true]);
                    echo $this->Form->control('company_info');
                    echo $this->Form->control('file_path');
                    echo $this->Form->control('uploaded_at', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
