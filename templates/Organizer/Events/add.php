<?php
/**
 * Organizer - Submit Event (add)
 *
 * @var \App\Model\Entity\Event $event
 * @var array $venues         [id => venue_name]
 * @var array $guestTypes     [id => type_name]
 * @var array $documentTypes  [id => type_name]
 */

$this->assign('title', 'Submit Event');

$event         = $event ?? null;
$venues        = $venues ?? [];
$guestTypes    = $guestTypes ?? [];
$documentTypes = $documentTypes ?? [];

$contentTypes = [
    'Syarahan'    => 'Lecture (Syarahan)',
    'Forum'       => 'Forum',
    'Seminar'     => 'Seminar',
    'Workshop'    => 'Workshop',
    'Conference'  => 'Conference',
    'Talk'        => 'Talk',
    'Exhibition'  => 'Exhibition',
    'Competition' => 'Competition',
];

$defaultGuests = [
    ['guest_type_id' => '', 'guest_name' => '', 'designation' => '', 'organization' => ''],
];
$defaultDocs = [
    ['doc_type_id' => '', 'company_info' => '', 'file' => null],
];
?>

<style>
.form-head{
    margin-bottom: 14px;
    display:flex;
    justify-content:space-between;
    gap:12px;
    align-items:flex-start;
}
.form-head h2{ margin:0; font-size:22px; }
.form-head p{ margin:6px 0 0; color:#64748b; font-size:13px; }

.btn2{
    display:inline-flex;
    align-items:center;
    gap:10px;
    text-decoration:none;
    font-weight:900;
    font-size:13px;
    padding:10px 14px;
    border-radius:12px;
    border:1px solid #e5e7eb;
    background:#fff;
    color:#0f172a;
    transition:.15s;
    white-space:nowrap;
    cursor:pointer;
}
.btn2:hover{ transform: translateY(-1px); background:#f8fafc; }
.btn2.primary{
    border:none; color:#fff;
    background: linear-gradient(135deg, #2563eb, #0ea5e9);
    box-shadow: 0 12px 26px rgba(37,99,235,.18);
}
.btn2.danger{
    border:1px solid #fecaca;
    color:#ef4444;
    background:#fff;
}

.card{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:16px;
    padding:18px;
    margin-bottom:14px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.04), 0 3px 6px rgba(0,0,0,0.03);
}

.section-title{
    font-size:14px;
    font-weight:950;
    letter-spacing:.6px;
    color:#0f172a;
    margin-bottom: 14px;
    border-left: 4px solid #2563eb;
    padding-left: 10px;
    text-transform: uppercase;
}

.field{ margin-bottom: 14px; }
.field label{
    display:block;
    font-size:12px;
    font-weight:900;
    color:#1e293b;
    margin-bottom:6px;
    text-transform: uppercase;
    letter-spacing:.4px;
}
.field input, .field select, .field textarea{
    width:100%;
    padding:12px;
    border-radius:12px;
    border:1px solid #cbd5e1;
    background:#f8fafc;
    font-size:14px;
    outline:none;
}
.field textarea{ min-height: 100px; resize: vertical; }

.row{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap:12px;
}
.help{ font-size:12px; color:#64748b; margin-top:6px; }

.repeat-wrap{ display:flex; flex-direction:column; gap:10px; }
.repeat-row{
    display:grid;
    grid-template-columns: 170px 1fr 1fr 1fr 110px;
    gap:10px;
    align-items:start;
    padding:12px;
    border-radius:14px;
    border:1px solid #e5e7eb;
    background:#f8fafc;
}
.repeat-row .mini input, .repeat-row .mini select{
    padding:10px;
    border-radius:12px;
}
.repeat-row .mini label{
    font-size:11px;
    letter-spacing:.3px;
    margin-bottom:5px;
    color:#475569;
}
.repeat-row .mini{ display:flex; flex-direction:column; gap:6px; }
.repeat-row .actions-col{
    display:flex;
    gap:10px;
    justify-content:flex-end;
    align-items:flex-start;
    padding-top:22px;
}

.repeat-row.doc-row{
    grid-template-columns: 220px 1fr 1.2fr 110px;
    padding: 14px;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    background: #f8fafc;
}

.repeat-row.doc-row .mini label{
    font-size: 11px;
    letter-spacing: .3px;
    margin-bottom: 6px;
    color: #475569;
    font-weight: 900;
}

.repeat-row.doc-row .mini input,
.repeat-row.doc-row .mini select{
    height: 44px;              
    padding: 10px 12px;
    border-radius: 14px;
    border: 1px solid #cbd5e1;
    background: #fff;          
}

@media (max-width: 980px){
    .repeat-row.doc-row{
        grid-template-columns: 1fr;
    }
}

.actions{
    display:flex;
    gap:10px;
    justify-content:flex-end;
    flex-wrap:wrap;
    margin-top: 10px;
}

@media (max-width: 980px){
    .row{ grid-template-columns: 1fr; }
    .form-head{ flex-direction:column; }
    .actions{ justify-content:flex-start; }
    .repeat-row{
        grid-template-columns: 1fr;
    }
    .repeat-row .actions-col{ padding-top:0; justify-content:flex-start; }
}
</style>

<div class="form-head">
    <div>
        <h2>Submit Event</h2>
        <p>Fill in the form below. You can <b>Print / Save as PDF</b> for reference after submission.</p>
    </div>

    <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <?= $this->Html->link('My Events', ['prefix'=>'Organizer','controller'=>'Events','action'=>'index'], ['class'=>'btn2']) ?>
    </div>
</div>

<?= $this->Form->create($event, ['autocomplete' => 'off', 'type' => 'file']) ?>

<div class="card">
    <div class="section-title">Event Information</div>

    <div class="field">
        <?= $this->Form->control('event_name', [
            'label' => 'Event Name',
            'required' => true,
            'placeholder' => 'Enter the full title of the event'
        ]) ?>
    </div>

    <div class="row">
        <div class="field">
            <?= $this->Form->control('start_date', [
                'label' => 'Start Date',
                'type' => 'date',
                'required' => true
            ]) ?>
        </div>
        <div class="field">
            <?= $this->Form->control('end_date', [
                'label' => 'End Date (Optional)',
                'type' => 'date'
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="field">
            <?= $this->Form->control('time_start', [
                'label' => 'Start Time',
                'type' => 'time',
                'required' => true
            ]) ?>
        </div>
        <div class="field">
            <?= $this->Form->control('time_end', [
                'label' => 'End Time',
                'type' => 'time',
                'required' => true
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="field">
            <?= $this->Form->control('content_type', [
                'label' => 'Program Type (Lecture/Forum/etc.)',
                'type' => 'select',
                'options' => $contentTypes,
                'empty' => '-- Select Type --'
            ]) ?>
        </div>

        <div class="field">
            <?= $this->Form->control('scope', [
                'label' => 'Scope / Target Audience',
                'placeholder' => 'e.g., Students, Staff, Public'
            ]) ?>
        </div>
    </div>

    <div class="field">
        <?php if (!empty($venues)): ?>
            <?= $this->Form->control('venue_id', [
                'label' => 'Venue (Choose from list)',
                'type' => 'select',
                'options' => $venues,
                'empty' => '-- Select Venue --'
            ]) ?>
        <?php endif; ?>
    </div>
</div>

<div class="card">
    <div class="section-title">Objectives & Additional Information</div>

    <div class="field">
        <?= $this->Form->control('objectives', [
            'label' => 'Objectives of the Event',
            'type' => 'textarea',
            'placeholder' => 'Describe the objectives...'
        ]) ?>
    </div>
</div>

<div class="card">
    <div class="section-title">Guests (VIP / Officiator / University Representative)</div>

    <p class="help" style="margin-top:-6px;">
        Add invited guests and select the category.</p>

    <?php if (empty($guestTypes)): ?>
        <div class="help" style="color:#ef4444; font-weight:900;">
            Guest types list is empty. Please insert guest_types first (e.g., VIP, Officiator, University Representative).
        </div>
    <?php endif; ?>

    <div class="repeat-wrap" id="guestWrap">
        <?php foreach ($defaultGuests as $i => $g): ?>
            <div class="repeat-row guest-row">
                <div class="mini">
                    <label>Guest Type</label>
                    <select name="guests[<?= (int)$i ?>][guest_type_id]">
                        <option value="">-- Select --</option>
                        <?php foreach ($guestTypes as $id => $name): ?>
                            <option value="<?= h((string)$id) ?>"
                                <?= ((string)($g['guest_type_id'] ?? '') === (string)$id) ? 'selected' : '' ?>>
                                <?= h((string)$name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mini">
                    <label>Guest Name</label>
                    <input type="text" name="guests[<?= (int)$i ?>][guest_name]" placeholder="Full name"
                           value="<?= h((string)($g['guest_name'] ?? '')) ?>">
                </div>

                <div class="mini">
                    <label>Designation</label>
                    <input type="text" name="guests[<?= (int)$i ?>][designation]" placeholder="e.g., Director / Dean"
                           value="<?= h((string)($g['designation'] ?? '')) ?>">
                </div>

                <div class="mini">
                    <label>Organization</label>
                    <input type="text" name="guests[<?= (int)$i ?>][organization]" placeholder="e.g., UKM / Company name"
                           value="<?= h((string)($g['organization'] ?? '')) ?>">
                </div>

                <div class="actions-col no-print">
                    <button type="button" class="btn2 danger" onclick="removeRow(this)">Remove</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="no-print" style="margin-top:10px;">
        <button type="button" class="btn2" onclick="addGuestRow()">+ Add Guest</button>
    </div>
</div>

<div class="card">
    <div class="section-title">Documents (Optional)</div>

    <p class="help" style="margin-top:-6px;">
        Choose document type and (optional) attach file.</p>

    <?php if (empty($documentTypes)): ?>
        <div class="help" style="color:#ef4444; font-weight:900;">
            Document types list is empty. Please insert document_types first.
        </div>
    <?php endif; ?>

    <div class="repeat-wrap" id="docWrap">
        <?php foreach ($defaultDocs as $i => $d): ?>
            <div class="repeat-row doc-row">
                <div class="mini">
                    <label>Document Type</label>
                    <select name="documents[<?= (int)$i ?>][doc_type_id]">
                        <option value="">-- Select --</option>
                        <?php foreach ($documentTypes as $id => $name): ?>
                            <option value="<?= h((string)$id) ?>"
                                <?= ((string)($d['doc_type_id'] ?? '') === (string)$id) ? 'selected' : '' ?>>
                                <?= h((string)$name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mini">
                    <label>Company / Partner Info</label>
                    <input type="text" name="documents[<?= (int)$i ?>][company_info]"
                           placeholder="Company / partner details (optional)"
                           value="<?= h((string)($d['company_info'] ?? '')) ?>">
                </div>

                <div class="mini">
                    <label>Upload File (Optional)</label>
                    <input type="file" name="documents[<?= (int)$i ?>][file]">
                </div>

                <div class="actions-col no-print">
                    <button type="button" class="btn2 danger" onclick="removeRow(this)">Remove</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="no-print" style="margin-top:10px;">
        <button type="button" class="btn2" onclick="addDocRow()">+ Add Document</button>
    </div>
</div>

<div class="card">
    <div class="section-title">Applicant / Request Information</div>

    <div class="field">
        <label>Requested By (Name)</label>
        <input type="text" name="request[requested_by]" placeholder="Full name" required>
    </div>

    <div class="row">
        <div class="field">
            <label>Position</label>
            <input type="text" name="request[position]" placeholder="e.g., Program Coordinator">
        </div>
        <div class="field">
            <label>Phone Number</label>
            <input type="text" name="request[phone_number]" placeholder="e.g., 012-3456789">
        </div>
    </div>

    <div class="actions no-print">
        <?= $this->Html->link('Cancel', ['prefix'=>'Organizer','controller'=>'Events','action'=>'index'], ['class'=>'btn2']) ?>
        <button class="btn2 primary" type="submit">Submit Event</button>
    </div>
</div>

<?= $this->Form->end() ?>

<script>
let guestIndex = <?= (int)count($defaultGuests) ?>;
let docIndex   = <?= (int)count($defaultDocs) ?>;

function removeRow(btn){
    const row = btn.closest('.repeat-row');
    if (row) row.remove();
}

function addGuestRow(){
    const wrap = document.getElementById('guestWrap');
    const div = document.createElement('div');
    div.className = 'repeat-row guest-row';

    div.innerHTML = `
        <div class="mini">
            <label>Guest Type</label>
            <select name="guests[${guestIndex}][guest_type_id]">
                <option value="">-- Select --</option>
                <?php foreach ($guestTypes as $id => $name): ?>
                    <option value="<?= h((string)$id) ?>"><?= h((string)$name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mini">
            <label>Guest Name</label>
            <input type="text" name="guests[${guestIndex}][guest_name]" placeholder="Full name">
        </div>

        <div class="mini">
            <label>Designation</label>
            <input type="text" name="guests[${guestIndex}][designation]" placeholder="e.g., Director / Dean">
        </div>

        <div class="mini">
            <label>Organization</label>
            <input type="text" name="guests[${guestIndex}][organization]" placeholder="e.g., UKM / Company name">
        </div>

        <div class="actions-col no-print">
            <button type="button" class="btn2 danger" onclick="removeRow(this)">Remove</button>
        </div>
    `;
    wrap.appendChild(div);
    guestIndex++;
}

function addDocRow(){
    
    const wrap = document.getElementById('docWrap');
    const div = document.createElement('div');
    div.className = 'repeat-row doc-row';
    div.style.gridTemplateColumns = '220px 1fr 1fr 110px';

    div.innerHTML = `
        <div class="mini">
            <label>Document Type</label>
            <select name="documents[${docIndex}][doc_type_id]">
                <option value="">-- Select --</option>
                <?php foreach ($documentTypes as $id => $name): ?>
                    <option value="<?= h((string)$id) ?>"><?= h((string)$name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mini">
            <label>Company / Partner Info</label>
            <input type="text" name="documents[${docIndex}][company_info]" placeholder="Company / partner details (optional)">
        </div>

        <div class="mini">
            <label>Upload File (Optional)</label>
            <input type="file" name="documents[${docIndex}][file]">
        </div>

        <div class="actions-col no-print">
            <button type="button" class="btn2 danger" onclick="removeRow(this)">Remove</button>
        </div>
    `;
    wrap.appendChild(div);
    docIndex++;
}

    document.addEventListener('submit', function(e){
    const btn = e.target.querySelector('button[type="submit"]');
    if(btn){
        btn.disabled = true;
        btn.innerText = 'Saving...';
    }
    }, true);

</script>
