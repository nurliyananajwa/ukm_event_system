<?php
$this->assign('title', 'Dashboard');

$identity = $this->request->getAttribute('identity');
$userName = $identity?->get('name') ?? 'Admin';

$totalEvents     = (int)($totalEvents ?? 0);
$pendingCount    = (int)($pendingCount ?? 0);
$approvedCount   = (int)($approvedCount ?? 0);
$rejectedCount   = (int)($rejectedCount ?? 0);
$totalOrganizers = (int)($totalOrganizers ?? 0);
$totalVenues     = (int)($totalVenues ?? 0);


$latestPending = $latestPending ?? [];
$hasAny = false;
foreach ($latestPending as $tmp) { $hasAny = true; break; }
unset($tmp);
?>

<style>
.dash-head{ display:flex; align-items:flex-start; justify-content:space-between; gap:14px; margin-bottom:14px; }
.dash-head h2{ margin:0; font-size:22px; font-weight:750; letter-spacing:.2px; }
.dash-head p{ margin:6px 0 0; color:#64748b; font-size:13px; }

.cards{ display:grid; grid-template-columns:repeat(3, minmax(0,1fr)); gap:14px; margin-top:12px; }
.card{
    border:1px solid #e5e7eb; border-radius:16px; padding:16px; background:#fff;
    box-shadow:0 6px 16px rgba(15,23,42,0.05);
}
.card small{ display:block; color:#64748b; font-weight:650; letter-spacing:.5px; font-size:11px; }
.card .num{ margin-top:8px; font-size:30px; font-weight:780; color:#0f172a; }
.card .hint{ margin:6px 0 0; color:#64748b; font-size:13px; }

.panel{
    margin-top:14px;
    border:1px solid #e5e7eb; border-radius:16px; padding:16px; background:#fff;
    box-shadow:0 6px 16px rgba(15,23,42,0.05);
}
.panel h3{ margin:0; font-size:16px; font-weight:760; }
.panel p.sub{ margin:6px 0 12px; color:#64748b; font-size:13px; }

.table{ width:100%; border-collapse:separate; border-spacing:0 10px; }
.table th{ text-align:left; font-size:12px; letter-spacing:.45px; color:#64748b; padding:0 10px 6px; font-weight:650; }
.rowitem{ background:#f8fafc; border:1px solid #e5e7eb; }
.rowitem td{ padding:14px 12px; font-size:14px; vertical-align:middle; color:#0f172a; }
.rowitem td:first-child{ border-top-left-radius:14px; border-bottom-left-radius:14px; }
.rowitem td:last-child{ border-top-right-radius:14px; border-bottom-right-radius:14px; text-align:right; }

.badge{ display:inline-block; padding:6px 10px; border-radius:999px; font-weight:700; font-size:12px; border:1px solid #e5e7eb; background:#fff; color:#0f172a; }
.b-pending{ background:#fff7ed; border-color:#fed7aa; color:#9a3412; }
.b-approved{ background:#ecfdf5; border-color:#bbf7d0; color:#166534; }
.b-rejected{ background:#fef2f2; border-color:#fecaca; color:#991b1b; }

.link{ font-weight:700; color:#2563eb; text-decoration:none; }
.link:hover{ text-decoration:underline; }

.empty{
    border:1px dashed #cbd5e1; background: linear-gradient(#ffffff, #f8fafc);
    border-radius:16px; padding:24px; color:#64748b; font-size:14px; text-align:center;
}

.quick-panel{
    margin-top:14px;
    border:1px solid #e5e7eb;
    border-radius:16px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 6px 16px rgba(15,23,42,0.05);
}
.quick-head{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
    padding:14px 16px;
    background: linear-gradient(180deg, #f8fafc, #ffffff);
    border-bottom:1px solid #eef2f7;
}
.quick-head .t{
    display:flex;
    flex-direction:column;
    gap:4px;
}
.quick-head h3{ margin:0; font-size:16px; font-weight:760; }
.quick-head p{ margin:0; color:#64748b; font-size:13px; }

.quick-grid{
    display:grid;
    grid-template-columns:repeat(4, minmax(0,1fr));
    gap:12px;
    padding:14px 16px 16px;
    background:#fff;
}

.qbtn{
    display:flex;
    align-items:flex-start;
    gap:12px;
    padding:14px 14px;
    border-radius:14px;
    text-decoration:none;
    border:1px solid #e5e7eb;
    background:#ffffff;
    transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease, background .15s ease;
    position:relative;
    overflow:hidden;
}
.qbtn:before{
    content:"";
    position:absolute;
    left:0; top:0; bottom:0;
    width:4px;
    background:#2563eb;
    opacity:.85;
}
.qbtn:hover{
    transform: translateY(-2px);
    border-color:#cbd5e1;
    box-shadow:0 10px 22px rgba(15,23,42,0.08);
    background:#f8fafc;
}
.qico{
    width:38px;
    height:38px;
    border-radius:14px;
    display:grid;
    place-items:center;
    border:1px solid #e5e7eb;
    background:#f8fafc;
    flex:0 0 auto;
}
.qico svg{ width:18px; height:18px; }
.qtxt{ display:flex; flex-direction:column; gap:4px; min-width:0; }
.qtxt b{ font-size:14px; color:#0f172a; font-weight:750; line-height:1.15; }
.qtxt span{ font-size:12px; color:#64748b; line-height:1.35; }

.qbtn.v2:before{ background:#16a34a; }
.qbtn.v3:before{ background:#f59e0b; }
.qbtn.v4:before{ background:#7c3aed; }

@media (max-width:980px){
    .cards{ grid-template-columns:1fr; }
    .dash-head{ flex-direction:column; }
    .quick-grid{ grid-template-columns:1fr 1fr; }
}
@media (max-width:560px){
    .quick-grid{ grid-template-columns:1fr; }
}
</style>

<div class="dash-head">
    <div>
        <h2>Hi, <?= h($userName) ?> 👋</h2>
        <p>Overview of events, approvals, and system records.</p>
    </div>
</div>

<div class="cards">
    <div class="card">
        <small>TOTAL EVENTS</small>
        <div class="num"><?= $totalEvents ?></div>
        <p class="hint">All submissions in the system</p>
    </div>

    <div class="card">
        <small>PENDING APPROVALS</small>
        <div class="num"><?= $pendingCount ?></div>
        <p class="hint">Need review</p>
    </div>

    <div class="card">
        <small>APPROVED</small>
        <div class="num"><?= $approvedCount ?></div>
        <p class="hint">Events approved</p>
    </div>

    <div class="card">
        <small>REJECTED</small>
        <div class="num"><?= $rejectedCount ?></div>
        <p class="hint">Returned</p>
    </div>

    <div class="card">
        <small>TOTAL ORGANIZERS</small>
        <div class="num"><?= $totalOrganizers ?></div>
        <p class="hint">User total</p>
    </div>

    <div class="card">
        <small>TOTAL VENUES</small>
        <div class="num"><?= $totalVenues ?></div>
        <p class="hint">Venue records available</p>
    </div>
</div>

<div class="quick-panel">
    <div class="quick-head">
        <div class="t">
            <h3>Quick Actions</h3>
        </div>
    </div>

    <div class="quick-grid">
        <?= $this->Html->link(
            '<div class="qico">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M4 6h16M4 12h16M4 18h10" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="qtxt"><b>Review Approvals</b><span>Review Event</span></div>',
            ['prefix'=>'Admin','controller'=>'Approvals','action'=>'index'],
            ['escape'=>false,'class'=>'qbtn v1']
        ) ?>

        <?= $this->Html->link(
            '<div class="qico">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M4 7h16M7 4v16M4 17h16" stroke="#16a34a" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="qtxt"><b>Manage Venues</b><span>Add or Update venue list</span></div>',
            ['prefix'=>'Admin','controller'=>'Venues','action'=>'index'],
            ['escape'=>false,'class'=>'qbtn v2']
        ) ?>

        <?= $this->Html->link(
            '<div class="qico">
                <svg viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="8" r="3.5" stroke="#f59e0b" stroke-width="2"/>
                    <path d="M4 20c1.5-4 14.5-4 16 0" stroke="#f59e0b" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="qtxt"><b>Manage Users</b><span>All user list</span></div>',
            ['prefix'=>'Admin','controller'=>'Users','action'=>'index'],
            ['escape'=>false,'class'=>'qbtn v3']
        ) ?>

        <?= $this->Html->link(
            '<div class="qico">
                <svg viewBox="0 0 24 24" fill="none">
                    <rect x="5" y="4" width="14" height="16" rx="2" stroke="#7c3aed" stroke-width="2"/>
                    <path d="M8 8h8M8 12h8M8 16h5" stroke="#7c3aed" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="qtxt"><b>All Events</b><span>See all events</span></div>',
            ['prefix'=>'Admin','controller'=>'Approvals','action'=>'index','?'=>['status'=>'All']],
            ['escape'=>false,'class'=>'qbtn v4']
        ) ?>
    </div>
</div>

<div class="panel">
    <h3>Latest Submissions</h3>
    <p class="sub">Quick list for admin to open and review.</p>

    <?php if (!$hasAny): ?>
        <div class="empty">No events found yet.</div>
    <?php else: ?>
        <table class="table">
            <thead>
            <tr>
                <th>EVENT</th>
                <th>DATE</th>
                <th>TIME</th>
                <th>VENUE</th>
                <th>ORGANIZER</th>
                <th>STATUS</th>
                <th style="text-align:right;">ACTION</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($latestPending as $e): ?>
                <?php
                    $st = 'Pending';
                    if (isset($e->approval) && $e->approval) {
                        $st = (string)($e->approval->approval_status ?? 'Pending');
                    } elseif (!empty($e->approvals) && isset($e->approvals[0])) {
                        $st = (string)($e->approvals[0]->approval_status ?? 'Pending');
                    }

                    $low = strtolower($st);
                    $badgeCls = 'badge ';
                    if ($low === 'approved') $badgeCls .= 'b-approved';
                    elseif ($low === 'rejected') $badgeCls .= 'b-rejected';
                    else $badgeCls .= 'b-pending';

                    $timeTxt = ((string)($e->time_start ?? '') !== '' && (string)($e->time_end ?? '') !== '')
                        ? h((string)$e->time_start) . ' - ' . h((string)$e->time_end)
                        : '-';
                ?>
                <tr class="rowitem">
                    <td><?= h((string)($e->event_name ?? '-')) ?></td>
                    <td><?= h((string)($e->start_date ?? '-')) ?></td>
                    <td><?= $timeTxt ?></td>
                    <td><?= h((string)($e->venue?->venue_name ?? '-')) ?></td>
                    <td><?= h((string)($e->organizer?->name ?? '-')) ?></td>
                    <td><span class="<?= $badgeCls ?>"><?= h($st) ?></span></td>
                    <td>
                        <?= $this->Html->link(
                            'Open',
                            ['prefix'=>'Admin','controller'=>'Approvals','action'=>'view', $e->id],
                            ['class'=>'link']
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
