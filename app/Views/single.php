<?= $this->extend('emu') . $this->section('content') ?>
<form class="container py-4 d-flex flex-column gap-2" id="checklist-form">

    <div class="small font-bitcount d-flex align-items-center gap-3 flex-wrap">
        <div>Checklist date: <u><?= $checklist->date_applied ?></u></div>
        <div>Status: <u><?= $checklist->status ?></u></div>
    </div>

    <h2 class="h4 font-montserrat pt-4">Teachers</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
    <? foreach([
        ["am_teacher", "AM Teacher"],
        ["second_teacher", "2nd Teacher"],
        ["pm_teacher", "PM Teacher"],
    ] as $input): ?>
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
    <? foreach([
        ["students_18", "18 mo"],
        ["students_2", "2 yr"],
        ["students_3", "3 yr"],
        ["students_4", "4 yr"],
        ["students_5", "5 yr"],
    ] as $input): ?>
    <div class="col">
        <div class="form-floating mb-2 d-inline-block">
            <input type="number" min="0" step="1" name="<?= $input[0] ?>" class="form-control border-dark" id="<?= $input[0] ?>" placeholder="" value="<?= $formdata->{$input[0]} ?? 0 ?>">
            <label for="<?= $input[0] ?>"><?= $input[1] ?></label>
        </div>
    </div>
    <? endforeach ?>
    </div>

    <?
    $inputs = [
        [
            "section" => "Playground",
            "shortcode" => "playground",
            "icon" => "fa-solid fa-football",
            "groups" => [
                [
                    "title" => "Space yourself around outside on the playground, blacktop, play equipment; move around continuously throughout the duration of outdoor time.",
                    "inputs" => [
                        "Monitoring playground",
                        "Walk the perimeter to pick up debris before going out",
                        "Take fanny pack outside (tissues, gloves, ice pack, bandages)",
                        "Count children before going out & coming in",
                        "Body check completed upon coming in",
                        "Take walkies out & take one to the front desk",
                    ]
                ]
            ]
        ],
        [
            "section" => "Body Checks",
            "shortcode" => "body_checks",
            "icon" => "fa-solid fa-child-reaching",
            "groups" => [
                [
                    "title" => "Make sure children's faces are clean at all times.",
                    "inputs" => [
                        "Arrival time check",
                        "Post breakfast/lunch face wiped",
                        "Post inside/outside play check",
                        "After nap check",
                        "Departure body/face check & shoe tie check",
                    ]
                ]
            ]
        ],
        [
            "section" => "Cleaning",
            "shortcode" => "cleaning",
            "icon" => "fa-solid fa-spray-can-sparkles",
            "groups" => [
                [
                    "title" => "",
                    "inputs" => [
                        "Spray bottles are labeled and full",
                        "Toys cleaned and sanitized",
                        "Bathroom cleaned & sanitized at nap time",
                        "Remove floor items when cleaning bathroom floors",
                    ]
                ],
                [
                    "title" => "PM Checklist - prior to departure:",
                    "inputs" => [
                        "Toys returned to bins",
                        "Bleach & water",
                        "Dramatic play neat",
                        "Library books returned",
                        "Tables & chairs cleaned",
                        "Diaper Genie cleaned out",
                        "Computers & speakers off",
                        "Temperature set to 70°F",
                        "Doors & windows locked",
                        "Lights off",
                        "iPads returned and plugged in",
                        "Classrooms set up for success",
                        "No food or drink left in the classroom"
                    ]
                ]
            ]
        ],
        [
            "section" => "Classroon",
            "shortcode" => "classroom",
            "icon" => "fa-solid fa-chalkboard-user",
            "groups" => [
                [
                    "title" => "",
                    "inputs" => [
                        "Cell phone is not visible in classroom",
                        "Classroom attendance completed",
                        "Toys cleaned and sanitized",
                    ]
                ],
                [
                    "title" => "Board info is current",
                    "inputs" => [
                        "Lesson plan up current; given to office on Thur.",
                        "Goals/objectives",
                        "Lunch menu posted holidays",
                        "Activities",
                        "All classroom materials are organized"
                    ]
                ],
                [
                    "title" => "Planning time used efficiently",
                    "inputs" => [
                        "Cleaning (cubbies, doorknobs, bathroom, floors)",
                        "Prep for next day success",
                        "Lesson plans complete for next week",
                        "Lillio report sent",
                        "Homework sent",
                        "Cots are 6ft child head to toe",
                        "Set day for room weekly room meetings",
                    ]
                ],
                [
                    "title" => "Scheduling",
                    "inputs" => [
                        "Following classroom schedule",
                    ]
                ],
                [
                    "title" => "Monitoring children",
                    "inputs" => [
                        "Children's clothes changed if wet or dirty",
                    ]
                ],
            ]
        ]
    ];
    ?>
    <div class="row row-cols-1 row-cols-lg-2 g-2">
        <? foreach([1, 0] as $col): ?>
        <div class="col">
            <? for ($i = $col; $i < count($inputs); $i +=2): $section = $inputs[$i]; $index = 0; ?>
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
    <button class="btn btn-sm btn-info rounded-0">Submit</button>
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

</script>
<?= $this->endSection() ?>