<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Daily Checklist | LSF</title>
        <script>
            (function() {
                const themeKey = 'preferred-theme';
                const stored = localStorage.getItem(themeKey);
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const theme = stored === 'light' || stored === 'dark' ? stored : (prefersDark ? 'dark' : 'light');
                document.documentElement.setAttribute('data-bs-theme', theme);
            })();
        </script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/21998ddf7f.js" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bitcount+Single:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <style>
            .text-purple {color: #8728c7ff;}
            .text-blue {color: #0d6efd;}
            .text-green {color: #198754;}
            .text-yellow {color: #b48a0cff;}
            .font-montserrat {
                font-family: "Montserrat", sans-serif;
                font-optical-sizing: auto;
            }
            .font-bitcount {
                font-family: "Bitcount Single", sans-serif;
                font-optical-sizing: auto;
            }
            
            /* Dark mode manual swapping */
            [data-bs-theme="dark"] .text-light {
                color: var(--bs-dark) !important;
            }
            [data-bs-theme="dark"] .border-dark {
                border-color: var(--bs-light) !important;
            }
            
            [data-bs-theme="dark"] .text-dark {
                color: var(--bs-light) !important;
            }
            [data-bs-theme="dark"] .bg-secondary {
                background-color: var(--bs-dark) !important;
            }

            [data-bs-theme="dark"] .bg-dark {
                background-color: var(--bs-dark) !important;
            }
            [data-bs-theme="dark"] .bg-light {
                background-color: var(--bs-dark) !important;
            }
        </style>
    </head>
    <body>
        <div style="min-height: 100vh;" class="d-flex flex-column">
            <header class="d-flex justify-content-between align-items-center py-2 px-3 bg-secondary bg-opacity-25">
                <div class="fs-4 fw-bold font-montserrat">
                    <span class="d-none d-sm-inline">Daily Checklist | </span>LSF
                    <span class="fw-normal" data-room-indicator></span>
                </div>
                <div class="d-flex gap-2 fs-5">
                    <a href="/" data-thisisa-tooltip title="Dashboard"><i class="fa-solid fa-house-chimney text-dark"></i></a>
                    <span role="button" data-thisisa-tooltip title="New Checklist" onclick="document.dispatchEvent(new Event('checklist.new'))"><i class="fa-solid fa-file-circle-plus text-dark"></i></span>
                    <div style="width: 0.5em;"></div>
                    <? foreach(['blue', 'green', 'yellow', 'purple'] as $color): ?>
                    <span role="button" data-thisisa-tooltip title="<?= ucfirst($color) ?> Room" onclick="document.dispatchEvent(new CustomEvent('room.change', {detail: '<?= $color ?>'}))"><i class="fa-solid fa-square text-<?= $color ?>"></i></span>
                    <? endforeach ?>
                    <div style="width: 0.5em;"></div>
                    <span role="button" data-thisisa-tooltip title="Exit" onclick="document.dispatchEvent(new Event('room.exit'))"><i class="fa-solid fa-door-open"></i></span>
                    <span role="button" data-thisisa-tooltip title="Toggle dark/light mode" onclick="document.dispatchEvent(new Event('darklight.toggle'))"><i class="fa-solid fa-circle-half-stroke"></i></span>
                </div>
            </header>
            <main class="flex-grow-1">
                <?= $this->renderSection('content') ?>
            </main>
            <footer class="bg-dark text-secondary text-center text-lg-start mt-auto font-bitcount">
                <div class="text-center p-3 small">
                    &copy; <?= date('Y') ?> Daily Checklist | by Parseley <img src="https://parseley.net/parseley-green.svg" alt="Parseley Logo" style="height: 1em;"> Devs
                </div>
            </footer>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
        <script type="module">
            import { toggleTheme } from '<?= base_url('uimods/lightdark') ?>';
            import '<?= base_url('uimods/setroom') ?>';
            import '<?= base_url('uimods/newchecklist') ?>';

            document.addEventListener('darklight.toggle', toggleTheme);
            
            const tooltipTriggerList = document.querySelectorAll('[data-thisisa-tooltip]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        </script>
    </body>
</html>