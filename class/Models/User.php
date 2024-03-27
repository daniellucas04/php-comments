<?php 

namespace Models;

use Connection\Statements;

class User {
    private $user;
    private $data;
    private $result;
    private $error;

    /**
     * getUser: Retorna o usuário logado.
     * @return string $error;
     */
    public function getUser() {
        return $this->error;
    }


    /**
     * getError: Retorna uma mensagem em caso de erro ou vazio em caso de sucesso.
     * @return string $error;
     */
    public function getError() {
        return $this->error;
    }

    /**
     * getResult: Retorna se uma ação foi bem sucedida ou não.
     * @return bool $result;
     */
    public function getResult() {
        return $this->result;
    }

    /**
     * login: Realiza o login do usuário.
     * @param array $data = Array atributivo com usuário e senha do usuário.
     */
    public function exeLogin($data) {
        $this->data = $data;
        
        if ( !$this->validate() ) {
            echo '<div class="alert alert-danger">Erro no login. Corriga os seguintes campos: <br> ' . $this->getError() . '</div>';
        } else {
            $this->login();
        }
    }

    private function validate() {
        $error = null;

        var_dump($this->data);
        if ( empty($this->data['username']) ) { $error .= 'O campo <strong>Usuário</strong> é obrigatório.<br>'; }
        if ( empty($this->data['password']) ) { $error .= 'O campo <strong>Senha</strong> é obrigatório.<br>'; }
        
        $this->error = $error;
        if ( $error )
            return false;
        else 
            return true;
    }

    private function login() {
        $statements = new Statements;
        // $statements->select('username, password', TB_USERS, 'WHERE password LIKE "%' . $this->data['password'] . '%"');
        if ( $statements->getRows() > 0 ) {
            $users = $statements->getResult();
        }
    }
}
