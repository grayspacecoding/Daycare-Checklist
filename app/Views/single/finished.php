<?= $this->extend('emu') . $this->section('content') ?>
<div class="container py-4 d-flex flex-column gap-2">
    <div class="small font-bitcount d-flex align-items-center gap-3 flex-wrap">
        <div>Checklist date: <u><?= $checklist->date_applied ?></u></div>
        <div>Status: <u style="text-transform: capitalize;"><?= $checklist->status ?></u></div>
    </div>

    <div class="d-flex gap-5 flex-wrap">
        <div>
            <h2 class="h4 font-montserrat pt-4 mb-1">Teachers</h2>
            <div class="d-flex flex-wrap gap-3">
                <? foreach($schema['teachers'] as $control): ?>
                <div>
                    <strong><?= $formdata->{$control[0]} ?? '' ?></strong>
                    <hr class="my-1">
                    <small><?= $control[1]; ?></small>
                </div>
                <? endforeach ?>
            </div>
        </div>
        <div>
            <h2 class="h4 font-montserrat pt-4 mb-1">Students</h2>
            <div class="d-flex flex-wrap gap-3">
                <? foreach($schema['students'] as $control): ?>
                <div style="min-width: 0.5in;">
                    <strong class="font-monospace"><?= $formdata->{$control[0]} ?? '' ?></strong>
                    <hr class="my-1">
                    <small><?= $control[1]; ?></small>
                </div>
                <? endforeach ?>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2">
        <? foreach([1, 0] as $col): ?>
        <div class="col">
            <? for($i = $col; $i < count($schema['checklist_items']); $i += 2): $section = $schema['checklist_items'][$i]; ?>
            <h2 class="h4 font-montserrat pt-4 mb-1">
                <i class="<?= $section['icon'] ?>"></i>
                <?= $section['section'] ?>
            </h2>
            <? foreach($section['groups'] as $group): $index = 0; ?>
            <div class="font-montserrat mt-3 border-bottom"><?= $group['title'] ?></div>
            <div class="d-flex gap-1 flex-column">
                <? foreach($group['inputs'] as $item): $checked = isset($formdata->{"{$section['shortcode']}_$index"}); ?>
                    <div class="d-flex gap-1 align-items-baseline text-<?= $checked ? 'success' : 'secondary' ?>">
                        <i class="fa-regular fa-square<?= $checked ? '-check' : '' ?>"></i>
                        <div><?= $item ?></div>
                    </div>
                <? $index++; endforeach ?>
            </div>
            <? endforeach; ?>
            <? endfor ?>
        </div>
        <? endforeach ?>
    </div>
</div>
<?= $this->endSection() ?>