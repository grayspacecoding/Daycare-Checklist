
<?= $this->extend('emu') . $this->section('content') ?>
<div class="d-flex justify-content-center align-items-center flex-column" style="height: 80vh;">
    <h1 class="text-center font-montserrat">Daily Checklist App | Welcome!</h1>
    <p class="lead">Please choose a room:</p>
    <div class="d-flex gap-4 display-1">
        <? foreach(['blue', 'green', 'yellow', 'purple'] as $color): ?>
        <span data-thisisa-tooltip title="<?= ucfirst($color) ?> Room"><i role="button" onclick="document.dispatchEvent(new CustomEvent('room.change', {detail: '<?= $color ?>'}))" class="fa-solid fa-square text-<?= $color ?>"></i></span>
        <? endforeach ?>
    </div>
</div>
<script>
    document.addEventListener('room.changed', () => {window.location.reload();});
</script>
<?= $this->endSection() ?>