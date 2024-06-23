<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>Izmjena <?= $document['name'] ?><?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="d-flex justify-content-between align-items-center">
    <h1 class="card-title h4">Izmjena <?= $document['name'] ?></h1>
</div>

<?php if ($hasPermissionToView): ?>
    <div class="d-flex justify-content-center mt-3">
        <div style="height: 700px" class="pb-4 w-100">
            <iframe id="tempDocFile" frameborder="0" class="w-100 h-100"></iframe>
        </div>
    </div>

<?php else: ?>
    <div class="alert alert-danger" role="alert">
        Nije moguće prikazati dokument jer nemate dozvolu za pristup. Dokument je označen kao povjerljiv.
    </div>
<?php endif; ?>


<form id="editForm" action="/update-req/<?= $document['id'] ?>" method="POST" class="d-flex flex-column gap-4 pb-5">
    <div class="row">
        <div class="col-sm">
            <label for="name">Naziv</label>
            <input value="<?= $document['name'] ?>" type="text" class="form-control mt-1" placeholder="Naziv" id="name"
                name="name" <?= !$hasPermissionToView ? 'disabled' : '' ?>>
        </div>
        <div class="col-sm">
            <label for="boxNumber">Broj kutije</label>
            <input value="<?= $document['boxNumber'] ?>" type="text" class="form-control mt-1" placeholder="Broj kutije"
                id="boxNumber" name="boxNumber">
        </div>
        <div class="col-sm">
            <label for="registerNumber">Broj registra</label>
            <input value="<?= $document['registerNumber'] ?>" type="text" class="form-control mt-1"
                placeholder="Broj registra" id="registerNumber" name="registerNumber">
        </div>
    </div>

    <div class="row">
        <div class="col-sm">
            <label for="shelf">Polica</label>
            <input value="<?= $document['shelf'] ?>" type="text" class="form-control mt-1" placeholder="Polica"
                id="shelf" name="shelf">
        </div>
        <div class="col-sm">
            <label for="shelfRow">Red police</label>
            <input value="<?= $document['shelfRow'] ?>" type="text" class="form-control mt-1" placeholder="Red police"
                id="shelfRow" name="shelfRow">
        </div>
        <div class="col-sm">
            <label for="shelfColumn">Broj police</label>
            <input value="<?= $document['shelfColumn'] ?>" type="text" class="form-control mt-1"
                placeholder="Broj police" id="shelfColumn" name="shelfColumn">
        </div>
    </div>

    <div class="row">
        <div class="col-sm">
            <label for="name">Sektor</label>
            <select class="form-select" id="sectorId" name="sectorId" <?= !$hasPermissionToView ? 'disabled' : '' ?>>
                <option disabled>Izaberite sektor</option>
                <?php foreach ($sectors as $sector): ?>
                    <option value="<?= $sector['id'] ?>" <?= $sector['id'] == $document['sectorId'] ? 'selected' : '' ?>>
                        <?= $sector['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm">
            <label for="privacy">Privatnost</label>
            <select class="form-select" id="privacy" name="privacy" <?= !$hasPermissionToView ? 'disabled' : '' ?>>
                <option disabled>Izaberite privatnost dokumenta</option>
                <?php foreach ($privacy as $priv): ?>
                    <option value="<?= $priv['value'] ?>" <?= $priv['value'] == $document['privacy'] ? 'selected' : '' ?>>
                        <?= $priv['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm">
            <label for="documentTypeId">Tip dokumenta</label>
            <select class="form-select" a id="documentTypeId" name="documentTypeId" <?= !$hasPermissionToView ? 'disabled' : '' ?>>
                <option disabled>Izaberite tip</option>
                <?php foreach ($documentTypes as $documentType): ?>
                    <option value="<?= $documentType['id'] ?>" <?= $documentType['id'] == $document['documentTypeId'] ? 'selected' : '' ?>><?= $documentType['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-sm">
            <label for="documentTypeId">Dodao</label>
            <input value="<?= $document['username'] ?>" class="form-control mt-1" disabled />
        </div>
    </div>

    <div class="d-flex justify-content-end mt-2">
        <button class="btn btn-primary">Ažuriraj</button>
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

<script>
    $(document).ready(function () {
        $.ajax({
            url: "/documents/file/<?= $document['id'] ?>",
            type: "GET",
            xhrFields: {
                responseType: 'blob'
            },
            success: function (data) {
                const url = URL.createObjectURL(data);


                $("#tempDocFile").attr("src", url);
            }
        })

        // Disable forme ako korisnik nema dozvolu za editovanje
        const hasPermissionToEdit = <?= $hasPermissionToEdit ? 'true' : 'false' ?>;

        if (!hasPermissionToEdit) {
            $('#editForm').find('input, textarea, select, button').prop('disabled', true);
        }

    })
</script>

<?= $this->endSection() ?>