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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $documentType->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $documentType->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Document Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="documentTypes form content">
            <?= $this->Form->create($documentType) ?>
            <fieldset>
                <legend><?= __('Edit Document Type') ?></legend>
                <?php
                    echo $this->Form->control('type_name');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
