<?php if(session()->has('success')):?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucesso. </strong><?= session('success') ?>
        <button type="button" class="close text-light" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif?>
<?php if(session()->has('info')):?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info! </strong><?= session('info') ?>
        <button type="button" class="close text-light" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif?>
<?php if(session()->has('errors_model')):?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        
        <ul>
            <?php foreach($errors_model as $error):?>
                <li class="text-danger">
                    <?= session('errors_model') ?><strong>. Erro!</strong>
                </li>
            <?php endforeach?>
        </ul>
            
        <button type="button" class="close text-light" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif?>