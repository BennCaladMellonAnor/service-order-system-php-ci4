<?= $this->extend('Layout/main.php') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-sm-6 bg-dark p-2">
        <div class="block">

            <div class="block-body">

                <?= form_open("users/delete/$user->id") ?>
                
                <div class="alert alert-warning" role="alert">
                    Tem certeza que irá excluir o registro?
                </div>
                <div class="form-group mt-5 mb-2">
                    <input type="submit" value="Confirmar Exclusão" id="btn-salvar" class="btn btn-danger mr-2">
                    <a href="<?= site_url("users/show/$user->id") ?>" class="btn btn-secondary ml-2">Voltar</a>

                </div>
            </div>

            <?= form_close() ?>


        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>


<?= $this->endSection() ?>