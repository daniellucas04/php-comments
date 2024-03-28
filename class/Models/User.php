<?php 

namespace Models;

use Connection\Statements;

class User {
    private $user;
    private $data;
    private $result;
    private $error;
    protected $accessToken;

    /**
     * getUser: Retorna o usuário logado.
     * @return string $error;
     */
    public function getUser() {
        return $this->user;
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

    public function checkLogin() {
        $this->accessToken = $_COOKIE['access_token'] ?? null;

        if ( !is_null($this->accessToken) ) {
            $statements = new Statements;
            $statements->select('logged', TB_USERS, 'WHERE access_token = "' . $this->accessToken . '"');
            if ( $statements->getRows() == 1 ) {
                $logged = $statements->getResult()[0]['logged'];
                if ( $logged == 'T' ) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function logout() {
        $statements = new Statements;
        $statements->select('id, logged', TB_USERS, 'WHERE access_token = "' . $this->accessToken . '"');
        if ( $statements->getRows() == 1 ) {
            $logged = $statements->getResult()[0]['logged'];
            $userID = $statements->getResult()[0]['id'];
            if ( $logged == 'T' ) {
                $statements->update(TB_USERS, array("logged" => "F"), 'WHERE id = ' . $userID);
                if ( $statements->getResult() ) { 
                    $this->result = true;
                    $this->error = 'Logout realizado com sucesso!';
                }
            }
        }
    }

    /**
     * exeLogin: Realiza o login do usuário.
     * @param array $data = Array atributivo com usuário e senha do usuário.
     */
    public function exeLogin($data) {
        $this->data = $data;
        
        if ( !$this->validate() ) {
            $this->result = false;
            $this->error = 'Erro no cadastro. Corriga os seguintes campos: <br> ' . $this->getError();
        } else {
            $this->login();
        }
    }
    
    /**
     * exeRegister: Realiza o cadastro do usuário.
     * @param array $data = Array atributivo com usuário e senha do usuário.
     */
    public function exeRegister($data) {
        $this->data = $data;
        
        if ( !$this->validate() ) {
            $this->result = false;
            $this->error = 'Erro no cadastro. Corriga os seguintes campos: <br> ' . $this->getError();
        } else {
            $this->register();
        }
    }

    private function validate() {
        $error = null;

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
        $statements->select('id, username, password', TB_USERS, 'WHERE username LIKE "%' . $this->data['username'] . '%"');
        if ( $statements->getRows() > 0 ) {
            // Usuário existe
            $user = $statements->getResult()[0];
            if ( $this->data['password'] == $user['password'] ) {
                $cookieValue = $user['username'] . $user['password'];
                setcookie('access_token', $cookieValue, 0, '/');
                // A senha está correta
                $statements->update(TB_USERS, array('logged' => 'T', 'access_token' => $cookieValue), 'WHERE id = ' . $user['id']);
                if ( $statements->getResult() ) {
                    // Realizou login
                    $this->result = true;
                    $this->error = 'Login realizado com sucesso. Aguarde o redirecionamento para os comentários.<br>';
                } else {
                    // Não realizou login
                    $this->result = false;
                    $this->error = 'Não foi possível realizar o login. Tente novamente mais tarde.<br>';
                }
            } else {
                // Senha incorreta
                $this->result = false;
                $this->error = 'Não foi possível realizar o login. Tente novamente mais tarde.<br>';
            }
        } else {
            // Usuário não existe
            $this->result = false;
            $this->error = 'Usuário não encontrado. <a href="http://' . URL_BASE . '/pages/register">Registre-se</a> agora!<br>';
        }
    }

    private function register() {
        $statements = new Statements;
        $statements->insert(TB_USERS, $this->data);
        if ( $statements->getResult() ) {
            // Sucesso ao cadastrar
            $this->result = true;
            $this->error = 'Cadastro realizado com sucesso. Você será redirecionado para o login.<br>';
        } else {
            // Erro
            $this->result = false;
            $this->error = 'Erro no cadastro. Tente novamente.<br>';
        }
    }
}
