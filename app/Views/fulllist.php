<?= $this->extend('emu') . $this->section('content') ?>
<div class="container py-4">
    <form></form>
        <h1 class="h4 font-montserrat">All Checklists</h1>
        <table class="table table-sm mb-5 table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-nowrap">Room</th>
                    <th class="text-nowrap">Status</th>
                    <th class="text-nowrap">Checklist Date</th>
                    <th class="text-nowrap">id/hash</th>
                </tr>
            </thead>
            <tbody data-checklists-all>
                <? foreach($lists as $row): ?>
                    <tr data-checklist-open data-href="/checklists/single/<?= $row->id ?>">
                        <td><i class="fa-solid fa-square text-<?= $row->room ?>"></i> <?= ucfirst($row->room) ?></td>
                        <td>
                            <i class="fa-solid fa-<?= $row->status == "active"? 'arrows-spin': 'check' ?> text-<?= $row->status == "active"? 'orange': 'success' ?>"></i>
                            <?= ucfirst($row->status) ?>
                        </td>
                        <td><?= date("F jS (D)", strtotime($row->date_applied)) ?></td>
                        <td class="font-monospace small text-muted"><?= $row->id ?></td>
                    </tr>
                <? endforeach ?>
            </tbody>
        </table>
    </form>
</div>
<script type="module">
    document.addEventListener('click', (e) => {
        if (e.target.closest('[data-checklist-open]')) {
            const href = e.target.closest('[data-checklist-open]').dataset.href;
            if (href) {window.location.href = href;}
        }
    });
</script>
<?= $this->endSection() ?>