<?= $this->extend('emu') . $this->section('content') ?>
<form class="container py-4 d-flex flex-column gap-2" id="checklist-form">

    <div class="small font-bitcount d-flex align-items-center gap-3 flex-wrap">
        <div>Checklist date: <u><?= $checklist->date_applied ?></u></div>
        <div>Status: <u style="text-transform: capitalize;"><?= $checklist->status ?></u></div>
    </div>

    <h2 class="h4 font-montserrat pt-4">Teachers</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
    <? foreach($schema['teachers'] as $input): ?>
        <div class="col">
            <div class="form-floating">
                <input type="text" name="<?= $input[0] ?>" class="form-control border-dark" id="<?= $input[0] ?>" placeholder="" value="<?= $formdata->{$input[0]} ?? '' ?>">
                <label for="<?= $input[0] ?>"><?= $input[1] ?></label>
            </div>
        </div>
    <? endforeach; ?>
    </div>

    <h2 class="h4 font-montserrat pt-4">Students</h2>
    <div class="row row-cols-5 row-cols-md-6 g-2">
    <? foreach($schema['students'] as $input): ?>
    <div class="col">
        <div class="form-floating mb-2 d-inline-block">
            <input type="number" min="0" step="1" name="<?= $input[0] ?>" class="form-control border-dark" id="<?= $input[0] ?>" placeholder="" value="<?= $formdata->{$input[0]} ?? 0 ?>">
            <label for="<?= $input[0] ?>"><?= $input[1] ?></label>
        </div>
    </div>
    <? endforeach ?>
    </div>
    
    <div class="row row-cols-1 row-cols-lg-2 g-2">
        <? foreach([1, 0] as $col): ?>
        <div class="col">
            <? for ($i = $col; $i < count($schema['checklist_items']); $i +=2): $section = $schema['checklist_items'][$i]; $index = 0; ?>
            <h2 class="h4 font-montserrat pt-4"><i class="<?= $section['icon'] ?>"></i> <?= $section['section'] ?></h2>
            <? foreach($section["groups"] as $g): ?>
                <h3 class="h6 fw-bold font-montserrat pt-3"><?= $g['title'] ?></h3>
                <? foreach($g["inputs"] as $input): $ifChecked = $formdata->{$section['shortcode'].'_'.$index} ?? 0; ?>
                    <div class="form-check">
                        <input class="form-check-input border-dark" type="checkbox" <?= empty($ifChecked) ? '' : 'checked' ?> id="<?= $section['shortcode'].'_'.$index ?>" name="<?= $section['shortcode'].'_'.$index ?>">
                        <label class="form-check-label" for="<?= $section['shortcode'].'_'.$index ?>">
                            <?= $input ?>
                        </label>
                    </div>
                    <? $index++; ?>
                <? endforeach ?>
            <? endforeach ?>
            <? endfor ?>
        </div>
        <? endforeach ?>
    </div>
</form>

<div class="py-2 pe-2 d-flex justify-content-end align-items-center gap-2 sticky-bottom">
    <span class="font-bitcount text-info" data-autosave-indicator></span>
    <button class="btn btn-sm btn-info rounded-0" data-finalize-btn>Submit</button>
</div>

<div data-certify-modal class="position-absolute top-0 start-0 w-100 h-100 d-none align-items-center justify-content-center" style="backdrop-filter: blur(1.5px); z-index: 1000;">
    <div class="text-bg-white p-5 shadow rounded-4">
        <p><b class="lead text-info">Ready to complete your daily checklist?</b><br>Once you sign, you will not be able to make further changes.</p>
    </div>
</div>
<script type="module">
    document.addEventListener('room.changed', () => {window.location.href = '/';});

    const saveStatusIndication = (status) => {
        const indicator = document.querySelector('[data-autosave-indicator]');
        switch (status) {
            case 'saving':
                indicator.textContent = 'Saving...';
                indicator.classList.replace('text-info', 'text-warning');
                break;
            case 'saved':
                indicator.textContent = 'Saved!';
                indicator.classList.replace('text-warning', 'text-info');
                break;
            default:
                indicator.textContent = 'Error!';
                indicator.classList.replace('text-warning', 'text-danger');
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

        fetch('/checklists/crud/save/<?= $checklist->id ?>', {
            method: 'POST',
            body: new FormData(document.querySelector('#checklist-form')),
        })
        .then(response => response.json())
        .then(data =>{console.log(data);})
        .finally(() => {saveStatusIndication('saved');})
        .catch(error => {
            console.error('Error saving input:', error);
            saveStatusIndication('error');
        });
    };

    const debouncedSaveInput = debounce(saveInput, 1000);

    document.querySelectorAll('input, textarea, select').forEach((element) => {
        element.addEventListener('input', debouncedSaveInput);
    });

    const finalizeChecklist = () => {
        const modal = document.querySelector('[data-certify-modal]');
        modal.classList.replace('d-none', 'd-flex');
        modal.addEventListener('click', (e) => {
            if (e.target === modal || e.target.closest('.text-bg-white')) {
                modal.classList.replace('d-flex', 'd-none');
            } else if (e.target.closest('[data-finalize-btn]')) {
                finalizeChecklistOld();
            }
        });
    };

    const finalizeChecklistOld = () => {
        if (confirm('Are you ready to submit your finished checklist? Once submitted, you will not be able to make further changes.')) {
            fetch('/checklists/crud/finalize/<?= $checklist->id ?>', {
                method: 'POST',
                body: new FormData(document.querySelector('#checklist-form')),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/';
                } else {
                    alert('Error finalizing checklist: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error finalizing checklist:', error);
                alert('An error occurred while finalizing the checklist.');
            });
        }
    };

    document.querySelector('[data-finalize-btn]').addEventListener('click', finalizeChecklistOld);

    [`input[type="number"]`, `input[type="text"]`].forEach(selector => {
        document.querySelectorAll(selector).forEach((input) => {
            input.addEventListener('focus', (event) => {
                event.target.select();
            });
        });
    });
</script>
<?= $this->endSection() ?>