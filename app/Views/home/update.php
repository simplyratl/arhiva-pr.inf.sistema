<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?> <?= $document['name'] ?> <?= $this->endSection() ?>

<?= $this->section("content") ?>
<h1><?= $document['name'] ?></h1>

<?= $this->endSection() ?>
