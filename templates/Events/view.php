<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event $event
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Event'), ['action' => 'edit', $event->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Event'), ['action' => 'delete', $event->id], ['confirm' => __('Are you sure you want to delete # {0}?', $event->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Events'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Event'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="events view content">
            <h3><?= h($event->event_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Organizer') ?></th>
                    <td><?= $event->hasValue('organizer') ? $this->Html->link($event->organizer->name, ['controller' => 'Users', 'action' => 'view', $event->organizer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Event Name') ?></th>
                    <td><?= h($event->event_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Venue') ?></th>
                    <td><?= $event->hasValue('venue') ? $this->Html->link($event->venue->venue_name, ['controller' => 'Venues', 'action' => 'view', $event->venue->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Content Type') ?></th>
                    <td><?= h($event->content_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Scope') ?></th>
                    <td><?= h($event->scope) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($event->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status Id') ?></th>
                    <td><?= $event->status_id === null ? '' : $this->Number->format($event->status_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($event->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Time Start') ?></th>
                    <td><?= h($event->time_start) ?></td>
                </tr>
                <tr>
                    <th><?= __('Time End') ?></th>
                    <td><?= h($event->time_end) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Objectives') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($event->objectives)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Approvals') ?></h4>
                <?php if (!empty($event->approvals)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Admin Id') ?></th>
                            <th><?= __('Comments') ?></th>
                            <th><?= __('Approval Status') ?></th>
                            <th><?= __('Decision Letter') ?></th>
                            <th><?= __('Approved At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($event->approvals as $approval) : ?>
                        <tr>
                            <td><?= h($approval->id) ?></td>
                            <td><?= h($approval->admin_id) ?></td>
                            <td><?= h($approval->comments) ?></td>
                            <td><?= h($approval->approval_status) ?></td>
                            <td><?= h($approval->decision_letter) ?></td>
                            <td><?= h($approval->approved_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Approvals', 'action' => 'view', $approval->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Approvals', 'action' => 'edit', $approval->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Approvals', 'action' => 'delete', $approval->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $approval->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Documents') ?></h4>
                <?php if (!empty($event->documents)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Doc Type Id') ?></th>
                            <th><?= __('Company Info') ?></th>
                            <th><?= __('File Path') ?></th>
                            <th><?= __('Uploaded At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($event->documents as $document) : ?>
                        <tr>
                            <td><?= h($document->id) ?></td>
                            <td><?= h($document->doc_type_id) ?></td>
                            <td><?= h($document->company_info) ?></td>
                            <td><?= h($document->file_path) ?></td>
                            <td><?= h($document->uploaded_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Documents', 'action' => 'view', $document->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Documents', 'action' => 'edit', $document->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Documents', 'action' => 'delete', $document->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $document->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Guests') ?></h4>
                <?php if (!empty($event->guests)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Guest Name') ?></th>
                            <th><?= __('Designation') ?></th>
                            <th><?= __('Organization') ?></th>
                            <th><?= __('Guest Type Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($event->guests as $guest) : ?>
                        <tr>
                            <td><?= h($guest->id) ?></td>
                            <td><?= h($guest->guest_name) ?></td>
                            <td><?= h($guest->designation) ?></td>
                            <td><?= h($guest->organization) ?></td>
                            <td><?= h($guest->guest_type_id) ?></td>
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
            <div class="related">
                <h4><?= __('Related Requests') ?></h4>
                <?php if (!empty($event->requests)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Requested By') ?></th>
                            <th><?= __('Position') ?></th>
                            <th><?= __('Phone Number') ?></th>
                            <th><?= __('Submitted At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($event->requests as $request) : ?>
                        <tr>
                            <td><?= h($request->id) ?></td>
                            <td><?= h($request->requested_by) ?></td>
                            <td><?= h($request->position) ?></td>
                            <td><?= h($request->phone_number) ?></td>
                            <td><?= h($request->submitted_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Requests', 'action' => 'view', $request->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Requests', 'action' => 'edit', $request->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Requests', 'action' => 'delete', $request->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $request->id),
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