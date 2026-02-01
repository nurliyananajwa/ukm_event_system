<?php
$identity = $this->request->getAttribute('identity');
$userName = $identity?->name ?? 'Admin';
$initial  = strtoupper(mb_substr(trim((string)$userName), 0, 1));

$currentController = strtolower((string)$this->request->getParam('controller'));
$currentAction     = strtolower((string)$this->request->getParam('action'));

$activeDash      = ($currentController === 'dashboard') ? 'active' : '';
$activeApprovals = ($currentController === 'approvals') ? 'active' : '';
$activeVenues    = ($currentController === 'venues') ? 'active' : '';
$activeUsers     = ($currentController === 'users') ? 'active' : '';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($this->fetch('title') ?: 'Admin Panel') ?></title>

    <style>
        *{ box-sizing:border-box; font-family:"Segoe UI",system-ui,Arial,sans-serif; }
        body{ margin:0; background:#f8fafc; color:#0f172a; }
        :root{
            --text: #0f172a;
            --muted: #94a3b8;
            --muted2:#64748b;
            --line: #e5e7eb;

            --sb-bg:#0f172a;
            --sb-line:#1e293b;

            --brand:#2563eb;

            --radius-lg:18px;
            --radius-md:14px;
            --radius-sm:12px;

            --fs-xxs:11px;
            --fs-xs:12px;
            --fs-sm:13px;
            --fs-md:14px;

            --fw-reg:600;
            --fw-semi:700;
            --fw-bold:800;
            --fw-black:900;
        }
        .app{ display:grid; grid-template-columns: 300px 1fr; min-height:100vh; }
        .sidebar{
            background:var(--sb-bg);
            border-right:1px solid var(--sb-line);
            padding:18px;
            display:flex;
            flex-direction:column;
            gap:14px;
        }
        .brand{
            display:flex;
            align-items:center;
            gap:12px;
            padding: 6px 6px;
            margin-bottom: 18px;
        }
        .brand b{ display:block; font-size:13px; font-weight:var(--fw-bold); color:#fff; letter-spacing:.2px; }
        .brand span{ display:block; font-size:var(--fs-xs); color:var(--muted); margin-top:2px; }
        .brand .mark{
            width:40px;height:40px; border-radius:14px; display:grid; place-items:center;
            background:#fff; border:1px solid rgba(255,255,255,0.10);
        }

        .sidebar{
            padding: 28px 18px;
        }

        .side-profile{
            display:flex;
            align-items:center;
            gap:12px;
            padding: 12px;
            border-radius: 16px;
            border:1px solid #1e293b;
            background: rgba(255,255,255,0.05);
            margin-bottom: 8px;
        }
        .avatar{
            width:50px;height:50px; border-radius:18px;
            display:grid; place-items:center;
            font-weight:var(--fw-black);
            background:#1e293b; border:1px solid #334155; color:#fff;
            font-size:15px;
        }
        .side-profile .name{
            font-weight:var(--fw-bold);
            color:#fff;
            font-size:var(--fs-sm);
            line-height:1.2;
        }
        .side-profile .role{
            font-size:var(--fs-xs);
            color:var(--muted);
            margin-top:3px;
        }

        .section{
            margin: 6px 6px 0;
            font-size: var(--fs-xxs);
            font-weight:var(--fw-black);
            letter-spacing:.8px;
            color:#475569;
        }

        .nav{ display:flex; flex-direction:column; gap:10px; padding:4px; }
        .nav a{
            display:flex; align-items:center; gap:12px;
            padding: 11px 12px;
            border-radius: var(--radius-md);
            text-decoration:none;
            color:#cbd5e1;
            font-weight: var(--fw-semi);
            font-size: var(--fs-sm);
            border:1px solid transparent;
            transition: .15s ease;
        }
        .nav a:hover{
            background:rgba(255,255,255,0.06);
            color:#fff;
        }
        .nav a.active{
            background: var(--brand);
            color:#fff;
            box-shadow: 0 12px 26px rgba(37,99,235,.18);
        }

        .ico{
            width:38px;height:38px;
            border-radius: 14px;
            display:grid; place-items:center;
            background:rgba(255,255,255,0.05);
            border:1px solid rgba(255,255,255,0.10);
        }
        .svg{ width:18px; height:18px; }

        .spacer{ flex:1; }

        .logout-link{
            display:flex; align-items:center; gap:12px;
            padding: 11px 12px;
            border-radius: var(--radius-md);
            text-decoration:none;
            font-weight: var(--fw-bold);
            font-size: var(--fs-sm);
            border:1px solid rgba(239,68,68,0.35);
            color:#fecaca;
            background: rgba(239,68,68,0.08);
            transition:.15s ease;
        }
        .logout-link .ico{
            background: rgba(239,68,68,0.10);
            border:1px solid rgba(239,68,68,0.25);
        }
        .logout-link:hover{
            background: rgba(239,68,68,0.16);
            color:#fff;
        }

        /* ===== MAIN ===== */
        .main{ display:flex; flex-direction:column; }

        .topbar{
            background:#fff;
            border-bottom: 1px solid var(--line);
            padding: 12px 22px; /* kecil sikit */
            display:flex;
            align-items:center;
            justify-content:space-between;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .search{
            display:flex; align-items:center; gap:10px;
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            border:1px solid var(--line);
            background:#f8fafc;
            width: 100%;
            max-width: 520px;
        }
        .search input{
            width:100%;
            border:none; outline:none;
            background:transparent;
            font-size: var(--fs-sm);
            font-weight: var(--fw-reg);
            color: var(--text);
        }

        .content-area{
            padding: 18px;
            display:flex;
            flex-direction:column;
            gap:14px;
        }

        .content{
            background:#fff;
            border:1px solid var(--line);
            border-radius: var(--radius-lg);
            padding:18px;
            min-height:520px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        /* ===== FLASH (with close X) ===== */
        .flash-wrap{ display:flex; flex-direction:column; gap:10px; }
        .flash-wrap .message{
            position:relative;
            padding:12px 42px 12px 16px;
            border-radius: 12px;
            font-size: var(--fs-sm);
            font-weight: var(--fw-semi);
            border:1px solid var(--line);
        }
        .flash-wrap .success{
            background:#dcfce7;
            border-color:#86efac;
            color:#166534;
        }
        .flash-wrap .error{
            background:#fee2e2;
            border-color:#fecaca;
            color:#991b1b;
        }
        .flash-wrap .info{
            background:#e0f2fe;
            border-color:#7dd3fc;
            color:#075985;
        }

        .flash-close{
            position:absolute;
            right:10px;
            top:10px;
            width:26px;
            height:26px;
            border-radius:10px;
            border:1px solid rgba(15,23,42,0.10);
            background: rgba(255,255,255,0.65);
            cursor:pointer;
            display:grid;
            place-items:center;
            transition:.12s ease;
        }
        .flash-close:hover{ transform: translateY(-1px); background:#fff; }
        .flash-close svg{ width:14px; height:14px; }

        @media (max-width: 980px){
            .app{ grid-template-columns: 1fr; }
            .sidebar{ border-right:none; border-bottom:1px solid var(--sb-line); }
            .topbar{ position:relative; }
            .search{ max-width: 100%; }
        }
    </style>
</head>

<body>
<div class="app">

    <aside class="sidebar">
        <div class="brand">
            <div class="mark">
                <svg class="svg" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="8" stroke="#2563eb" stroke-width="3"/>
                    <circle cx="12" cy="12" r="2.5" fill="#2563eb"/>
                </svg>
            </div>
            <div>
                <b>UKM Event System</b>
                <span>Admin Panel</span>
            </div>
        </div>

        <div class="side-profile">
            <div class="avatar"><?= h($initial) ?></div>
            <div>
                <div class="name"><?= h($userName) ?></div>
                <div class="role">Admin</div>
            </div>
        </div>

        <!-- ===== OVERVIEW ===== -->
        <div class="section">OVERVIEW</div>
        <nav class="nav">
            <?= $this->Html->link(
                '<div class="ico">
                    <svg class="svg" viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="3" width="8" height="8" rx="2" stroke="#ffffff" stroke-width="2"/>
                        <rect x="13" y="3" width="8" height="8" rx="2" stroke="#ffffff" stroke-width="2"/>
                        <rect x="3" y="13" width="8" height="8" rx="2" stroke="#ffffff" stroke-width="2"/>
                        <rect x="13" y="13" width="8" height="8" rx="2" stroke="#ffffff" stroke-width="2"/>
                    </svg>
                </div>Dashboard',
                ['prefix'=>'Admin','controller'=>'Dashboard','action'=>'index'],
                ['escape'=>false, 'class'=>$activeDash]
            ) ?>
        </nav>

        <div class="section">APPROVALS</div>
        <nav class="nav">
            <?= $this->Html->link(
                '<div class="ico">
                    <svg class="svg" viewBox="0 0 24 24" fill="none">
                        <rect x="4" y="4" width="16" height="16" rx="3" stroke="#ffffff" stroke-width="2"/>
                        <path d="M7 8h10M7 12h10M7 16h7" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>Event Approvals',
                ['prefix'=>'Admin','controller'=>'Approvals','action'=>'index'],
                ['escape'=>false, 'class'=>$activeApprovals]
            ) ?>
        </nav>

        <div class="section">MANAGEMENT</div>
        <nav class="nav">
            <?= $this->Html->link(
                '<div class="ico">
                    <svg class="svg" viewBox="0 0 24 24" fill="none">
                        <rect x="4" y="4" width="16" height="16" rx="3" stroke="#ffffff" stroke-width="2"/>
                        <path d="M8 10h8M8 14h8" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>Venues',
                ['prefix'=>'Admin','controller'=>'Venues','action'=>'index'],
                ['escape'=>false, 'class'=>$activeVenues]
            ) ?>

            <?= $this->Html->link(
                '<div class="ico">
                    <svg class="svg" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="8" r="3.5" stroke="#ffffff" stroke-width="2"/>
                        <path d="M4 20c1.5-4 14.5-4 16 0" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>Users',
                ['prefix'=>'Admin','controller'=>'Users','action'=>'index'],
                ['escape'=>false, 'class'=>$activeUsers]
            ) ?>
        </nav>

        <div class="spacer"></div>

        <div class="section">ACCOUNT</div>
        <?= $this->Html->link(
            '<div class="ico">
                <svg class="svg" viewBox="0 0 24 24" fill="none">
                    <path d="M10 7V5a2 2 0 0 1 2-2h7v18h-7a2 2 0 0 1-2-2v-2" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                    <path d="M3 12h10" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                    <path d="M6 9l-3 3 3 3" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>Logout',
            ['prefix'=>false,'controller'=>'Users','action'=>'logout'],
            ['escape'=>false, 'class'=>'logout-link']
        ) ?>
    </aside>

    <main class="main">
        <div class="topbar">
            <form class="search" method="get"
                  action="<?= $this->Url->build(['prefix'=>'Admin','controller'=>'Approvals','action'=>'index']) ?>">
                <svg class="svg" viewBox="0 0 24 24" fill="none">
                    <circle cx="11" cy="11" r="7" stroke="#64748b" stroke-width="2"/>
                    <path d="M20 20l-3.5-3.5" stroke="#64748b" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <input type="text" name="q" placeholder="Search events / organizer / venue..."
                       value="<?= h((string)$this->request->getQuery('q')) ?>">
            </form>
            <div style="width:1px;"></div>
        </div>

        <div class="content-area">

            <div class="flash-wrap" id="flashWrap">
                <?= $this->Flash->render() ?>
            </div>

            <div class="content">
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </main>

</div>

<script>
(function(){
    const wrap = document.getElementById('flashWrap');
    if(!wrap) return;

    const msgs = wrap.querySelectorAll('.message');
    msgs.forEach(m => {
        if (m.querySelector('.flash-close')) return;

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'flash-close';
        btn.setAttribute('aria-label','Close');
        btn.innerHTML = `
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M7 7l10 10M17 7L7 17" stroke="#0f172a" stroke-width="2" stroke-linecap="round"/>
            </svg>
        `;
        btn.addEventListener('click', () => {
            m.style.transition = 'opacity .15s ease, transform .15s ease';
            m.style.opacity = '0';
            m.style.transform = 'translateY(-2px)';
            setTimeout(() => m.remove(), 160);
        });

        m.appendChild(btn);
    });
})();
</script>
</body>
</html>
