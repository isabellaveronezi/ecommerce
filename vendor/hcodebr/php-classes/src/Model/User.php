<?php

/**
 * @copyright
 * @author
 * @since
 * @see 
 */
namespace Hcode\Model;

use \Hcode\DB\Sql; 
use \Hcode\Model; 

/**
 * desc
 * 
 * 
 */
class User extends Model { 

    const SESSION = "User"; 

    /**
     * desc
     * 
     * @param string $login
     * @param string $password
     * @throws \Exception Quando não existir usúario
     * @throws \Exception Quando errar a senha 
     * @return void
     */
    public static function login($login, $password)
    {
        $sql = new Sql();
        /** @var array $sql descrição  */
        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
            ":LOGIN"=>$login
        )); 

        if(count($results)===0)
        {
            throw new \Exception("Usuario inexistente ou senha inválida", 1);
            
        }

        $data = $results[0];
        if (password_verify($password, $data["despassword"]) === true)
        {
            $user = new User(); 
            $user->setData($data);

            $_SESSION[User::SESSION] = $user->getvalues();
                return $user;  

            /*var_dump($user); 
            exit;*/ 
        
        } else { 
            throw new \Exception("Usuario inexistente ou senha inválida", 1);
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
            header("Location: /admin/login");
            exit;
        }
    }

    public static function logout()
    {  
        $_SESSION[User::SESSION] = NULL; 
    }

}



?>