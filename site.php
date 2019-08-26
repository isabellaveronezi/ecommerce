<?php

use \Hcode\Page;
use \Hcode\Model\Product;
use \Hcode\Model\Category;
use \Hcode\Model\Cart;
use \Hcode\Model\Address;
use \Hcode\Model\User;


$app->get('/', function() {

    $products = Product::listAll()
;    
	$page = new Page();
    
    $page->setTpl("index", [
        'products'=>Product::checkList($products)
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
        'categories'=>$product->getCategories()
    ));
}); 

$app->get("/cart", function()
{
   $cart = Cart::getFromSession();

    $page = new Page(); 

    $page->setTpl('cart', [
        'cart'=>$cart->getValues(),
        'products'=>$cart->getProducts(),
        'error'=>Cart::getMsgError()
    ]); 
});

$app->get("/cart/:idproduct/add", function($idproduct)
{
    $product = new Product(); 

    $product->get((int)$idproduct); 

    $cart = Cart::getFromSession();
    
    $qtd = (isset($_GET['qtd'])) ? (int)$_GET['qtd'] : 1;

        for ($i =0; $i < $qtd; $i++){
        $cart->addProduct($product);
    }
     
    header("Location: /cart");
    exit;
        
});

$app->get("/cart/:idproduct/minus", function($idproduct)
{
    $product = new Product(); 

    $product->get((int)$idproduct); 

    $cart = Cart::getFromSession();

    $cart->removeProduct($product);

    header("Location: /cart");
    exit;
});

$app->get('/cart/:idproduct/remove', function($idproduct)
{
    $product = new Product(); 

    $product->get((int)$idproduct); 

    $cart = Cart::getFromSession();

    $cart->removeProduct($product, true);

    header("Location: /cart");
    exit;

});

$app->post('/cart/freight', function()
{
    $cart = Cart::getFromSession();

    $cart->setFreight($_POST['zipcode']);

    header("Location: /cart");
    exit;
});

$app->get('/checkout', function()
{
    User::verifyLogin(false);
    
    $address = new Address();
    
    $cart = Cart::getFromSession();

    if (isset($_GET['zipcode'])) {

        $_GET['zipcode'] = $cart->getdeszipcode();

    }

    if (isset($_GET['zipcode'])) {
        $address->loadFromCEP($_GET['zipcode']);
        $cart->setdeszipcode($_GET['zipcode']);
        $cart->save();
        $cart->getCalculateTotal();
    }

    if (!$address->getdesaddress()) $address->setdesaddress('');
    if (!$address->getdescomplement()) $address->setdescomplement('');
    if (!$address->getdescity()) $address->setdescity('');
    if (!$address->getdesstate()) $address->setdesstate('');
    if (!$address->getdescountry()) $address->setdescountry('');
    if (!$address->getdeszipcode()) $address->setdeszipcode('');
    if (!$address->getdesdistrict()) $address->setdesdistrict('');


    $page = new Page();
    
    $page->setTpl("checkout", [ 
        'cart'=>$cart->getValues(),
        'address'=>$address->getValues(),
        'products'=>$cart->getProducts(),
        'error'=>Address::getMsgError()
    ]);
});

$app->post('/checkout', function()
{
    User::verifyLogin(false);

    if (!isset($_POST['zipcode']) || $_POST['zipcode'] === ''){
        Address::setMsgError("Informe o CEP");

        header('Location: /checkout');
        exit;
    }

    if (!isset($_POST['desaddress']) || $_POST['desaddress'] === ''){
        Address::setMsgError("Informe o endereço");

        header('Location: /checkout');
        exit;
    }

    if (!isset($_POST['desdistrict']) || $_POST['desdistrict'] === ''){
        Address::setMsgError("Informe o bairro");

        header('Location: /checkout');
        exit;
    }

    if (!isset($_POST['descity']) || $_POST['descity'] === ''){
        Address::setMsgError("Informe a cidade");

        header('Location: /checkout');
        exit;
    }

    if (!isset($_POST['desstate']) || $_POST['desstate'] === ''){
        Address::setMsgError("Informe o estado");

        header('Location: /checkout');
        exit;
    }

    if (!isset($_POST['descountry']) || $_POST['descountry'] === ''){
        Address::setMsgError("Informe o país");

        header('Location: /checkout');
        exit;
    }

    $address = new Address();
    
    $user = User::getFromSession();

    $_POST['deszipcode'] = $_POST['zipcode'];
    $_POST['idperson'] = $user->getidperson();

    $address->setData($_POST);
    $address->save();

    header("Location: /order");
    exit;


});
