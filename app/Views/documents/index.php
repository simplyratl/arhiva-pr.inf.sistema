<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>Dokumenta<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="d-flex justify-content-between align-items-center">
    <h1 class="card-title h4">Dokumenta</h1>
</div>

<form action="/" method="get" class="mt-3">
    <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Pretraži po nazivu"
            value="<?= esc($searchTerm) ?>">
        <button class="btn btn-outline-secondary" type="submit">Pretraži</button>
    </div>

    <div class="row">
        <div class="col-sm">
            <label for="sectorId">Sektor</label>
            <select class="form-select" id="sectorId" name="sectorId">
                <option value="0">Izaberite sektor</option>
                <?php foreach ($sectors as $sector): ?>
                    <option value="<?= $sector['id'] ?>" <?= $sector['id'] == $searchSector ? 'selected' : '' ?>>
                        <?= $sector['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm">
            <label for="documentTypeId">Tip dokumenta</label>
            <select class="form-select" id="documentTypeId" name="documentTypeId">
                <option value="0">Izaberite sektor</option>
                <?php foreach ($documentTypes as $docType): ?>
                    <option value="<?= $docType['id'] ?>" <?= $docType['id'] == $searchDocType ? 'selected' : '' ?>>
                        <?= $docType['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm">
            <label for="shelf">Polica</label>
            <input type="text" name="shelf" class="form-control" placeholder="Polica" value="<?= esc($searchShelf) ?>">
        </div>
        <div class="col-sm">
            <label for="shelfRow">Red</label>
            <input type="text" name="shelfRow" class="form-control" placeholder="Red"
                value="<?= esc($searchShelfRow) ?>">
        </div>
        <div class="col-sm">
            <label for="shelfColumn">Kolona</label>
            <input type="text" name="shelfColumn" class="form-control" placeholder="Kolona"
                value="<?= esc($searchShelfColumn) ?>">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm">
            <label for="createdAt">Datum dodavanja</label>
            <input type="date" name="createdAt" class="form-control" placeholder="Datum dodavanja"
                value="<?= esc($searchCreatedAt) ?>">
        </div>
        <div class="col-sm">
            <label for="userId">Dodao</label>
            <select class="form-select" id="userId" name="userId">
                <option value="0">Izaberite korisnika</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>" <?= $user['id'] == $searchUser ? 'selected' : '' ?>>
                        <?= $user['username'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

        </div>
    </div>
</form>
<div class="d-flex justify-content-end mt-3">
    <button class="btn btn-outline-danger" id="resetFilters">Obriši filtere</button>
</div>


<table class="table mt-3">
    <thead>
        <tr>
            <th scope="col">Naziv</th>
            <th scope="col">Tip dokumenta</th>
            <th scope="col">Sektor</th>
            <th scope="col">Dodao</th>
            <th scope="col">Datum dodavanja</th>
            <th scope="col">Akcije</th>
        </tr>
    </thead>
    <tbody>
        <?php $index = 0; ?>
        <?php foreach ($documents as $document): ?>
            <tr>
                <td>
                    <?= $document['name'] ?>
                </td>
                <td>
                    <?= $document['documentTypeName'] ?>
                </td>
                <td>
                    <?= isset($document['sectorName']) ? $document['sectorName'] : '' ?>
                </td>
                <td>
                    <?= $document['username'] ?>
                </td>
                <td>
                    <?= (new DateTime($document['createdAt']))->format('d.m.Y H:i') ?>
                </td>
                <td>
                    <a href="/update/<?= $document['id'] ?>" class="btn btn-outline-primary" role="button">
                        <i class="bi <?= in_array('director', auth()->user()->getGroups()) || (
                            $document['privacy'] == 'CONFIDENTIAL'
                        ) ? 'bi-eye' : 'bi-pencil' ?>"></i>
                    </a>

                    <?php if (in_array('admin', auth()->user()->getGroups())): ?>
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                            data-id="<?= $document['id'] ?>" data-index="<?= $index ?>">
                            <i class="bi bi-trash"></i>
                        </button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php $index++; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="deleteForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Modal title</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Da li ste sigurni da želite da obrišete ovaj dokument?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
                    <button class="btn btn-danger" type="submit">Obriši</button>
                </div>

                <input type="hidden" name="id" id="documentId">
            </form>
        </div>
    </div>
</div>

<script>
    $('#deleteModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const id = button.data('id'); // Extract info from data-* attributes
        const index = button.data('index');
        const document = <?= json_encode($documents) ?>[index];


        $(this).find('#deleteModalLabel').text(document.name);
        $('#documentId').val(document.id);
    });

    $('#deleteForm').on('submit', function (event) {
        event.preventDefault();

        const id = $("#documentId").val();

        $.ajax({
            url: `/${id}`,
            method: 'DELETE',
            success: function () {
                window.location.href = '/';
            }
        })
    })

    $('#resetFilters').on('click', function () {
        window.location.href = '/';
    })
</script>


<?= $this->endSection() ?>