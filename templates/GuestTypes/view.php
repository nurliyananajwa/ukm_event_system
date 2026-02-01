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
            <?= $this->Html->link(__('Edit Guest Type'), ['action' => 'edit', $guestType->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Guest Type'), ['action' => 'delete', $guestType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $guestType->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Guest Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Guest Type'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="guestTypes view content">
            <h3><?= h($guestType->type_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Type Name') ?></th>
                    <td><?= h($guestType->type_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($guestType->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Guests') ?></h4>
                <?php if (!empty($guestType->guests)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Event Id') ?></th>
                            <th><?= __('Guest Name') ?></th>
                            <th><?= __('Designation') ?></th>
                            <th><?= __('Organization') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($guestType->guests as $guest) : ?>
                        <tr>
                            <td><?= h($guest->id) ?></td>
                            <td><?= h($guest->event_id) ?></td>
                            <td><?= h($guest->guest_name) ?></td>
                            <td><?= h($guest->designation) ?></td>
                            <td><?= h($guest->organization) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Guests', 'action' => 'view', $guest->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Guests', 'action' => 'edit', $guest->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Guests', 'action' => 'delete', $guest->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $guest->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>