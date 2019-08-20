<?php

namespace Hcode\Model; 

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Mailer;
use \Hcode\Model\Product;
use \Hcode\Model\User;

class Cart extends Model    
{
    const SESSION = "Cart";

    public static function getFromSession()
    {       
        $cart = new Cart(); 

        if(isset($_SESSION[Cart::SESSION]) && $_SESSION[Cart::SESSION]['idcart'] > 0) {

            $cart->get((int)$_SESSION[Cart::SESSION]['idcart']);
        } else {

            $cart->getFromSessionID();
            
            if(!(int)$cart->getidcart() > 0){
                $data = [
                    'dessessionid'=>session_id()
                ];

                if(User::checkLogin(false) === true) {
                
                    $user = User::getFromSession();

                    $data['iduser'] = $user->getiduser();
                }

                $cart->setData($data);
                $cart->save();
                $cart->setToSession();
            }
        }
           return $cart; 
    }

    public function setToSession()
    {
        $_SESSION[Cart::SESSION] = $this->getValues();
    }

    public function getFromSessionID()
    {
        $sql = new Sql(); 

        $reusults = $sql->select("SELECT * FROM tb_carts WHERE dessessionid = :dessessionid", [ 
            ':dessessionid'=>$this->getdessessionid()
        ]);
        if(count($reusults)> 0 ){

            $this->setData($reusults[0]);
        }
    }

    public function get(int $idcart)
    {
        $sql = new Sql(); 

        $reusults = $sql->select("SELECT * FROM tb_carts WHERE idcart = :idcart", [ 
            'idcart'=>$idcart
        ]);
        if(count($reusults)> 0 ){

            $this->setData($reusults[0]);
        }   
    }

    public function save()
    {
        $sql = new Sql(); 

        $reusults = $sql->select("CALL sp_carts_save(:idcart, :dessessionid, :iduser, :deszipcod, :vlfreight, :nrday)", array(
            ':idcart'=>$this->getidcart(), 
            ':dessessionid'=>$this->getdessessionid(), 
            ':iduser'=>$this->getiduser(), 
            ':deszipcod'=>$this->getdeszipcod(), 
            ':vlfreight'=>$this->getvlfreight(), 
            ':nrday'=>$this->getnrday()    
        ));

        $this->setData($reusults[0]); 
    }

    
}


?>