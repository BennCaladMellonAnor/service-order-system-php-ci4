<?php

namespace App\Controllers;

use App\Libraries\Authentication;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Login"
        ];

        return view("Login/index", $data);
    }

    public function login(){
        //if(!$this->request->isAJAX()){
            //return redirect()->back();
        //}
        $authentication = service('authentication');    

        $post = $this->request->getPost();
        unset($post['honeypot']);

        $send_back = [
             'token' => csrf_hash(),
        ];

        if($post){
            $isLogged = $authentication->login($post['credential'], $post['password']);
        }else{
            // $isLogged = $authentication->login("gnungagap", "@12345678");
        }
        if(!$isLogged){
            $send_back = [
                'info' => "Credencial ou Senha Inválidos!"
            ];
        }

        //Recupera o usuario logado
        $userLogged = $authentication->getLoggedUser();

        session()->setFlashData('success', "Bem-vindo de volta $userLogged->fullname !!! ");

        $send_back['redirect'] = 'schedule';

        //Retorno para o AJAX request
        return $this->response->setJSON($send_back);
    }
    public function logout(){
        service('authentication')->logout();
        
        return redirect()->to(site_url("login/showMessageLogout"));
    }
    
    public function showMessageLogout(){
        return redirect()->to(site_url("login"))->with('success', 'Deslogado com sucesso!');

    }
}
