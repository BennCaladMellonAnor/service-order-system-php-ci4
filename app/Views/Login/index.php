<?= $this->extend('Layout/login.php') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="" id="response"></div>

    <?= form_open('/', ['id' => 'form'], [])?>

    <?= $this->include('Layout/_message')?>
        <?= $this->include('Login/_form')?>

    <?= form_close()?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        $(document).ready(function(){
            $("#form").on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url("login/login")?>',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function(){
                        $('#repsonse').html('');
                        $('#btn').val('Aguarde...');
                    },
                    success: function(response){
                        $('#btn').removeAttr('disabled');
                        $('#btn').val('Validar Acesso');
                        $('[name=suck_my_dick]').val(response.token)
                        
                        //Erro de Validação
                        if(!response.erro){
                            if(response.info){
                                $("#response").html('<div class="alert alert-info">'+response.info+'</div>');
                            }else{
                                window.location.href = "<?= site_url() ?>" + response.redirect
                            }
                            
                        }else{
                            $("#response").html('<div class="alert alert-danger">'+response.erro+'</div>');
                        }
                        
                    },
                    error: function(xhr, status, error){
                        alert('Erro na requisão de acesso!!! Se o Error persistir recarrega a página e tente novamente')
                        $('#btn').removeAttr('disabled');
                        $('#btn').val('Validar Acesso');
                    },
                })
            })
            $('#form').submit(function(){
                $(this).find(":submit").attr('disabled', 'disabled')
            })
        })
    </script>

<?= $this->endSection() ?>
