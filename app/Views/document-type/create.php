<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>Dodavanje tipa dokumenta<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="d-flex justify-content-between align-items-center">
    <h1 class="card-title h2">Dodavanje tipa dokumenta</h1>
</div>

<form action="/document-types/add" method="POST">
    <div class="">
        <label for="name">Naziv</label>
        <input type="text" class="form-control mt-1" placeholder="Naziv" id="name" name="name">
    </div>

    <div class="d-flex justify-content-end mt-2">
        <button class="btn btn-primary">Dodaj</button>
    </div>

</form>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger" role="alert">
        <ul class="m-0">
            <?php foreach (session('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>