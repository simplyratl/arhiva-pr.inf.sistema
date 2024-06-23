<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>Izmjena <?= $document['name'] ?><?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="d-flex justify-content-between align-items-center">
    <h1 class="card-title h4">Izmjena <?= $document['name'] ?></h1>
</div>

<form action="/temp-documents/update-req/<?= $document['id'] ?>" method="POST" enctype="multipart/form-data"
    id="editForm">
    <div class="w-100" style="height: 700px;">
        <iframe id="tempDocFile" frameborder="0" class="w-100 h-100"></iframe>
    </div>

    <div class="d-flex flex-column gap-4 mt-5 pb-5">
        <div class="row">
            <div class="col-sm">
                <label for="name">Naziv</label>
                <input value="<?= $document['name'] ?>" type="text" class="form-control mt-1" placeholder="Naziv"
                    id="name" name="name">
            </div>
            <div class="col-sm">
                <label for="boxNumber">Broj kutije</label>
                <input value="<?= $document['boxNumber'] ?>" type="text" class="form-control mt-1"
                    placeholder="Broj kutije" id="boxNumber" name="boxNumber">
            </div>
        </div>

        <div class="row">
            <div class="col-sm">
                <label for="registerNumber">Broj registra</label>
                <input value="<?= $document['registerNumber'] ?>" type="text" class="form-control mt-1"
                    placeholder="Broj registra" id="registerNumber" name="registerNumber">
            </div>
            <div class="col-sm">
                <label for="documentTypeId">Tip dokumenta</label>
                <select class="form-select" a id="documentTypeId" name="documentTypeId"
                    selected="<?= $document['documentTypeId'] ?>">
                    <option disabled>Izaberite tip</option>
                    <?php foreach ($documentTypes as $documentType): ?>
                        <option value="<?= $documentType['id'] ?>" <?= $documentType['id'] == $document['documentTypeId'] ? 'selected' : '' ?>><?= $documentType['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-sm">
                <label for="document">Dokument</label>
                <input class="form-control" type="file" id="document" name="document" accept=".pdf">
            </div>
            <div class="col-sm">
                <label>Dodao</label>
                <input value="<?= $document['username'] ?>" type="text" class="form-control" disabled>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-2 gap-2">
            <button type="button" class="btn btn-outline-primary" id="addAsDocument">Dodaj kao trajni dokument</button>
            <button class="btn btn-primary">Ažuriraj</button>
        </div>
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
            url: "/temp-documents/file/<?= $document['id'] ?>",
            type: "GET",
            xhrFields: {
                responseType: 'blob'
            },
            success: function (data) {
                const url = URL.createObjectURL(data);


                $("#tempDocFile").attr("src", url);
            }
        })

        $("#addAsDocument").click(function () {
            $.ajax({
                url: "/temp-documents/add-as-document/<?= $document['id'] ?>",
                type: "POST",
                success: function () {
                    window.location.href = "/";
                }
            })
        })

        // ako je direktor, nema pravo da mijenja dokument
        const hasPermissionToEdit = <?= !in_array('director', auth()->user()->getGroups()) ? 'true' : 'false' ?>;

        if (!hasPermissionToEdit) {
            $('#editForm').find('input, textarea, select, button').prop('disabled', true);
        }
    })
</script>

<?= $this->endSection() ?>