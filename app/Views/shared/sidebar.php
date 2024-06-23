<?php if (auth()->loggedIn()): ?>
    <div class="d-flex flex-column flex-shrink-0 p-3 sidebar" style="width: 260px; background: #fff">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="#bootstrap" />
            </svg>
            <span class="fs-4">Sidebar</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto" id="nav-list">
            <div>
                <p class="text-muted">Dokumenta</p>

                <li class="nav-item">
                    <a href="/" class="nav-link">
                        <i class="bi bi-file-earmark me-2"></i>
                        Dokumenta
                    </a>
                </li>
                <li>
                    <a href="/temp-documents" class="nav-link">
                        <i class="bi bi-file-earmark-break me-2"></i>
                        Privremena dokumenta
                    </a>
                </li>
            </div>
            <?php if (in_array("admin", auth()->user()->getGroups())): ?>
                <div class="mt-3">
                    <p class="text-muted">Administracija</p>
                    <li>
                        <a href="/sectors" class="nav-link">
                            <i class="bi bi-building me-2"></i>
                            Sektori
                        </a>
                    </li>
                    <li>
                        <a href="/document-types" class="nav-link">
                            <i class="bi bi-journals me-2"></i>
                            Tip dokumenta
                        </a>
                    </li>
                </div>
            <?php endif; ?>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/Breezeicons-actions-22-im-user.svg/1200px-Breezeicons-actions-22-im-user.svg.png"
                    alt="" width="32" height="32" class="rounded-circle me-2" style="object-fit: cover;">
                <strong><?= auth()->user()->username ?></strong>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><a class="dropdown-item" href="<?= url_to("logout") ?>">Odjavi se</a></li>
            </ul>
        </div>
    </div>
<?php endif; ?>

<script>
    $(document).ready(function () {
        // URL trenutne strane koji brise index.php i index.php/ iz URL-a
        const url = window.location.pathname;
        const currUrl = url.replace(/(index)?\.php\/?/, '');

        $("#nav-list a.nav-link").each(function () {
            $(this).removeClass("active");
            $(this).addClass("link-dark")
        })

        if (currUrl === "/") {

            $("#nav-list a.nav-link").first().addClass('active');
            $("#nav-list a.nav-link").first().removeClass("link-dark");

            return;
        }

        $("#nav-list a.nav-link").each(function () {
            if (this.pathname === currUrl || this.pathname.includes(currUrl)) {
                $(this).addClass('active');
                $(this).removeClass("link-dark");
            }
        })

    })
</script>

<style>
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
    }
</style>