<?php

namespace Hcode\Model;

use \Hcode\DB\Sql; 
use \Hcode\Model; 
use \Hcode\Mailer;


Class Category extends Model{ 

    public static function listAll()
    {
        $sql = new Sql(); 

        return $sql->select("SELECT * FROM tb_categories ORDER BY descategory");
    }

    public function save()
    {
        $sql = new Sql(); 

        $results = $sql->select("CALL sp_categories_save(:idcategory, :descategory)", array(
            ":idcategory"=>$this->getidcategory(), 
            ":descategory"=>$this->getdescategory()
        )); 

        $this->setData($results[0]);

        Category::updateFile(); 
    }

    public function get($idcategory)
    {
        $sql = new Sql(); 
     
        $results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory", [
            ':idcategory'=>$idcategory
        ]);
          
        $this->setData($results[0]); 
    }

    public function delete()
    {
        $sql = new Sql(); 

        $sql->query("DELETE FROM tb_categories WHERE idcategory = :idcategory", [
            ':idcategory'=>$this->getidcategory()
        ]);   

        Category::updateFile(); 
    }

    public function getProductsPage ($page = 1, $itemsPerPage = 3)
    {
        $start = ($page - 1) * $itemsPerPage;
        
        $sql = new Sql();
        
        $results = $sql->select(" SELECT SQL_CALC_FOUND_ROWS *
        FROM tb_products a 
        INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct
        INNER JOIN tb_categories c ON c.idcategory = b.idcategory
        WHERE c.idcategory = :idcategory
        LIMIT $start, $itemsPerPage;
        ", [
            ":idcategory"=>$this->getidcategory()
        ]);
        
        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal");
        return [
            "data"=>Product::checkList($results),
            "total"=>(int)$resultTotal[0]["nrtotal"],
            "pages"=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
        ];
        
    }
}

