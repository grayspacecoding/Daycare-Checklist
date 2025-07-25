<?= $this->extend('emu') . $this->section('content') ?>
<div class="container py-4">
    <?
    foreach([
        [
            "title" => "Active Lists",
            "icon" => "bi bi-play-circle-fill text-primary",
            "status" => "active"
        ],
        [
            "title" => "Completed Lists",
            "icon" => "bi bi-check-circle text-success",
            "status" => "completed"
        ]
    ] as $section): ?>
    <h1 class="h4 font-montserrat"><i class="<?= $section['icon'] ?>"></i> <?= $section['title'] ?></h1>
    <table class="table table-sm mb-5">
        <thead>
            <tr>
                <th class="w-75">Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody data-checklists-<?= $section['status'] ?> data-checklists></tbody>
    </table>
    <? endforeach ?>
</div>
<script type="module">
    const getChecklists = async () => {
        try {
            const response = await fetch('/checklists/crud/all/15', { method: 'POST' });
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            let group = {active: [], completed: []};
            data.forEach(item => {
                if (item.status === 'active') {
                    group.active.push(item);
                } else {
                    group.completed.push(item);
                }
            });
            for (const [key, value] of Object.entries(group)) {
                const tbody = document.querySelector(`[data-checklists-${key}]`);
                tbody.innerHTML = value.length ? value.map(item => `
                    <tr>
                        <td>${new Date(item.date_applied).toLocaleDateString()}</td>
                        <td>${item.status}</td>
                    </tr>
                `).join('') : none(key);
            }
        } catch (error) {
            console.error('Error fetching checklists:', error);
        }
    };

    const loading = `<tr><td colspan="2" class="text-center">Loading...</td></tr>`;
    const none = (group) => `<tr><td colspan="2" class="text-center">No ${group} checklists found.</td></tr>`;

    document.addEventListener('room.change', ()=>{
        document.querySelectorAll(`[data-checklists]`).forEach(tbody => tbody.innerHTML = loading);
    });

    ['DOMContentLoaded', 'room.changed'].forEach(event => {
        document.addEventListener(event, getChecklists);
    });
</script>
<?= $this->endSection() ?>