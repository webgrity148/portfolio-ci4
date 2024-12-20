
<?= view('App\Views\admin\layouts\header') ?>

<?php // view('App\Views\admin\layouts\navbar') ?>

<div id="content">
    <?= $this->renderSection('content') ?> <!-- Content will be injected here -->
</div>
<?= view('App\Views\admin\layouts\footer') ?>
