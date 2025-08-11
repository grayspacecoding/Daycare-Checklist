<?= $this->extend('emu') . $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex flex-column gap-5">
        <h1 class="h4 font-montserrat">
            <span class=""><i class="fa-solid fa-calendar"></i> <?= date("M d:") ?></span>
            <? if (empty($checklist) && date('N') >= 6): ?>
            Not started, but it's the weekend.
            <button class="ms-4 btn btn-info" onclick="document.dispatchEvent(new Event('checklist.new'))">Start a checklist anyway?</button>
    
            <? elseif (empty($checklist)): ?>
            <span class="text-danger">Not started</span>
            <button class="ms-4 btn btn-outline-dark" onclick="document.dispatchEvent(new Event('checklist.new'))">Start today's checklist</button>
    
            <? elseif ($checklist->status == 'active'): ?>
            <span class="text-orange">In progress...</span>
            <a class="ms-4 btn btn-info" href="/checklists/single/<?= $checklist->id ?>">Continue today's checklist</a>
    
            <? elseif ($checklist->status == 'finished'): ?>
            <span class="text-info">Finished!</span>
            <a class="ms-4 btn btn-info" href="/checklists/single/<?= $checklist->id ?>">View today's checklist</a>
            <? endif ?>
        </h1>
        <div>
            <h1 class="h4 font-montserrat">Attention areas <span class="text-danger">(<i class="fa-solid fa-exclamation"></i>)</span></h1>
            <div class="fst-italic text-muted mb-2">
                <?= $previous["c"] == 0? '<span class="lead"><i class="fa-solid fa-check text-success"></i> No attention areas identified</span>' : '<i class="fa-solid fa-info-circle text-danger"></i> <b>Attention areas</b> are tasks that weren\'t completed during the previous checklist, and may need to be prioritized for today\'s checklist.' ?>
            </div>
            <div class="row row-cols-2">
                <? foreach([0, 1] as $col): ?>
                <div class="col">
                    <? for($i = $col; $i < count($previous["i"]); $i+=2):
                        $section = $previous["i"][$i];
                        if (gettype($section) == "string") {
                            echo '<i class="fa-solid fa-triangle-exclamation text-orange"></i> <b>' . $section . "</b>";
                            continue;
                        }
                    ?>
                    <div class="py-2">
                        <h2 class="h5 font-montserrat"><? echo esc($section['section']); ?></h2>
                            <? foreach($section['groups'] as $group=>$items): if(empty($items)) continue; ?>
                            <p class="text-muted fst-italic small font-montserrat"><?= esc($group) ?></p>
                            <ul class="list-unstyled">
                                <? foreach($items as $item): ?>
                                <li><i class="fa-solid fa-close text-danger"></i> <?= esc($item) ?></li>
                                <? endforeach; ?>
                            </ul>
                            <? endforeach; ?>
                    </div>
                    <? endfor ?>
                </div>
                <? endforeach; ?>
            </div>
        </div>
        <div>
            <h1 class="h4 font-montserrat">Recent Checklists</h1>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
                <? foreach($recent as $c): ?>
                <div class="col">
                    <a href="/checklists/single/<?= $c->id ?>" class="mb-3 text-decoration-none d-block text-dark border border-secondary rounded-3 p-2">
                        <i class="fa-solid fa-calendar-day"></i><b><?= date("l M. jS", strtotime($c->date_applied)) ?></b>
                        <i class="float-end small text-muted"><?= ucfirst($c->status) ?></i><br>
                        <small style="font-size: 0.6rem;" class="text-secondary font-monospace p-1">id: <?= $c->id ?></small>
                    </a>
                </div>
                <? endforeach ?>
                <div class="col d-flex align-items-center">
                    <a href="/dashboard/fulllist" class="mb-3 text-decoration-none d-block p-2">
                        All checklists <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>