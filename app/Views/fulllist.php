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
                    <th class="text-nowrap">Started</th>
                    <th class="text-nowrap">Finished</th>
                </tr>
            </thead>
            <tbody data-checklists-all></tbody>
        </table>
    </form>
</div>
<script type="module">
    const getChecklists = async () => {
        try {
            const response = await fetch('/checklists/crud/all/750', { method: 'POST' });
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const tbody = document.querySelector(`[data-checklists-all]`);
            const data = await response.json();
            if (data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="text-center">No checklists found.</td></tr>`;
                return;
            }
            tbody.innerHTML = '';
            for (const item of data) {
                tbody.innerHTML += `
                    <tr>
                        <td style="text-transform: capitalize;">${item.room}</td>
                        <td style="text-transform: capitalize;">${item.status}</td>
                        <td>${new Date(item.date_applied).toLocaleDateString()}</td>
                        <td>${item.created ? new Date(item.created).toLocaleDateString() : 'N/A'}</td>
                        <td>${item.completed_on ? new Date(item.completed_on).toLocaleDateString() : 'N/A'}</td>
                    </tr>
                `;
            }
        } catch (error) {
            console.error('Error fetching checklists:', error);
        }
    };

    const loading = `<tr><td colspan="5" class="text-center">Loading...</td></tr>`;

    document.addEventListener('room.change', ()=>{
        document.querySelector(`[data-checklists-all]`).innerHTML = loading;
    });

    ['DOMContentLoaded', 'room.changed'].forEach(event => {
        document.addEventListener(event, getChecklists);
    });
</script>
<?= $this->endSection() ?>