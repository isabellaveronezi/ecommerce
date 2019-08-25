<?php

use \Hcode\Page;
use \Hcode\Model\Product;
use \Hcode\Model\Category;
use \Hcode\Model\Cart;
use \Hcode\Model\Address;
use \Hcode\Model\User;


$app->get('/', function() {
    
	$page = new Page();
    
    $page->setTpl("index");

});

$app->get('/categories/:idcategory', function($idcategory)
{
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    
    $category = new Category(); 

    $category->get((int)$idcategory);

    $pagination = $category->getProductsPage($page);

    $pages = []; 
    for ($i = 1; $i <= $pagination ['pages']; $i++){
        array_push($pages, [
            'link'=>'/categories/'.$category->getidcategory() .'?page='.$i,
            'page'=>$i

        ]);
    }

    $page = new Page(); 
    $page->setTpl("category", [
        'category'=>$category->getValues(),
        'products'=>$pagination["data"],
        'pages'=>$pages
    ]);

});

$app->get('/categories/:idcategory', function($idcategory)
{
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    
    $category = new Category(); 

    $category->get((int)$idcategory);

    $pagination = $category->getProductsPage($page);

    $pages = []; 
    for ($i = 1; $i <= $pagination ['pages']; $i++){
        array_push($pages, [
            'link'=>'/categories/'.$category->getidcategory() .'?page='.$i,
            'page'=>$i

        ]);

    }

    $page = new Page(); 
    $page->setTpl("category", [
        'category'=>$category->getValues(),
        'products'=>$pagination["data"],
        'pages'=>$pages
    ]);

});

$app->get('/products', function () {
    
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    
    $products = new Product();
    
    $pagination = $products->getPage($page);
    $pages = [];
    
    for ($i = 1; $i <= $pagination['pages']; $i++) {
        array_push($pages, [
            'link'=>'/products' . $products->getidproduct() . '?page=' . $i,
            'page'=>$i
        ]);
    }
    
    $page = new Page();
    
    $page->setTpl("products", [
        "products"=>$pagination["data"],
        "pages"=>$pages
    ]);
});

$app->get('/products/:desurl', function($desurl)
{
    $product = new Product();

    $product->getFromURL($desurl); 

    $page = new Page(); 
    $page->setTpl("product-detail", array(
        'product'=>$product->getValues(),
       // 'categories'=>$product->getCategories()
    ));
}); 


?>