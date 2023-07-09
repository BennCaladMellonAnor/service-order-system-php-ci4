<?php
    namespace App\Libraries;

    class Authentication{
        private $user;
        private $userModel;

        public function __construct(){
            $this->userModel = new \App\Models\UserModel();
        }

        /**
         * Método que realiza o login na aplicação
         * 
         * @param string $credential
         * @param string $password
         * @return boolean
         */
        public function login(string $credential, string $password): bool {

            $user = $this->userModel->searchUserByCredential($credential);
            if($user === null){
                return false;
            }

            //Verificamos se a senha é valida
            if($user->verifyPassword($password) == false){
                return false;
            };

            if($user->active == false){
                return false;
            }

            $this->loginUser($user);
            
            return true;
        }
        
        public function logout(): void{
            session()->destroy();
        }
        
        public function getLoggedUser(){
            if($this->user === null){
                $this->user = $this->getLoggedUserSession();
            }

            return $this->user;
        }


        /**
         * Verifica se o Usuário está logado
         * 
         * @return boolean
         */
        public function areLoggedUser(): bool{
            return $this->getLoggedUser() !== null;
        }

        /**
         * Método que insere na sessão o id do usuário
         * 
         * @param object $user
         * @return void
         */
        private function loginUser(object $user): void{
            $session = session();

            $session->regenerate();
            $session->set('nutzer', $user->id);
        }

         /**
         * Pega usuário logado da sessão
         * 
         * @return null|object
         */
        private function getLoggedUserSession(){
            if(!session()->has('nutzer')){
                return null;
            }

            $user = $this->userModel->find(session()->get('nutzer'));

            if($user == null | !$user->active){
                return null;
            }

            return $user;
        }

    };

?>