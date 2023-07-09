<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $dates   = ['created_in', 'updated_in', 'deleted_in'];

    /**
     * Método que verifica se a senha é válida
     * 
     * @param $password
     * @return boolean
     */
    public function verifyPassword(string $password):bool{
        
        return password_verify($password, $this->password_hash);
    }
}
