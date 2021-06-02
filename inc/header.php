<header class="border-bottom mb-3">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><?=$GLOBALS['SiteName'];?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?=site_path();?>alunos/alunos" aria-current="page">Alunos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=site_path();?>professores/professores" aria-current="page">Professores</a>
                </li>
            </ul>
        </div>
    </div>
    </nav>
</header>