
<?= view('App\Views/layouts\header') ?>

<?= view('App\Views\layouts\navbar') ?>

<div id="content">
    <?= $this->renderSection('content') ?> <!-- Content will be injected here -->
</div>
<?= view('App\Views\layouts\footer') ?>
