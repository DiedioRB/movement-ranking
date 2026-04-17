# Desafio técnico Tecnofit - Ranking de Movimento

- [Descrição geral](#descrição-geral)
- [Instalação](#instalação)
  - [Docker](#docker)
  - [.env](#env)
  - [Inicialização do servidor](#inicialização-do-servidor)
- [Testes](#testes)
- [Logs](#logs)
- [Detalhes técnicos](#detalhes-técnicos)
  - [Estrutura arquitetural](#estrutura-arquitetural)
  - [Omissões](#omissões)
  - [Bibliotecas utilizadas](#bibliotecas-utilizadas)
- [Estrutura do sistema](#estrutura-do-sistema)
- [Documentação da API](#documentação-da-api)

## Descrição geral
Esta API relaciona dados do banco de dados para gerar um ranking de usuários que tiveram melhor recorde em um determinado movimento. A consulta ocorre através de uma requisição HTTP para o endpoint especificado, que retorna uma resposta no formato JSON com o código de status da requisição e, se existente, o ranking do movimento solicitado.

## Instalação

### Docker
Certifique-se de possuir uma instalação do Docker disponível na máquina que executará a API. Você pode instalar através [deste link](https://www.docker.com/get-started/).

### .env
O arquivo **.env** é utilizado para gerar os dados de acesso ao banco de dados e, portanto, deve ser criado. Você pode copiar o arquivo [.env.example](.env.example) e preencher os campos conforme a sua necessidade. o campo DB_HOST possui um valor já incluso equivalente ao nome do serviço do banco de dados incluso em [docker-compose.yml](docker-compose.yml).

### Inicialização do servidor
- Em um terminal de comando, acesse a pasta raiz da API
- Execute o seguinte comando para que o docker possa baixar as dependências e levantar o servidor:
```shell
> docker-compose up --build
```
- O servidor será aberto por padrão na [porta 8000](http://localhost:8000).

### Testes
Para testes, você pode acessar a raiz da API para acessar o Swagger UI e testar cada endpoint documentado.

Você também pode utilizar o [Postman](https://www.postman.com/) para verificar o funcionamento da API:
- Abra o aplicativo para desktop
- No menu superior, selecione ``` File > Import ```
- Selecione o arquivo disponível em [```public/openapi.json```](public/openapi.json)
- Isso irá importar a documentação da API, permmitindo que você teste os endpoints disponíveis

Alternativamente, como o endpoint fuinciona com o verbo HTTP GET, você pode acessar [localhost:8000/movement/1](http://localhost:8000/movement/1), alterando o "1" pelo identificador ou nome do movimento a ser consultado.

Para atualizar a documentação durante a execução da API, você pode executar o script disponível em [```scripts/generate-docs.sh```](scripts/generate-docs.sh).

### Logs
Os logs de execução dos endpoint são registrados dentro da pasta [```logs/```](logs/) e incluem informações de endpoints acessados, respostas enviadas e erros capturados pelo sistema. Esses logs também são enviados ao log do Docker para visualização em tempo real.


## Detalhes técnicos

- **Linguagem utilizada:** PHP 8.4
- **Servidor:** Nginx
- **Banco de dados:** MySQL 8
- **Conteinerização:** Docker
- **Gerenciador de dependências para o PHP:** Composer

### Estrutura arquitetural

- A API foi construída utilizando Docker para conteinerização a fim de facilitar a instalação em qualquer ambiente;
- A API foi escrita utilizando um modelo Controller/Model a fim de se tornar escalável. As models têm uma estrutura capaz de se tornar um Active Record caso haja necessidade de operações no banco de dados.
- Também foi incluído um roteador que redireciona as requisições para a função adequada e permite configuração simplificada de novos endpoints, respeitando os verbos HTTP e permitindo retorno adequado de códigos de resposta (200, 404, etc);
- O arquivo [OpenApi.php](src/docs/OpenApi.php) serve apenas como indicador de parâmetros para a biblioteca OpenApi, não sendo diretamente utilizado pelo sistema;
- O arquivo [.env.example](.env.example) incluso no repositório possui os campos que devem ser preenchidos no arquivo **.env** para funcionamento correto do sistema.


### Omissões
- Não foi incluído um sistema de criptografia ou autenticação, mas a estrutura atual permite a adição posterior desses módulos;
- Não foi incluída paginação nos endpoints devido à quantidade pequena de dados salvos. Essa função também é facilmente anexável sem impactar a estrutura atual das requisições.

### Bibliotecas utilizadas

#### [zircote/swagger-php 6.1.0](https://github.com/zircote/swagger-php)
Geração de documentação OpenAPI com base nas classes do sistema.

#### [vlucas/phpdotenv 5.6.3](https://github.com/vlucas/phpdotenv)
Implementação de .ENV para o PHP.

#### [monolog/monolog 3.10.0](https://github.com/Seldaek/monolog)
Registro de logs da API.

## Estrutura do sistema
    |   .env
    |   composer.json
    |   docker-composer.yml
    |   dockerfile
    |
    +---docker
    |    \---mysql
    |
    +---logs
    |
    +---nginx
    |
    +---public
    |
    +---scripts
    |
    +---src
    |   |   index.php
    |   |   swagger.php
    |   |
    |   +---config
    |   |
    |   +---controllers
    |   |   \---v1
    |   |
    |   +---core
    |   |
    |   +---docs
    |   |
    |   +---models
    |   |
    |   \---routes
    |
    \---vendor

- **.env:** variáveis de sistema utilizadas tanto no docker quanto no PHP;
- **composer.json:** Configuração do composer com as bibliotecas utilizadas;
- **docker-compose.yml:** Configuração do docker para criar os containers;
- **dockerfile:** Configuração de execução do docker para instalar as imagens e configurações do servidor;
- **docker/mysql:** pasta com as operações do MySQL a serem executadas no levantamento do servidor;
- **logs:** Registros de logs do sistema aparecem aqui;
- **nginx:** Configuração do servidor Nginx para execução do PHP;
- **public:** Pasta para arquivos públicos e gerados pela biblioteca de OpenApi;
- **scripts:** Scripts úteis para execução;
- **src:** Contém todos os arquivos do sistema, incluindo controllers, models e roteador;
- **vendor:** arquivos das bibliotecas instaladas pelo composer.

## Documentação da API

Acessar a raiz do servidor ([localhost:8000](http://localhost:8000)) permite uma visualização da Swagger UI dos endpoints documentados.

A documentação da API em JSON pode ser encontrada [neste arquivo](public/openapi.json), que pode ser importada no Postman ou similares para teste dos endpoints.