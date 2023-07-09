<div class="form-group">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $title?> <?= $user->fullname?></h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome Completo</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter name" value="<?= esc($user->fullname)?>" name="fullname">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">E-mail</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?= esc($user->email)?>" name="email">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Senha</label>
                    <input type="password" class="form-control" id="exampleInputEmail1" placeholder="Enter password" name="password">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Confirmar Senha</label>
                    <input type="password" class="form-control" id="exampleInputEmail1" placeholder="Re-enter password" name="password_confirmation">
                </div> 

                <div class="custom-control custom text-muted">
                    <input type="hidden" name="active" value="0">

                    <input type="checkbox" name="active" value="1" id="ativo" <?php if($user->active == true):?> checked <?php endif ?> >

                    <label for="ativo" class="">Usuário ativo</label>
                </div>
            </div>
    </div>
    <!-- /.card -->
</div>