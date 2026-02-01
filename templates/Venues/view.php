<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Venue $venue
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Venue'), ['action' => 'edit', $venue->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Venue'), ['action' => 'delete', $venue->id], ['confirm' => __('Are you sure you want to delete # {0}?', $venue->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Venues'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Venue'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="venues view content">
            <h3><?= h($venue->venue_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Venue Name') ?></th>
                    <td><?= h($venue->venue_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($venue->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($venue->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($venue->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Capacity') ?></th>
                    <td><?= $venue->capacity === null ? '' : $this->Number->format($venue->capacity) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Events') ?></h4>
                <?php if (!empty($venue->events)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Organizer Id') ?></th>
                            <th><?= __('Event Name') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Time Start') ?></th>
                            <th><?= __('Time End') ?></th>
                            <th><?= __('Objectives') ?></th>
                            <th><?= __('Content Type') ?></th>
                            <th><?= __('Scope') ?></th>
                            <th><?= __('Status Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($venue->events as $event) : ?>
                        <tr>
                            <td><?= h($event->id) ?></td>
                            <td><?= h($event->organizer_id) ?></td>
                            <td><?= h($event->event_name) ?></td>
                            <td><?= h($event->date) ?></td>
                            <td><?= h($event->time_start) ?></td>
                            <td><?= h($event->time_end) ?></td>
                            <td><?= h($event->objectives) ?></td>
                            <td><?= h($event->content_type) ?></td>
                            <td><?= h($event->scope) ?></td>
                            <td><?= h($event->status_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Events', 'action' => 'view', $event->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Events', 'action' => 'edit', $event->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Events', 'action' => 'delete', $event->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $event->id),
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