<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>Početna<?= $this->endSection() ?>

<?= $this->section("content") ?>
    <h1>test123</h1>
    <button class="btn btn-primary">test123</button>

    <?php foreach ($documents as $document): ?>
        <h2>
            <a href="/temp-documents/<?= $document['id'] ?>">
            <?= $document['name'] ?>
            </a>
        </h2>
    <?php endforeach; ?>
<?= $this->endSection() ?>
