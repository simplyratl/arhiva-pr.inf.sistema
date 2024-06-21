<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?> <?= $document['name'] ?> <?= $this->endSection() ?>

<?= $this->section("content") ?>
<h1><?= $document['name'] ?></h1>

<?= form_open("temp-documents/update") ?>
<label for="name">Naziv</label>
<input type="text" name="name" id="name" />
<button class="btn btn-primary">Submit</button>

<?= $this->endSection() ?>
