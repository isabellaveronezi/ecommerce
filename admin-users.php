<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User; 


$app->get('/admin/users', function () {
    
    User::verifyLogin();
    
    $search = (isset($_GET['search'])) ? $_GET['search'] : '';
    
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    
    if($search != '') {
    
        $pagination = User::getPageSearch($search, $page, 4);
   
    } else {
   
        $pagination = User::getPage($page);
    }
   
    $pages = [];
   
    for($i = 0; $i < $pagination['pages']; $i++)
    {
        array_push($pages, [
            'href'=>'/admin/users?' . http_build_query([
                'page'=>$i+1,
                    'search'=>$search
                ]),
            'text'=>$i+1
        ]);
    }
    $page = new PageAdmin();
   
    $page->setTpl("users", array(
        "users"=>$pagination['data'],
        'search'=>$search,
        'pages'=>$pages
    ));
});

$app->post("/admin/users/create", function () {

    User::verifyLogin();

   $user = new User();

    $_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

    $_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [

        "cost"=>12
    ]);

    $user->setData($_POST);

   $user->save();

   header("Location: /admin/users");
    exit;

});


$app->post("/admin/users/:iduser", function($iduser)
{
    User::verifyLogin(); 
    
    $user = new User; 

    $_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0; 

    $user->get((int)$iduser); 
    $user->setData($_POST); 
    $user->update();

    header("Location: /admin/users");
    exit; 

});

$app->get("/admin/users/:iduser/delete", function($iduser)
{
    User::verifyLogin();
    
    $user = new user(); 

    $user->get((int)$iduser);
    $user->delete(); 
    header("Location: /admin/users");
    exit; 
    
});
