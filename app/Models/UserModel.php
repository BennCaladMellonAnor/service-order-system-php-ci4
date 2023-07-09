<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';

    protected $returnType       = 'App\Entities\User';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'name',
        'email',
        'password',
        'reset_hash',
        'reset_expires',
        'img',
    ];

    // Dates
    protected $useTimestamps = true;
    // protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_in';
    protected $updatedField  = 'updated_in';
    protected $deletedField  = 'deleted_in';

    // Validation
    protected $validationRules = [
        'fullname'         => 'required|min_length[3]|max_length[120]',
        'email'        => 'required|valid_email|max_length[240]|is_unique[users.email,id,{id}]',
        'password'     => 'required|min_length[8]',
        'password_confirmation' => 'required_with[password]|matches[password]',
    ];
    protected $validationMessages = [
        'fullname' => [
            'required'   => 'O campo nome é obrigatório',
            'min_lenght' => 'O nome precisa ter no minimo três caracteres',
            'max_lenght' => 'O Campo nome excedeu o tamanho maximo!',
        ],
        'email' => [
            'required'   => 'O campo e-mail é obrigatório',
            'min_lenght' => 'O email precisa ter no minimo três caracteres',
            'max_lenght' => 'O Campo email excedeu o tamanho maximo!',
            'is_unique'  => 'Esse e-mail ja foi registrado, use outro!'
        ],
        'password_confirmation' => [
            'required_with'   => 'A confirmação da senha é obrigatório!',
            'min_lenght' => 'O Tamanho minimo para a senha é 8 caracteres!',
            'matches'  => 'As senha devem conferir!'
        ],
    ];

    // Callbacks
    // protected $allowCallbacks = true;
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    // protected $afterInsert    = [];
    // protected $afterUpdate    = [];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']);
            unset($data['data']['password_confirmation']);
            
        }


        return $data;
    }

    

    /**
     * Método que recupera o usuário para logar, através da credencial
     * @param string $credential
     * @return null|object
     */
    public function searchUserByCredential(string $credential){

        $user_data = $this->where('credential', $credential)->where('deleted_in', null)->first();

        return $user_data;
    }
}
