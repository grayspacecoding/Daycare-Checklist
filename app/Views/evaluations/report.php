<?= $this->extend('panther') . $this->section('content') ?>

<div class="container py-3 mb-5">
    <section class="sticky-top border-bottom border-secondary border-5 bg-light pb-1">
        <div class="fw-bold fs-4 font-montserrat">Evaluation: <?= $schema->title ?> <small>(v<?= $schema->version ?>)</small></div>
        <div class="font-montserrat fw-light d-flex gap-2 flex-wrap align-items-center">
            <span class="fas fa-ellipsis-vertical small"></span>
            <span class="small"><?= $evaluation->teacher ?></span>
            <span class="fas fa-ellipsis-vertical small"></span>
            <span class="small"><?= $evaluation->round ?></span>
            <span class="fas fa-ellipsis-vertical small"></span>
            <span class="small"><?= date("F j, Y", strtotime($evaluation->reviewed_on)) ?></span>
            <span class="fas fa-ellipsis-vertical small"></span>
            <span class="small">Status: <b class="fw-bold"><?= ucfirst($evaluation->status) ?></b></span>
        </div>
    </section>
</div>

<?= $this->endSection() ?>