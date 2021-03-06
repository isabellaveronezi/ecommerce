
<h1>
Implementação E-Commerce
</h1>

Pequeno projeto de um site de e-commerce para iniciar conhecimento na linguagem PHP. Projeto realizado pela hcodebr pela plataforma udemy 'curso completo de php7'. Curso destinado ao treinamento do time de estágiarios da WebJump!

<h3>
Site da empresa: 
</h3>

http://www.webjump.com.br/

<h3>
Pré Requisitos
</h3>
<ul>
  <li> Conhecimentos básicos de HTML e CSS </li>
  <li> Lógica de Programação </li>
  <li> Php 7 </li>
  <li> Banco MySQL </li>
  <li> Virtual host (Nginx ou Apache) </li>
 </ul> 
<h3>
Link de acesso ao curso 
</h3>

https://www.udemy.com/curso-php-7-online/

<h3>
Linkedin
</h3>
https://www.linkedin.com/in/isabella-veronezi/
<h3>
Classes
</h3>

Este projeto utiliza a forma DAO para organização das classes e seus respectivos métodos. As classes são:
<ul>
<li> <b> Vendor -> Hcodebr -> php-classes -> src -> DB -> Sql.php </b> </li>
</ul>

A classe SQL é responsável pela comunicação com o banco de dados, e, fazer o bind params de forma dinâmica. A diferença entre os métodos "query" e "select" está no retorno de dados, visto que o método "query" é um método void
<ul>
<li> <b> Vendor -> Hcodebr -> php-classes -> src -> Model.php </li> </b>
</ul>

Essa é uma classe abstrata, responsável por conter os métodos setData que carrega seus filhos com um array de valores. Também é responsável por fazer os métodos set e get de forma dinâmica.

<ul>
<li> <b> Vendor -> Hcodebr -> php-classes -> src -> Mailer.php </li> </b> 
</ul>

Classe responsável pelo envio de e-mail da rota forgot
<ul>
<li> <b> Vendor -> Hcodebr -> php-classes -> src -> Page.php </li> </b>
</ul>

Classe responsável por fazer o merge entre o views e views cache atráves da classe pai raintpl
<ul>
<li> <b> Vendor -> Hcodebr -> php-classes -> src -> PageAdmin.php </li> </b>
</ul>

Mesma função da page, mudando apenas o tipo de template a ser carregado. Extende da classe pai Page.php
<ul>
<li> <b> Vendor -> Hcodebr -> php-classes -> src -> Model -> Address.php </li> </b>
</ul>

Essa classe é responsável por se comunicar com o webservice "Via CEP", fazer o carregamento do cep informado aplicando o frete com o webservice da Sedex (a comunicação com o webservice da sedex é feita pela classe Cart.php)
<ul>
<li> <b> Vendor -> Hcodebr -> php-classes -> src -> Model -> Category.php </li> </b>
</ul>

Classe responsável por gerenciar os CRUD da categoria, e, atribuir n produtos a mesma. Possui métodos para paginação.
<ul>
<li> <b> Vendor -> Hcodebr -> php-classes -> src -> Model -> Order.php </li> </b>
</ul>

Classe responsável por gerenciar o carrinho e pedidos dos usuários cadastrados. Possui métodos para paginação.
<ul>
<li> <b> Vendor -> Hcodebr -> php-classes -> src -> Model -> OrderStatus.php </li> </b>
</ul>

Possui apenas um método, é uma classe final que serve apenas para gerenciar os status dos pedidos (EM ABERTO, AGUARDANDO PAGAMENTO, PAGO, ENTREGUE)
<ul>
<li> <b> Vendor -> Hcodebr -> php-classes -> src -> Model -> Product.php </li> </b>
</ul>

Classe responsável pelo CRUD de produtos, categoria e o carrinho. Possui métodos para paginação. OBSERVAÇÃO: Essa classe necessita de uma tabela contendo as relações entre REVIEW n-1 PRODUTOS.
<ul>
<li> <b> Vendor -> Hcodebr -> php-classes -> src -> Model -> User.php </li> </b>
</ul>

Classe responsável pelo CRUD de usuários e validação de login (admin ou não). Possui método para paginação, forgot password via classe Mailer.php, get Orders.

<ul>
<li> <b> Vendor -> Hcodebr -> php-classes -> src -> Model -> Cart.php </li> </b>
</ul>

É a classe responsável por manipular o cart do usuário, seja um usuário cadastrado ou não (via $_SESSION) e por se comunicar com o webservice da sedex através do

<pre>"http_build_query"</pre>
E

<pre>"simplexml_load_file"</pre>

<hr> </hr>

<h1> 
Telas Admin: 
</h1>
<hr> </hr>

<h3> 
Login Admin
</h3>
<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/loginadmin.png" alt="la" style="max-width:100%;">

<h3>
Home Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/PainelAdmin.png" alt="la" style="max-width:100%;">

<h3>
Usuários Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/Usuarios.png" alt="la" style="max-width:100%;">

<h3>
Cadastro usuários Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/cadastrousuarioadmin.png" alt="la" style="max-width:100%;">

<h3>
Editar usuários Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/editarusuario.png" alt="la" style="max-width:100%;">

<h3>
Alterar senha usuários Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/editarsenhausuario.png" alt="la" style="max-width:100%;">

<h3>
Categorias Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/categoriasadmin.png" alt="la" style="max-width:100%;">

<h3>
Editar categorias Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/editarcategoriasadmin.png" alt="la" style="max-width:100%;">

<h3>
Relação produto e categorias Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/rela%C3%A7aoprodutocategoria.png" alt="la" style="max-width:100%;">

<h3>
Relação produto e categorias Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/rela%C3%A7aoprodutocategoria.png" alt="la" style="max-width:100%;">

<h3>
Produtos Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/produtosadmin.png" alt="la" style="max-width:100%;">

<h3>
Editar produtos Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/editarprodutoadmin.png" alt="la" style="max-width:100%;">

<h3>
Cadastrar produtos Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/cadastrarprodutoadmin.png" alt="la" style="max-width:100%;">


<h3>
Cadastrar produtos Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/cadastrarprodutoadmin.png" alt="la" style="max-width:100%;">

<h3>
Pedidos Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/pedidosAdmin.png" alt="la" style="max-width:100%;">

<h3>
Status de pedidos Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/statuspedidoadmin.png" alt="la" style="max-width:100%;">

<h3>
Detalhes do pedidos Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/detalhesdopedidoadmin.png" alt="la" style="max-width:100%;">

<h3>
Recuperar senha Admin
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/recuperarsenhadmin.png" alt="la" style="max-width:100%;">

<hr> </hr>

<h1> 
Telas Site: 
</h1>
<hr> </hr>

<h3>
Home 
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/homesite.png" alt="la" style="max-width:100%;">
<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/homesite2.png" alt="la" style="max-width:100%;">
<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/homesite3.png" alt="la" style="max-width:100%;">

<h3>
Produtos 
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/produtossite.png" alt="la" style="max-width:100%;">

<h3>
Detalhes do produto
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/detalhesproduto.png" style="max-width:100%;">

<h3>
Categorias
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/categoria.png" alt="la" style="max-width:100%;">

<h3>
Carrinho de compra
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/carrinhocompra.png" alt="la" style="max-width:100%;">


<h3>
Checkout
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/checkout.png" alt="la" style="max-width:100%;">
<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/checkout2.png" alt="la" style="max-width:100%;">
<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/checkout3.png" alt="la" style="max-width:100%;">

<h3>
Login
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/loginusuario.png" alt="la" style="max-width:100%;">

<h3>
Minha conta
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/minhacontasite.png" alt="la" style="max-width:100%;">

<h3>
Alterar senha
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/alterarsenhasite.png" alt="la" style="max-width:100%;">

<h3>
Meus pedidos
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/meuspedidossite.png" alt="la" style="max-width:100%;">

<h3>
Detalhes do pedido
</h3>

<img src= "https://github.com/isabellaveronezi/ecommerce/blob/master/git/detalhespedidosite.png" alt="la" style="max-width:100%;">


