<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event $event
 * @var \Cake\Collection\CollectionInterface|string[] $organizers
 * @var \Cake\Collection\CollectionInterface|string[] $venues
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Events'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="events form content">
            <?= $this->Form->create($event) ?>
            <fieldset>
                <legend><?= __('Add Event') ?></legend>
                <?php
                    echo $this->Form->control('organizer_id', ['options' => $organizers]);
                    echo $this->Form->control('event_name');
                    echo $this->Form->control('date');
                    echo $this->Form->control('time_start');
                    echo $this->Form->control('time_end');
                    echo $this->Form->control('venue_id', ['options' => $venues, 'empty' => true]);
                    echo $this->Form->control('objectives');
                    echo $this->Form->control('content_type');
                    echo $this->Form->control('scope');
                    echo $this->Form->control('status_id');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
