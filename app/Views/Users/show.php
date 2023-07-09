<?= $this->extend('Layout/main.php') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-sm-4 bg-dark p-2">
        <div class="block">
            <div class="text-center">
                <?php if($user->img == null):?>
                    <img src="<?= site_url("sources/img") ?>/21315r1dA.jpg" alt="Usuário sem Imagem" class="card-img-top" style="width:90%;">
                    <?php else:?>
                        <img src="<?= site_url("users/show_image/$user->img") ?>" alt="<?= esc($user->fullname)?>" class="card-img-top rounded">

                <?php endif ?>

                <a href="<?= site_url("users/editimage/$user->id") ?>" class="btn btn-outline-info  btn-sm mt-3">Alterar Imagem</a>
            </div>

            <hr class="border-secondary">

            <h5 class="card-title mt-2"><?= esc($user->fullname) ?></h5>
            <p class="card-text">E-mail: <?= esc($user->email)?></p>
            <p class="card-text">Criado em: <?= $user->created_in->humanize()?></p>
            <p class="card-text">Atualizado em: <?= $user->updated_in->humanize()?></p>

            <!-- Example single danger button -->
            <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Ações
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= site_url("users/edit/$user->id")?>">Editar Usuário</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= site_url("users/delete/$user->id")?>">Excluir Usuário</a>
                </div>
            </div>

            <a href="<?= site_url("users")?>" class="btn btn-secondary ml-2">Voltar</a>

        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>

