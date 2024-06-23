<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>Sektori<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="d-flex justify-content-between align-items-center">
    <h1 class="card-title h4">Sektori</h1>
    <a href="/sectors/create">
        <button class="btn btn-primary">
            <span>Dodaj</span>
        </button>
    </a>
</div>

<form action="/sectors" method="get" class="mt-3">
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
        <?php foreach ($sectors as $sector): ?>
            <tr>
                <td>
                    <?= $sector['name'] ?>
                </td>
                <td>
                    <?= (new DateTime($sector['createdAt']))->format('d.m.Y H:i') ?>
                </td>
                <td>
                    <a href="/sectors/update/<?= $sector['id'] ?>" class="btn btn-outline-primary" role="button">
                        <i class="bi bi-pencil"></i>
                    </a>

                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                        data-id="<?= $sector['id'] ?>" data-index="<?= $index ?>">
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
                    Da li ste sigurni da želite da obrišete ovaj sektor?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
                    <button class="btn btn-danger" type="submit">Obriši</button>
                </div>

                <input type="hidden" name="id" id="sectorId">
            </form>
        </div>
    </div>
</div>

<script>
    $('#deleteModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const id = button.data('id'); // Extract info from data-* attributes
        const index = button.data('index');
        const sector = <?= json_encode($sectors) ?>[index];


        $(this).find('#deleteModalLabel').text(sector.name);
        $('#sectorId').val(sector.id);
    });

    $('#deleteForm').on('submit', function (event) {
        event.preventDefault();

        const id = $("#sectorId").val();

        $.ajax({
            url: `/sectors/${id}`,
            method: 'DELETE',
            success: function () {
                window.location.href = '/sectors';
            }
        })
    })
</script>


<?= $this->endSection() ?>