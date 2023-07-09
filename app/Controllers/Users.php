<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;

class Users extends BaseController
{
    private $userModel;
    private $menu;
    private $tmp_post;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
        $this->menu = [
            [
                'name' => 'Home',
                'link' => site_url('/users'),
            ],
            [
                'name' => 'Make',
                'link' => site_url('/users/make'),
            ],
            [
                'name' => 'Settings',
                'link' => site_url('/users/settings'),
            ],
            [
                'name' => 'Login',
                'link' => site_url('/users/login'),
            ],

        ];
    }

    public function index()
    {
        // $this->userModel->findAll();

        $data = [
            'title' => 'Listando os Usuario do Sistema',
            'menu' => $this->menu,
        ];

        return view('Users/index', $data);
    }

    public function settings()
    {
        $user = $this->searchForUserOr404(session('nutzer'));
        $data = [
            'title' => 'Configurações',
            'menu' => $this->menu,
            'img_profile' => '336072853_140115025447104_2532588535359477190_n.jpg',
            'name' => esc($user->fullname),
            'email' => esc($user->email),
        ];

        return view('/users/settings', $data);
    }
    public function insert_settings()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $send_back = [
            'token' => csrf_hash(),
        ];

        $post = $this->request->getPost();
        $submit = 'agreement';

        switch ($submit) {
            case 'agreement':
                $send_back = [
                    'info' => 'Agreement Updated',
                    'data' => $post,
                ];
                break;
            default:
        }

        return $this->response->setJSON($send_back);
    }

    public function req_users()
    {
        // if(!$this->request->isAJAX()){
        //     return redirect()->back();
        // }

        $attributes =  [
            'id',
            'fullname',
            'email',
            'active',
            'img',
        ];

        $users = $this->userModel->select($attributes) 
            ->withDeleted(true)
            ->orderBy('id', 'DESC')
            ->findAll();

        $data = [];

        //echo "<pre>";
        //print_r($users);

        foreach ($users as $user) {

            if($user->img != null){
                $image = [
                    'src' => site_url("users/show_image/$user->img"),
                    'class' => 'rounded-circle img-fluid',
                    'alt' => esc($user->fullname),
                    'width' => '50',
                ];
            }else{
                $image = [
                    'src' => site_url("sources/img/default.jpg"),
                    'class' => 'rounded-circle img-fluid',
                    'alt' => 'Usuário sem Imagem',
                    'width' => '50',
                ];
            }

            $data[] = [
                'img' => img($image),
                'fullname' => anchor("users/show/$user->id", esc($user->fullname), 'title="Exibir usuário ' . esc($user->fullname) . '"'),
                'email' => esc($user->email),
                'active' => $user->active == true ? '<i class="fa fa-lock-open text-success"></i>&nbsp;Ativo' : '<i class="fa fa-lock text-danger"></i>&nbsp;Inativo',
            ];
        }

        $return_data = [
            'data' => $data,
        ];

        return $this->response->setJSON($return_data);
    }

    public function register()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $retorno = [
            'token' => csrf_hash(),
        ];

        //Pega o post da requisição
        $post = $this->request->getPost();
        unset($post['honeypot']);

        //Criando um novo objeto da entidade usuario/user
        $user = new User($post);

        if ($this->userModel->protect(false)->save($user)) {

            $btnCriar = anchor("users/make", "Criar novo usuário", ['class' => 'btn btn-danger']);


            //Vamos conhecer mensagens de flashdata
            session()->setFlashdata('success', "$btnCriar <br>Dados Criados com.");

            //Retornando o ultimo id inserido na tabela com o userModel
            $retorno['id'] = $this->userModel->getInsertID();

            return $this->response->setJSON($retorno);
        }

        //Retornando os erros de validação
        $retorno['erro'] = "Verifique os campos digitados e os erros de validação e tente novamente";
        $retorno['errors_model'] = $this->userModel->errors();


        //Retorno para o AJAX request
        return $this->response->setJSON($retorno);
    }

    public function make()
    {

        $user = new User();

        $data = [
            'title' => "Criando novo usuário",
            'user' => $user,
            'menu' => $this->menu,

        ];
        return view('Users/make', $data);
    }

    public function show(int $id = null)
    {
        $user = $this->searchForUserOr404($id);

        $data = [
            'title' => "Detalhando o usuário " . esc($user->fullname),
            'user' => $user,
            'menu' => $this->menu,

        ];
        return view('Users/show', $data);
    }

    public function edit(int $id = null)
    {
        $user = $this->searchForUserOr404($id);

        $data = [
            'title' => "Editando o usuário " . esc($user->fullname),
            'user' => $user,
            'menu' => $this->menu,

        ];
        return view('Users/edit', $data);
    }

    public function update()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $retorno = [
            'token' => csrf_hash(),
        ];

        //Pega o post da requisição
        $post = $this->request->getPost();
        unset($post['honeypot']);

        //Validando a existencia do usuário
        $user = $this->searchForUserOr404($post['id']);

        if (empty($post['password'])) {
            unset($post['password']);
            unset($post['password_confirmation']);
        }



        //Preenchemos os atributos do usuario com os valores do post
        $user->fill($post);

        if (!$user->hasChanged()) {
            $retorno = [
                'info' => "Não a dados para serem atualizados"
            ];
        }

        if ($this->userModel->protect(false)->save($user)) {
            //Vamos conhecer mensagens de flashdata
            session()->setFlashdata('sucesso', 'Dados salvos com sucesso. ');

            return $this->response->setJSON($retorno);
        }

        //Retornando os erros de validação
        $retorno['erro'] = "Verifique os campos digitados e os erros de validação e tente novamente";
        $retorno['errors_model'] = $this->userModel->errors();


        //Retorno para o AJAX request
        return $this->response->setJSON($retorno);
    }

    public function editimage(int $id = null)
    {
        $user = $this->searchForUserOr404($id);

        $data = [
            'title' => "Alterando a imagem do usuário " . esc($user->fullname),
            'user' => $user,
            'menu' => $this->menu,

        ];
        return view('Users/edit_image', $data);
    }

    public function upload()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $retorno = [
            'token' => csrf_hash(),
        ];

        //Regras de validação para imagens

        $validation = service('validation');

        $rules = [
            'image' => 'uploaded[image]|max_size[image,2048]|ext_in[image,png,jpg,gif,jpeg,webp]',
        ];

        $messages = [
            'image' => [
                'uploaded' => 'Nenhuma imagem selecionada!',
                'max_size' => 'Imagem excedeu o tamanho limite 2048bits',
                'ext_in' => 'A imagem selecionada não está em um formato válido!',
            ],
        ];

        $validation->setRules($rules, $messages);

        if ($validation->withRequest($this->request)->run() == false) {
            $retorno['erro'] = "Verifique os erros a seguir";
            $retorno['errors_model'] = $validation->getErrors();


            //Retorno para o AJAX request
            return $this->response->setJSON($retorno);
        }

        //Pega o post da requisição
        $post = $this->request->getPost();
        $file = $this->request->getFile('image');
        unset($post['honeypot']);

        //Validando a existencia do usuário
        $user = $this->searchForUserOr404($post['id']);


        list($largura, $altura) = getimagesize($file->getPathName());

        if ($largura < "128" || $altura < "128") {
            $retorno['erro'] = "Verifique os erros a seguir";
            $retorno['errors_model'] = ['dimensao' => 'A imagem não pode ser menos que 128 x 128 pixels'];


            //Retorno para o AJAX request
            return $this->response->setJSON($retorno);
        }

        $path = $file->store('users');

        $path = WRITEPATH . "uploads/$path";


        //here
        $this->manipulate_image($path, $user->id);

        //Atualizar a tabel de usuários;

        $old_image = $user->img;

        $user->img = $file->getName();

        $this->userModel->save($user);

        if ($old_image != null) {
            $this->remove_image_of_file_system($old_image);
        }

        session()->setFlashdata('success', "Imagem atualizada com sucess");


        //Retorno para o AJAX request
        return $this->response->setJSON($retorno);
    }

    public function show_image(string $image = null){
        if($image != null){
            $this->show_file('users', $image);
        }
    }

    public function delete(int $id = null)
    {
        $user = $this->searchForUserOr404($id);

        if($this->request->getMethod() === 'post'){

            $this->userModel->delete($user->id);

            if($user->img != null){
                $this->remove_image_of_file_system($user->img);
            }

            $user->img = null ;
            $user->active = false;

            $this->userModel->protect(false)->save($user);

            return redirect()->to(site_url('users'))->with('success', "Usuário $user->fullname deletado!");

        }

        $data = [
            'title' => "Excluíndo o usuário " . esc($user->fullname),
            'user' => $user,
            'menu' => $this->menu,

        ];
        return view('Users/delete', $data);
    }

    //Metodo que recupera o usuario do banco
    private function searchForUserOr404(int $id = null)
    {
        if (!$id || !$user = $this->userModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não Encontramos o usuário $id");
        }

        return $user;
    }

    private function remove_image_of_file_system(string $image)
    {
        $path = WRITEPATH . "uploads/users/$image";

        if (is_file($path)) {
            unlink($path);
        }
    }

    private function manipulate_image(string $path, int $id)
    {
        service('image')
            ->withFile($path)
            ->fit(300, 300, 'center')
            ->save($path);


        $actual_year = date('d/m/Y H:i:s');

        \Config\Services::image('imagick')
            ->withFile($path)
            ->text("SO - $actual_year - $id", [
                'color'      => '#fff',
                'opacity'    => 0.2,
                'withShadow' => false,
                'hAlign'     => 'right',
                'vAlign'     => 'bottom',
                'fontSize'   => 5,
            ])
            ->save($path);
    }
}
