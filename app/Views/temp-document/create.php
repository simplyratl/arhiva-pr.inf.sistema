<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>Dodavanje privremenog dokumenta<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="d-flex justify-content-between align-items-center">
    <h1 class="card-title h4">Dodavanje privremenog dokumenta</h1>
</div>

<form action="/temp-documents/add" method="POST" class="d-flex flex-column gap-4" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm">
            <label for="name">Naziv</label>
            <input type="text" class="form-control mt-1" placeholder="Naziv" id="name" name="name">
        </div>
        <div class="col-sm">
            <label for="boxNumber">Broj kutije</label>
            <input type="text" class="form-control mt-1" placeholder="Broj kutije" id="boxNumber" name="boxNumber">
        </div>
        <div class="col-sm">
            <label for="registerNumber">Broj registra</label>
            <input type="text" class="form-control mt-1" placeholder="Broj registra" id="registerNumber"
                name="registerNumber">
        </div>
    </div>

    <div class="row">
        <div class="col-sm">
            <label for="documentTypeId">Tip dokumenta</label>
            <select class="form-select" a id="documentTypeId" name="documentTypeId">
                <option selected>Izaberite tip</option>
                <?php foreach ($documentTypes as $documentType): ?>
                    <option value="<?= $documentType['id'] ?>"><?= $documentType['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm">
            <label for="document">Dokument</label>
            <input class="form-control" type="file" id="document" name="document" accept=".pdf">
        </div>
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