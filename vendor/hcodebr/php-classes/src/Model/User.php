<?php

namespace Hcode\Model;

use \Hcode\DB\Sql; 
use \Hcode\Model; 
use \Hcode\Mailer;
use \Hcode\Model\Cart;

class User extends Model {

    const SESSION = "User";
    /*const SECRET = "HcodePhp7_Secret";
    const SECRET_IV = "Ecommerce_Secret";
    const ERROR = "UserError";
    const ERROR_REGISTER = "UserErrorRegister";
    const SUCCESS = "UserSuccess";*/

    public static function login($login, $password)
    {
        $sql = new Sql();
        
        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
            ":LOGIN"=>$login
        ));
        
        if (count($results) === 0)
        {
            throw new \Exception("Usuário inexistente ou senha inválida.");
        }
        
        $data = $results[0];
        
        if (password_verify($password, $data["despassword"]) === true)
        {
            $user = new User();
            //$data['desperson'] = utf8_encode($data['desperson']);
            $user->setData($data);
            $_SESSION[User::SESSION] = $user->getValues();
            return $user;
        
        } else {
            throw new \Exception("Usuário inexistente ou senha inválida.");
        }
    }

    public static function verifyLogin($inadmin = true)
    {
        if(
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
            ||
            (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
            
        ) {

            header("Location: / admin/login");
            exit;

            //Não está logado
            return false; 
        } else {

            if($inadmin === true && (bool) $_SESSION[User::SESSION]["inadmin"] === true) {
                return true;
            
            } else if ($inadmin === false) {
                return true;
            
            } else {
                return false; 

        }
    }
}

    public static function logout()
    {  
    $_SESSION[User::SESSION] = NULL; 
    }   
}

?>