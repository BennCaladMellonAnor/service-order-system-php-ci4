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

                <!-- Exibira os retornos do backend -->
                <div id="response">

                </div>

                <?= form_open('/', ['id' => 'form'], ['id' => "$user->id"]) ?>

                <?= $this->include('Users/_form')?>

                <div class="form-group mt-5 mb-2">
                    <input type="submit" value="Salvar" id="btn-salvar" class="btn btn-danger mr-2">
                    <a href="<?= site_url("users/")?>" class="btn btn-secondary ml-2">Voltar</a>

                </div>
            </div>
            
            <?= form_close()?>


        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>


    <script>
        $(document).ready(function(){
            $("#form").on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url("users/register")?>',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function(){
                        $("#response").html('');
                        $("#btn-salvar").val('Aguarde...');
                    },
                    success: function(response){
                        $("#btn-salvar").val('Salvar');
                        $("#btn-salvar").removeAttr('disabled');
                        $('[name=suck_my_dick]').val(response.token)
                        //Error de validação
                        if(!response.erro){
                            if(response.info){
                                $("#response").html('<div class="alert alert-info">'+response.info+'</div>'); 
                            }else{
                                //Tudo certo com a atualização do usuario
                                //Redicionar
                                
                                window.location.href = "<?= site_url("users/show/") ?>" + response.id;
                                
                            }
                            
                        }
                        
                        if(response.erro){
                            //Erros de validacao
                            $("#response").html('<div class="alert alert-danger">'+response.erro+'</div>'); 
                            
                            if(response.errors_model){
                                $.each(response.errors_model, function(key, value){
                                    $("#response").append('<ul class="list-unstyled"><li class="text-danger">'+ value +'</li></ul>'); 

                                });
                            }
                        }
                    },
                    error: function(){
                        alert("Não foi possível processar a solicitação. Tente novamente mais tarde!");
                        $("#btn-salvar").val('Salvar');
                        $("#btn-salvar").removeAttr('disabled');
                    }
                })
            })
            $('#form').submit(function(){
                $(this).find(":submit").attr('disabled', 'disabled')
            })
        })
    </script>

<?= $this->endSection() ?>

