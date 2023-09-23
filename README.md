# climageo

# Pré-requisitos para executar o projeto

* PHP >= 8
* Composer
* Driver MongoDB Atlas

# Configuração do projeto

1. Baixe o projeto na máquina;

2. Execute o comando 'composer install'

# Configuração da URL de conexão com MongoDB Atlas

1. Acesse o arquivo mongodb.php dentro diretório 'src'.

2. Atribua para as variáveis os nomes do database e collection conforme criado:

> $databaseName = 'workana';
> 
> $collectionName = 'agatha';

3. Altere a URI, colocando a usuário e senha definido na URL de conexão

> $uri = 'mongodb+srv://usuario:senha@cluster0.2iclhyw.mongodb.net/?retryWrites=true&w=majority';

# Execução do projeto

1. No diretório raiz do projeto execute o comando 'php -S localhost:8000'

2. Acesse o navegador e digite a URL http://localhost/8000


