<?= $this->extend('Layout/main.php') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>

    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>
    <style>
        .dot{
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 5px;
        }
    </style>

<?= $this->endSection() ?>

<?= $this->section('content') ?>




<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row pt-1">
                    <h3 class="card-title">Ações de acesso rápido:</h3>
                </div>
                <div class="row p-1">
                    <a href="<?= site_url('/users/make')?>" class="btn btn-danger">Criar novo usuário</a>
                </div>
            </div>
            
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
            <table class="table table-head-fixed text-nowrap" id="ajaxTable" style="width:100%;">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Status</th>
                </tr>
                </thead>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#ajaxTable').DataTable({
                ajax: '<?= site_url('users/req_users')?>',
                columns: [
                    { data: 'img' },
                    { data: 'fullname' },
                    { data: 'email' },
                    { data: 'active' },
                ],
            });
        });
    </script>

<?= $this->endSection() ?>

