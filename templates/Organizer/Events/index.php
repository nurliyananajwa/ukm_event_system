<?php
/**
 * Organizer - My Events
 */
$this->assign('title', 'My Events');

$events = $events ?? [];
?>

<style>
.page-head{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:14px;
    margin-bottom:16px;
}
.page-head h2{ margin:0; font-size:22px; }
.page-head p{ margin:6px 0 0; color:#64748b; font-size:13px; }

.actions-row{ display:flex; gap:10px; flex-wrap:wrap; }

.btn2{
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    font-weight:900;
    font-size:13px;
    padding:10px 16px;
    border-radius:12px;
    border:1px solid #e5e7eb;
    background:#fff;
    color:#0f172a;
    transition:.15s;
}
.btn2:hover{ background:#f8fafc; transform:translateY(-1px); }

.btn2.primary{
    border:none;
    color:#fff;
    background:linear-gradient(135deg,#2563eb,#0ea5e9);
    box-shadow:0 12px 26px rgba(37,99,235,.18);
}

.panel{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:18px;
    padding:18px;
}

.table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 10px;
}

.table th{
    text-align:left;
    font-size:12px;
    letter-spacing:.6px;
    color:#64748b;
    padding:0 12px 6px;
}

.rowitem{
    background:#f8fafc;
    border:1px solid #e5e7eb;
}

.rowitem td{
    padding:14px 12px;
    font-size:14px;
    vertical-align:middle;
}

.rowitem td:first-child{
    border-top-left-radius:14px;
    border-bottom-left-radius:14px;
    font-weight:900;
}

.rowitem td:last-child{
    border-top-right-radius:14px;
    border-bottom-right-radius:14px;
    text-align:right;
}

.badge{
    display:inline-block;
    padding:6px 12px;
    border-radius:999px;
    font-weight:900;
    font-size:12px;
    border:1px solid #e5e7eb;
}

.b-pending{
    background:#fff7ed;
    border-color:#fed7aa;
    color:#9a3412;
}
.b-approved{
    background:#ecfdf5;
    border-color:#bbf7d0;
    color:#166534;
}
.b-rejected{
    background:#fef2f2;
    border-color:#fecaca;
    color:#991b1b;
}

.link{
    font-weight:900;
    color:#2563eb;
    text-decoration:none;
}
.link:hover{ text-decoration:underline; }

.empty{
    border:1px dashed #cbd5e1;
    background:#f8fafc;
    border-radius:16px;
    padding:26px;
    text-align:center;
    color:#64748b;
    font-size:14px;
}
</style>

<div class="page-head">
    <div>
        <h2>My Events</h2>
        <p>All event submissions created by you and their approval status.</p>
    </div>

    <div class="actions-row">
        <?= $this->Html->link(
            '+ Submit Event',
            ['prefix'=>'Organizer','controller'=>'Events','action'=>'add'],
            ['class'=>'btn2 primary']
        ) ?>
        <?= $this->Html->link(
            'Dashboard',
            ['prefix'=>'Organizer','controller'=>'Dashboard','action'=>'index'],
            ['class'=>'btn2']
        ) ?>
    </div>
</div>

<div class="panel">
<?php
$hasAny = false;
foreach ($events as $tmp) { $hasAny = true; break; }
?>

<?php if ($hasAny): ?>
<table class="table">
    <thead>
        <tr>
            <th>EVENT</th>
            <th>DATE</th>
            <th>TIME</th>
            <th>VENUE</th>
            <th>STATUS</th>
            <th style="text-align:right;">ACTION</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($events as $e): ?>
        <?php
            $status = (string)($e->approval?->approval_status ?? 'Pending');
            $badgeCls = match (strtolower($status)) {
                'approved' => 'badge b-approved',
                'rejected' => 'badge b-rejected',
                default    => 'badge b-pending',
            };

            $timeTxt = ($e->time_start && $e->time_end)
                ? h($e->time_start).' - '.h($e->time_end)
                : '-';
        ?>
        <tr class="rowitem">
            <td><?= h($e->event_name) ?></td>
            <td><?= h($e->start_date ?? '-') ?></td>
            <td><?= $timeTxt ?></td>
            <td><?= h($e->venue?->venue_name ?? '-') ?></td>
            <td><span class="<?= $badgeCls ?>"><?= h($status) ?></span></td>
            <td>
                <?= $this->Html->link(
                    'View',
                    ['prefix'=>'Organizer','controller'=>'Events','action'=>'view',$e->id],
                    ['class'=>'link']
                ) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <div class="empty">
        You haven’t submitted any events yet.<br>
        Click <b>“Submit Event”</b> to create your first application.
    </div>
<?php endif; ?>
</div>
