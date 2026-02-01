<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Guest $guest
 * @var \Cake\Collection\CollectionInterface|string[] $events
 * @var \Cake\Collection\CollectionInterface|string[] $guestTypes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Guests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="guests form content">
            <?= $this->Form->create($guest) ?>
            <fieldset>
                <legend><?= __('Add Guest') ?></legend>
                <?php
                    echo $this->Form->control('event_id', ['options' => $events]);
                    echo $this->Form->control('guest_name');
                    echo $this->Form->control('designation');
                    echo $this->Form->control('organization');
                    echo $this->Form->control('guest_type_id', ['options' => $guestTypes, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
