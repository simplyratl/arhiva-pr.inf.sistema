<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>Tip dokumenta<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="d-flex justify-content-between align-items-center">
    <h1 class="card-title h4">Tip dokumenta</h1>
    <a href="/document-types/create">
        <button class="btn btn-primary">
            <span>Dodaj</span>
        </button>
    </a>
</div>

<form action="/document-types" method="get" class="mt-3">
    <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Pretraži po nazivu"
            value="<?= esc($searchTerm) ?>">
        <button class="btn btn-outline-secondary" type="submit">Pretraži</button>
    </div>
</form>


<table class="table mt-3">
    <thead>
        <tr>
            <th scope="col">Naziv</th>
            <th scope="col">Datum dodavanja</th>
            <th scope="col">Akcije</th>
        </tr>
    </thead>
    <tbody>
        <?php $index = 0; ?>
        <?php foreach ($documentTypes as $document): ?>
            <tr>
                <td>
                    <?= $document['name'] ?>
                </td>
                <td>
                    <?= (new DateTime($document['createdAt']))->format('d.m.Y H:i') ?>
                </td>
                <td>
                    <a href="/document-types/update/<?= $document['id'] ?>" class="btn btn-outline-primary" role="button">
                        <i class="bi bi-pencil"></i>
                    </a>

                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                        data-id="<?= $document['id'] ?>" data-index="<?= $index ?>">
                        <i class="bi bi-trash"></i>
                    </button>
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
                    Da li ste sigurni da želite da obrišete ovaj tip dokumenta?
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
        const document = <?= json_encode($documentTypes) ?>[index];


        $(this).find('#deleteModalLabel').text(document.name);
        $('#documentId').val(document.id);
    });

    $('#deleteForm').on('submit', function (event) {
        event.preventDefault();

        const id = $("#documentId").val();

        $.ajax({
            url: `/temp-documents/${id}`,
            method: 'DELETE',
            success: function () {
                window.location.href = '/temp-documents';
            }
        })
    })
</script>


<?= $this->endSection() ?>