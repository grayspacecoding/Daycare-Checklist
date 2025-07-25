<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Daily Checklist | LSF</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <style>
            .text-purple {
                color: #7912beff;
            }
        </style>
    </head>
    <body>
        <div style="min-height: 100vh;" class="d-flex flex-column">
            <header class="d-flex justify-content-between align-items-center py-2 px-3">
                <div class="h4">Daily Checklist | LSF</div>
                <div class="d-flex gap-2 fs-5">
                    <i role="button" data-thisisa-tooltip title="New Checklist" class="bi bi-file-earmark-plus-fill text-info"></i>
                    <div style="width: 0.5em;"></div>
                    <i role="button" data-thisisa-tooltip title="Blue Room" class="bi bi-square-fill text-primary"></i>
                    <i role="button" data-thisisa-tooltip title="Green Room" class="bi bi-square-fill text-success"></i>
                    <i role="button" data-thisisa-tooltip title="Yellow Room" class="bi bi-square-fill text-warning"></i>
                    <i role="button" data-thisisa-tooltip title="Purple Room" class="bi bi-square-fill text-purple"></i>
                    <div style="width: 0.5em;"></div>
                    <i role="button" data-thisisa-tooltip title="Exit" class="bi bi-door-closed"></i>
                    <i role="button" data-thisisa-tooltip title="Toggle dark/light mode" class="bi bi-circle-half" onclick="document.dispatchEvent(new Event('darklight.toggle'))"></i>
                </div>
            </header>
            <main class="flex-grow-1">
                <?= $this->renderSection('content') ?>
            </main>
            <footer class="bg-dark text-secondary text-center text-lg-start mt-auto">
                <div class="text-center p-3 small">
                    © <?= date('Y') ?> Daily Checklist | by Parseley <img src="https://parseley.net/parseley-green.svg" alt="Parseley Logo" style="height: 1em;"> Devs
                </div>
            </footer>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
        <script type="module">
            import { toggleTheme } from '<?= base_url('uimods/lightdark') ?>';
            document.addEventListener('darklight.toggle', toggleTheme);
            
            const tooltipTriggerList = document.querySelectorAll('[data-thisisa-tooltip]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        </script>
    </body>
</html>