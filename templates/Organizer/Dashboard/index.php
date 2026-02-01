<?php
/**
 * Organizer Dashboard View
 */
$this->assign('title', 'Dashboard');

$userName = $identity?->get('name') ?? 'Organizer';
$totalEvents   = (int)($totalEvents ?? 0);
$pendingCount  = (int)($pendingCount ?? 0);
$approvedCount = (int)($approvedCount ?? 0);
$rejectedCount = (int)($rejectedCount ?? 0);

$recentEvents = $recentEvents ?? [];
$hasRecent = false;

if (is_object($recentEvents) && method_exists($recentEvents, 'isEmpty')) {
    $hasRecent = !$recentEvents->isEmpty();
} else {
    foreach ($recentEvents as $tmp) { $hasRecent = true; break; }
    unset($tmp);
}

$den = max(1, $totalEvents);
$p1 = (int)round(($pendingCount / $den) * 100);
$p2 = (int)round(($approvedCount / $den) * 100);
$p3 = (int)round(($rejectedCount / $den) * 100);

$announcements = [
    ['title' => 'Reminder', 'desc' => 'Upload required documents in PDF format (if applicable).'],
    ['title' => 'Approval', 'desc' => 'Approval process may take 3–5 working days depending on queue.'],
    ['title' => 'Important', 'desc' => 'Incomplete submissions may be returned for correction.'],
];
?>

<style>
:root {
    --primary: #4f46e5;
    --primary-hover: #4338ca;
    --bg-main: #f8fafc;
    --text-main: #0f172a;
    --text-muted: #64748b;
    --border-color: #e2e8f0;
}

.dash-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 24px;
    padding: 10px 0;
}

.dash-title h2 {
    margin: 0;
    font-size: 26px;
    font-weight: 700;
    color: var(--text-main);
    letter-spacing: -0.5px;
}

.dash-title p {
    margin: 4px 0 0;
    color: var(--text-muted);
    font-size: 15px;
}

.quick-links {
    display: flex;
    gap: 12px;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border-radius: 10px;
    border: 1px solid var(--border-color);
    background: #fff;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    color: #334155;
    transition: all 0.2s ease;
}

.btn:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}

.btn.primary {
    border: none;
    color: #fff;
    background: var(--primary);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
}

.btn.primary:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(79, 70, 229, 0.3);
}

/* Cards Section */
.cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 24px;
}

.card {
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 20px;
    background: #fff;
    transition: all 0.2s ease;
}

.card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 10px 20px rgba(0,0,0,0.03);
}

.card small {
    display: block;
    color: var(--text-muted);
    font-weight: 700;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
}

.card .num {
    font-size: 32px;
    font-weight: 800;
    color: var(--text-main);
    line-height: 1;
}

.card .hint {
    color: var(--text-muted);
    font-size: 13px;
    margin: 8px 0 0;
}

/* Layout Grid */
.grid2 {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
}

.panel {
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 24px;
    background: #fff;
}

.panel h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
}

.panel p.sub {
    margin: 4px 0 20px;
    color: var(--text-muted);
    font-size: 14px;
}

/* Table Styling */
table { width: 100%; border-collapse: collapse; }
th { 
    text-align: left; font-size: 12px; color: var(--text-muted); 
    padding: 12px 10px; font-weight: 700; text-transform: uppercase;
    border-bottom: 1px solid var(--border-color);
}
td { 
    padding: 16px 10px; border-bottom: 1px solid #f8fafc; 
    vertical-align: middle; font-size: 14px; color: #334155;
}
tr:last-child td { border-bottom: none; }
tr:hover td { background: #fafafa; }

/* Status Badges */
.badge { 
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 20px; 
    font-weight: 600; font-size: 12px;
}
.badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }

.b-pending { background: #eff6ff; color: #1d4ed8; }
.b-pending::before { background: #3b82f6; }

.b-approved { background: #f0fdf4; color: #15803d; }
.b-approved::before { background: #22c55e; }

.b-rejected { background: #fef2f2; color: #b91c1c; }
.b-rejected::before { background: #ef4444; }

.view-btn {
    font-weight: 600; color: var(--primary); text-decoration: none;
    padding: 6px 12px; border-radius: 8px; transition: 0.2s;
    background: #f5f3ff;
}
.view-btn:hover { background: #ede9fe; color: var(--primary-hover); }

/* Progress Bars */
.bars { display: flex; flex-direction: column; gap: 20px; }
.bar-row { display: grid; grid-template-columns: 80px 1fr 40px; gap: 15px; align-items: center; }
.bar-track { height: 8px; border-radius: 10px; background: #f1f5f9; overflow: hidden; }
.bar-fill { height: 100%; border-radius: 10px; transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
.fill-p { background: #3b82f6; }
.fill-a { background: #22c55e; }
.fill-r { background: #ef4444; }
.bar-label { color: #334155; font-weight: 600; font-size: 13px; }
.bar-pct { text-align: right; color: var(--text-muted); font-weight: 700; font-size: 12px; }

/* Announcements */
.notice {
    border: 1px solid var(--border-color);
    background: #fff;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 12px;
    transition: transform 0.2s;
}
.notice:hover { transform: scale(1.01); border-color: #cbd5e1; }
.notice b { display: block; font-size: 14px; color: var(--text-main); margin-bottom: 4px; }
.notice span { display: block; font-size: 13px; color: var(--text-muted); line-height: 1.5; }

@media (max-width: 1024px) {
    .cards { grid-template-columns: repeat(2, 1fr); }
    .grid2 { grid-template-columns: 1fr; }
    .dash-head { flex-direction: column; align-items: flex-start; }
}
</style>

<div class="dash-head">
    <div class="dash-title">
        <h2>Hi, <?= h($userName) ?> 👋</h2>
        <p>Welcome back! Here's what's happening with your events.</p>
    </div>

    <div class="quick-links">
        <?= $this->Html->link(
            'New Event',
            ['prefix' => 'Organizer', 'controller' => 'Events', 'action' => 'add'],
            ['escape' => false, 'class' => 'btn primary']
        ) ?>
        <?= $this->Html->link(
            'My Events',
            ['prefix' => 'Organizer', 'controller' => 'Events', 'action' => 'index'],
            ['class' => 'btn']
        ) ?>
    </div>
</div>

<div class="cards">
    <div class="card">
        <small>Total Events</small>
        <div class="num"><?= $totalEvents ?></div>
        <p class="hint">Lifetime submissions</p>
    </div>
    <div class="card">
        <small>Pending</small>
        <div class="num"><?= $pendingCount ?></div>
        <p class="hint">In review process</p>
    </div>
    <div class="card">
        <small>Approved</small>
        <div class="num"><?= $approvedCount ?></div>
        <p class="hint">Published events</p>
    </div>
    <div class="card">
        <small>Rejected</small>
        <div class="num"><?= $rejectedCount ?></div>
        <p class="hint">Action required</p>
    </div>
</div>

<div class="grid2">
    <div class="panel">
        <h3>Recent Submissions</h3>
        <p class="sub">Track your latest application status.</p>

        <?php if (!$hasRecent): ?>
            <div style="text-align:center; padding: 40px 20px; border: 2px dashed #e2e8f0; border-radius: 12px; color: #94a3b8;">
                No events found. Start by creating your first event.
            </div>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Date / Time</th>
                            <th>Venue</th>
                            <th>Status</th>
                            <th style="text-align:right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($recentEvents as $e): ?>
                            <?php
                                $status = (string)($e->approval?->approval_status ?? 'Pending');

                                $badgeCls = match (strtolower($status)) {
                                    'approved' => 'badge b-approved',
                                    'rejected' => 'badge b-rejected',
                                    default    => 'badge b-pending',
                                };

                                $t1 = trim((string)($e->time_start ?? ''));
                                $t2 = trim((string)($e->time_end ?? ''));
                                $timeTxt = ($t1 !== '' && $t2 !== '') ? ($t1 . ' - ' . $t2) : '-';

                                $venueName = $e->venue?->venue_name ?? '-';
                            ?>
                            <tr>
                                <td>
                                    <div style="font-weight:700; color:#1e293b;"><?= h((string)($e->event_name ?? '-')) ?></div>
                                </td>
                                <td>
                                    <div style="font-size:13px;"><?= h((string)($e->start_date ?? '-')) ?></div>
                                    <div style="font-size:12px; color:#94a3b8;"><?= h($timeTxt) ?></div>
                                </td>
                                <td><span style="font-size:13px;"><?= h((string)$venueName) ?></span></td>
                                <td><span class="<?= h($badgeCls) ?>"><?= h($status) ?></span></td>
                                <td style="text-align:right;">
                                    <?= $this->Html->link('View', [
                                        'prefix' => 'Organizer', 'controller' => 'Events', 'action' => 'view', $e->id
                                    ], ['class' => 'view-btn']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div style="display:flex; flex-direction:column; gap:24px;">
        <div class="panel">
            <h3>Status Breakdown</h3>
            <p class="sub">Approval distribution</p>

            <div class="bars">
                <div class="bar-row">
                    <div class="bar-label">Pending</div>
                    <div class="bar-track"><div class="bar-fill fill-p" style="width:<?= $totalEvents ? $p1 : 0 ?>%"></div></div>
                    <div class="bar-pct"><?= $totalEvents ? $p1 : 0 ?>%</div>
                </div>
                <div class="bar-row">
                    <div class="bar-label">Approved</div>
                    <div class="bar-track"><div class="bar-fill fill-a" style="width:<?= $totalEvents ? $p2 : 0 ?>%"></div></div>
                    <div class="bar-pct"><?= $totalEvents ? $p2 : 0 ?>%</div>
                </div>
                <div class="bar-row">
                    <div class="bar-label">Rejected</div>
                    <div class="bar-track"><div class="bar-fill fill-r" style="width:<?= $totalEvents ? $p3 : 0 ?>%"></div></div>
                    <div class="bar-pct"><?= $totalEvents ? $p3 : 0 ?>%</div>
                </div>
            </div>
        </div>

        <div class="panel" style="background: #f8fafc; border-style: dashed;">
            <h3>Announcements</h3>
            <p class="sub">From the administration</p>

            <?php foreach ($announcements as $a): ?>
                <div class="notice">
                    <b><?= h($a['title']) ?></b>
                    <span><?= h($a['desc']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>