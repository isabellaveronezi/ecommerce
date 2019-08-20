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
use \Hcode\Mailer;
use \Hcode\Model\Cart;


class User extends Model { 

    const SESSION = "User";
    const SECRET = "HcodePhp7_Secret";
    const SECRET_IV = "Ecommerce_Secret";

    public static function getFromSession()
    {
        $user = new User();

        if (isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['iduser'] > 0) {
            $user->setData($_SESSION[User::SESSION]);
        }
            return $user; 
    }

    public static function checkLogin($inadmin = true)
    {
        if(
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0 
            
        ) {
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
    /**
     * check login if it's valid 
     *
     * @param boolean $inadmin
     * @return void
     */
    public static function verifyLogin($inadmin = true)
    {
        if(User::checkLogin($inadmin)) {

            header("Location: /admin/login");
            exit;
        }
    }
    
    public static function logout()
    {  
        $_SESSION[User::SESSION] = NULL; 
    }

    public static function listAll()
    {
        $sql = new Sql(); 
        return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson"); 
    }

    
    public function save()
    {
        $sql = new Sql; 
        /**pdesperson VARCHAR(64), 
        pdeslogin VARCHAR(64), 
        pdespassword VARCHAR(256), 
        pdesemail VARCHAR(128), 
        pnrphone BIGINT, 
        pinadmin TINYINT */

        $results = $sql->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
            ":desperson"=>$this->getdesperson(),
            ":deslogin"=>$this->getdeslogin(), 
            ":despassword"=>$this->getdespassword(), 
            ":desemail"=>$this->getdesemail(), 
            ":nrphone"=>$this->getnrphone(), 
            ":inadmin"=>$this->getinadmin()
        ));
        
        $this->setData($results[0]);
    }

    public function get($iduser)
    {
 
        $sql = new Sql();
 
        $results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = :iduser;", array(
         ":iduser"=>$iduser
        ));
            $data = $results[0];
            $this->setData($data);
 
    }  

    public function update()
    {
        $sql = new Sql(); 

        $results = $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
            ":iduser"=>$this->getiduser(),
            ":desperson"=>$this->getdesperson(),
            ":deslogin"=>$this->getdeslogin(), 
            ":despassword"=>$this->getdespassword(), 
            ":desemail"=>$this->getdesemail(), 
            ":nrphone"=>$this->getnrphone(), 
            ":inadmin"=>$this->getinadmin()
        ));
        
        $this->setData($results[0]);
    }

    public function delete()
    {
        $sql = new Sql(); 
        
        $sql->query("CALL sp_users_delete(:iduser)", array(
            ":iduser"=>$this->getiduser()
        ));
    }
    /**
     * send for email to recover password
     *
     * @param string $email
     * @param boolean $inadmin
     * @return void
     */
    public static function getForgot($email, $inadmin = true)
    {
        $sql = new Sql();

        $results = $sql->select("
			SELECT *
			FROM tb_persons a
			INNER JOIN tb_users b USING(idperson)
			WHERE a.desemail = :email;
		    ", array(
                ":email"=>$email
            ));

        if (count($results) === 0)
        {
            throw new \Exception("Não foi possivel recuperar a senha.");
        }
        else
        {
            $data = $results[0];

            $resultsRecovery = $sql->select("CALL sp_userspasswordsrecoveries_create(:iduser, :desip)", array(
                ":iduser"=>$data["iduser"],
                ":desip"=>$_SERVER["REMOTE_ADDR"] // catch ip user  

            ));

            if (count($resultsRecovery) === 0)
            {
                throw new \Exception("Não foi possível recuperar a senha");
            }
            else
            {

                $dataRecovery = $resultsRecovery[0];
                
                $key = pack('a16', User::SECRET);
                $key_IV = pack('a16', User::SECRET_IV);
                $code = base64_encode(openssl_encrypt($dataRecovery["idrecovery"], 'AES-128-CBC', $key, 0, $key_IV));
                
                    $link = "http://ecommerce.com.br/admin/forgot/reset?code=$code";
                
                
               
                $mailer = new Mailer($data["desemail"], $data["desperson"], "Redefinir Senha da Hcode Store", "forgot", 
                array(
                    "name"=>$data["desperson"], 
                    "link"=>$link
                ));
            
                $mailer->send();

                return $data;


            }
        }
    }

    /**
     * decrypt for valid change password in a minimal time 
     *
     * @param  $code
     * @return void
     */
    public static function validForgotDecrypt($code)
    {
        $sql = new Sql();
        
        $key = pack('a16', User::SECRET);
        $key_IV = pack('a16', User::SECRET_IV);
        $code = base64_decode($code);
        $idrecovery = openssl_decrypt($code, 'AES-128-CBC', $key, 0, $key_IV);

        $results = $sql->select("
            SELECT *
            FROM tb_userspasswordsrecoveries a
            INNER JOIN tb_users b USING(iduser)
            INNER JOIN tb_persons c USING(idperson)
            WHERE 
	            a.idrecovery = :idrecovery
            AND
                a.dtrecovery IS NULL
            AND
                DATE_ADD(a.dtregister, INTERVAL 1 HOUR) >= NOW();", array(
                    ":idrecovery"=>$idrecovery
                ));

        if(count($results) === 0)
        {
            throw new \Exception("Não foi possivel recuperar a senha ");
        
        } else { 
            
            return $results[0];

        }
        
    }

    public static function setForgotUsed($idrecovery)
    {
        $sql = new Sql; 

        $sql->query("UPDATE tb_userspasswordsrecoveries SET dtrecovery = NOW () WHERE idrecovery = :idrecovery", array(
            ":idrecovery"=>$idrecovery
        ));

    }

    public function setPassword($password)
    {
        $sql = new Sql(); 

        $sql->query("UPDATE tb_users SET despassword = :password WHERE id user = :iduser", array(
            ":password"=>$password,
            "iduser"=>$this->getiduser()
        ));
    }
}
   



?>