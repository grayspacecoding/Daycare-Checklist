<?= $this->extend('panther') . $this->section('content') ?>

<div class="container py-5">
    <div class="mb-3">
        <a class="btn btn-info" data-bs-toggle="offcanvas" data-bs-target="#newEvalForm" aria-controls="newEvalForm" role="button">Start a new evaluation</a>
    </div>
    <h1 class="h3 font-montserrat">Ongoing Evaluations</h1>
    <? if(empty($ongoing)): ?>
        <p class="text-muted fst-italic">No ongoing evaluations found.</p>
    <? else: ?>
    <ul>
    <? foreach ($ongoing as $eval): ?>
        <li>
            <a href="/evaluations/single/<?= $eval->id ?>" class="text-decoration-none">
                <strong class="font-monospace me-2"><?= date("M d", strtotime($eval->reviewed_on)) ?></strong>
                <?= esc($eval->teacher) ?> &ndash; <?= esc($eval->round) ?> Evaluation
            </a>
        </li>
    <? endforeach; ?>
    </ul>
    <? endif; ?>
    <h2 class="h4 font-montserrat mt-5">
        Latest Completed Evaluations
        <a href="" class="text-decoration-none fw-light ms-5" style="font-size: 1rem;">See All <i class="fa-solid fa-arrow-right"></i></a>
    </h2>
    <div class="mb-3">
        <div class="d-inline-block">
            <select class="form-select">
                <option value="">All Teachers</option>
                <? foreach ($teachers as $teacher): ?>
                    <option value="<?= esc($teacher->teacher) ?>"><?= esc($teacher->teacher) ?></option>
                <? endforeach; ?>
            </select>
        </div>
    </div>
    <? if(count($recent) > 0): foreach ($recent as $eval): ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
        <div class="col" data-filtertag="<?= esc($eval->teacher) ?>">
            <a href="/evaluations/single/<?= $eval->id ?>" class="mb-3 text-decoration-none d-block text-dark border border-secondary rounded-3 p-2">
                <i class="fa-solid fa-calendar-day"></i><b><?= date("l M. jS", strtotime($eval->reviewed_on)) ?></b>
                <i class="float-end small text-muted"><?= ucfirst($eval->status) ?></i><br>
                <small style="font-size: 0.6rem;" class="text-secondary font-monospace p-1">id: <?= $eval->id ?></small>
            </a>
        </div>
    </div>
    <? endforeach; else: echo '<i class="text-muted fst-italic">No recent evaluations found.</i>'; endif; ?>
</div>

<form class="offcanvas offcanvas-start" tabindex="-1" id="newEvalForm" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasLabel">New Evaluation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="d-flex flex-column gap-3">
            <div>
                <label class="form-label" for="nef_teacher">Teacher</label>
                <input type="text" class="form-control" id="nef_teacher" name="teacher" placeholder="Enter teacher's name" required>
            </div>
            <div>
                <label class="form-label" for="nef_eval_schema">Evaluation</label>
                <select class="form-select" id="nef_eval_schema" name="eval_schema" required>
                    <option value="" selected disabled>Select an evaluation</option>
                    <? foreach ($evals as $eval): ?>
                        <option value="<?= $eval->id ?>"><?= esc($eval->title) ?> (v<?= esc($eval->version) ?>)</option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label class="form-label" for="nef_round">Interval</label>
                <select class="form-select" id="nef_round" name="round" required>
                    <option value="" selected disabled>Select an interval</option>
                    <option value="3 Month">3 Month</option>
                    <option value="6 Month">6 Month</option>
                    <option value="9 Month">9 Month</option>
                    <option value="1 Year">1 Year</option>
                    <option value="2 Year">2 Year</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div>
                <label class="form-label" for="nef_evaldate">Evaluation date</label>
                <input type="date" class="form-control" id="nef_evaldate" name="reviewed_on" required>
            </div>
            <div>
                <button type="submit" class="btn btn-info">Create Evaluation</button>
            </div>
            <div class="text-danger" id="responseMsg"></div>
        </div>
    </div>
</form>

<script>
    const offCanvasForm = document.getElementById('newEvalForm');
    offCanvasForm.addEventListener('hidden.bs.offcanvas', function () {
        offCanvasForm.reset();
        document.getElementById('responseMsg').textContent = '';
    });

    offCanvasForm.addEventListener('submit', function (e) {
        e.preventDefault();
        document.querySelector('.btn-info').disabled = true;
        document.getElementById('responseMsg').textContent = '';
        const formData = new FormData(offCanvasForm);
        fetch('/evaluations/neweval', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log(data.id);
                offCanvasForm.dispatchEvent(new Event('hidden.bs.offcanvas'));
                window.location.href = `/evaluations/single/${data.id}`;
            } else {
                document.getElementById('responseMsg').textContent = data.message || 'An error occurred.';
            }
        })
        .catch(error => {
            document.getElementById('responseMsg').textContent = 'Failed to create evaluation: ' + error.message;
        })
        .finally(() => {
            document.querySelector('.btn-info').disabled = false;
        });
    });
</script>

<?= $this->endSection() ?>