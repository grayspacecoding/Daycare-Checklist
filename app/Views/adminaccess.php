<?= $this->extend('emu') . $this->section('content') ?>

<div class="container py-5 my-5 text-center">
    <h1 class="display-4">Administration</h1>
    <form class="text-center">
        <p>Please provide your admin passcode below:</p>
        <input type="password" name="passcode" class="w-50 form-control form-control-lg mx-auto text-center mt-4 mb-3" style="letter-spacing: 1rem;" maxlength="8" required>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
    <? print_r(session()->get('isAdmin')) ?>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();
        fetch('/sessionmods/adminauth', {method: 'POST', body: new FormData(event.target)})
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {window.location.reload();}
            else {alert('Invalid passcode. Please try again.');}
        });

    });
</script>

<?= $this->endSection() ?>