<?= $this->extend('panther') . $this->section('content') ?>
<form class="container py-3 mb-5" id="evalForm">
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
    <? $index = 0; $structure = json_decode($schema->structure); $responses = json_decode($evaluation->responses); foreach($structure as $section): ?>
    <section class="mt-5">
        <h2 class="h4 font-montserrat text-orange"><?= $section->sectionTitle ?></h2>
        <div class="row row-cols-1 row-cols-xl-2 g-5">
        <? for($col = 0; $col <=1; $col++): ?>
            <div class="col">
            <? for($i = $col; $i < count($section->objectives); $i+=2): ?>
                <div class="fs-5 mb-2"><?= $section->objectives[$i] ?></div>
                <div class="row mb-5 pb-2" style="border-bottom: 1px #777 dotted;">
                    <div class="col-7 d-flex gap-1 font-monospace">
                        <div class="text-muted">1</div>
                        <input type="range" data-indexnum="<?= $index ?>" class="form-range flex-grow-1" min="1" max="5" step="1" id="r[<?= $index ?>]" name="r[<?= $index ?>]" value="<?= isset($responses[$index]) ? $responses[$index] : 3 ?>" required>
                        <div class="text-dark fw-bold">5</div>
                    </div>
                    <div class="col-5 text-center small fw-bold" id="feedback-<?= $index ?>"></div>
                </div>
            <? $index++; endfor ?>
            </div>
        <? endfor ?>
        </div>
    </section>
    <? endforeach ?>
</form>

<div class="container-fluid sticky-bottom shadow shadow-lg bg-light d-flex justify-content-around py-2 align-items-center">
    <div style="width: 200px" class="font-bitcount" style="color: gray;" data-autosave-indicator>Saved!</div>
    <button type="submit" onclick="document.dispatchEvent(new Event('eval.finalize'))" class="btn btn-sm btn-info rounded-0">Complete Evaluation</button>
</div>

<script>
    document.querySelectorAll('input[type="range"]').forEach(input => {
        input.addEventListener('input', function() {
            const index = this.getAttribute('data-indexnum');
            updateFeedback(index, this.value);
        });
        // Initialize feedback on page load
        updateFeedback(input.getAttribute('data-indexnum'), input.value);
    });

    document.addEventListener('eval.finalize', event => {
        let doublecheck = confirm("Are you sure you want to complete this evaluation? Once completed, you will not be able to edit your responses.");
        if (doublecheck) {finalizeEvaluation();}
    });

    function updateFeedback(index, value) {
        const feedback = document.getElementById(`feedback-${index}`);
        switch (value) {
            case '1':
                feedback.textContent = 'Improvement required';
                feedback.style.color = 'red';
                break;
            case '2':
                feedback.textContent = 'Below Average';
                feedback.style.color = 'orange';
                break;
            case '3':
                feedback.textContent = 'Average Competence';
                feedback.style.color = 'gray';
                break;
            case '4':
                feedback.textContent = 'Fully competent';
                feedback.style.color = 'ForestGreen';
                break;
            case '5':
                feedback.textContent = 'Exceeds expectation';
                feedback.style.color = 'DodgerBlue';
                break;
        }
    }

    const saveStatusIndication = (status) => {
        const indicator = document.querySelector('[data-autosave-indicator]');
        switch (status) {
            case 'saving':
                indicator.textContent = 'Saving...';
                indicator.style.color = 'gold';
                break;
            case 'saved':
                indicator.textContent = 'Saved!';
                indicator.style.color = 'gray';
                break;
            default:
                indicator.textContent = 'Error!';
                indicator.style.color = 'red';
        }
    };

    const debounce = (func, delay) => {
        let timeout;
        return (...args) => {
            saveStatusIndication('saving');
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    };

    const saveInput = (event) => {
        const inputName = event.target.name;
        const inputValue = event.target.value;

        fetch('/evaluations/updateeval/<?= $evaluation->id ?>', {
            method: 'POST',
            body: new FormData(document.querySelector('#evalForm')),
        })
        .then(response => response.json())
        .then(data =>{
            if (data.status === 'success') {saveStatusIndication('saved');}
            else {
                console.error('Failed to save input:', data.message);
                saveStatusIndication('error');
            }

        })
        .catch(error => {
            console.error('Error saving input:', error);
            saveStatusIndication('error');
        });
    };

    const debouncedSaveInput = debounce(saveInput, 1000);

    document.querySelectorAll('input[type="range"]').forEach((element) => {
        element.addEventListener('input', debouncedSaveInput);
    });

    const finalizeEvaluation = () => {
        fetch('/evaluations/completeeval/<?= $evaluation->id ?>', {
            method: 'POST',
            body: new FormData(document.querySelector('#evalForm')),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                saveStatusIndication('saved');
                window.location.reload();
            } else {
                console.error('Failed to complete evaluation:', data.message);
                saveStatusIndication('error');
            }
        })
        .catch(error => {
            console.error('Error completing evaluation:', error);
            saveStatusIndication('error');
        });
    };



</script>

<?= $this->endSection() ?>