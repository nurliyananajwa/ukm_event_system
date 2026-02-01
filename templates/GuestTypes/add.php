<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GuestType $guestType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Guest Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="guestTypes form content">
            <?= $this->Form->create($guestType) ?>
            <fieldset>
                <legend><?= __('Add Guest Type') ?></legend>
                <?php
                    echo $this->Form->control('type_name');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
