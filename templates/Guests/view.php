<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Guest $guest
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Guest'), ['action' => 'edit', $guest->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Guest'), ['action' => 'delete', $guest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $guest->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Guests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Guest'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="guests view content">
            <h3><?= h($guest->guest_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Event') ?></th>
                    <td><?= $guest->hasValue('event') ? $this->Html->link($guest->event->event_name, ['controller' => 'Events', 'action' => 'view', $guest->event->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Guest Name') ?></th>
                    <td><?= h($guest->guest_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Designation') ?></th>
                    <td><?= h($guest->designation) ?></td>
                </tr>
                <tr>
                    <th><?= __('Organization') ?></th>
                    <td><?= h($guest->organization) ?></td>
                </tr>
                <tr>
                    <th><?= __('Guest Type') ?></th>
                    <td><?= $guest->hasValue('guest_type') ? $this->Html->link($guest->guest_type->type_name, ['controller' => 'GuestTypes', 'action' => 'view', $guest->guest_type->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($guest->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>