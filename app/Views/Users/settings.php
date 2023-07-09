<?= $this->extend('Layout/main.php') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Perfil</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?= site_url('admin_lte')?>/dist/img/<?= $img_profile ?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?= $name ?></h3>

                <p class="text-muted text-center"><?= $email ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul>

                <a href="#" class="btn btn-danger btn-block"><b>Editar dados pessoais</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Informações</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i>Cargo</strong>

                <p class="text-muted">
                  Recepcionista
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i>Endereço</strong>

                <p class="text-muted">Rua Castanho da Silva, 567 - São Paulo - SP, 08460-348</p>
                
                <hr>
                
                <strong><i class="fas fa-pencil-alt mr-1"></i>Contato</strong>
                
                <p class="text-muted">lucas.limamonteiro@hotmail.com</p>
                <p class="text-muted">(11) 9 6804-2294 - Whatsapp</p>
                <p class="text-muted">(11) 9 96648-9100 - Mãe (Elisangela)</p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Criado em: 20/05/2023 11:20</p>
                <p class="text-muted">Ativo desde: 10 dias.</p>
                <p class="text-muted">Atualizado em: 2 dias.</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#system_settings" data-toggle="tab">Configurações do Sistema</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Profile Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div id="response">

                  </div>
                  <?= form_open('/', ['id' => 'form_ss'], ['id' => session('nutzer')])?>
                    <?= $this->include("Users/forms/system_settings") ?>
                  <?= form_close() ?>
                  <?= $this->include("Users/forms/timeline") ?>
                  <?= $this->include("Users/forms/profile_settings") ?>
                  

                  
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

  <script>
        $(document).ready(function(){
            $("#form_ss").on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url("users/insert_settings")?>',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function(){
                        $("#response").html('');
                        $("#btn_agreement").val('Aguarde...');
                        var result = confirm('Inserir?');
                        if(!result){
                          //Cancelar a requisião aqui
                          //window.location.href = "<?= site_url("users/settings") ?>"
                        }
                    },
                    success: function(response){
                        $("#btn-salvar").val('Salvar');
                        $("#btn-salvar").removeAttr('disabled');
                        $('[name=suck_my_dick]').val(response.token)
                        //Error de validação
                        $("#response").html('<div class="alert alert-info">'+response.info+'</div>'); 
                        console.log(response.data);
                        //window.location.href = "<?= site_url("users/settings") ?>"
                        
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
                        alert('Houve um erro na sua Requisão!');
                        $("#btn_agreement").val('Cadastrar');
                        $("#btn_agreement").removeAttr('disabled');
                    }
                })
            })
            $('#form_ss').submit(function(){
                $(this).find(":submit").attr('disabled', 'disabled')
            })
        })
    </script>

<?= $this->endSection() ?>
