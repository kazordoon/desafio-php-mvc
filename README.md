# Desafio PHP MVC - Nooio

## Iniciando

### Pré-requisitos
- Docker
- Docker compose

**Ou**

- Apache
- PHP 7.4
- Composer
- MySQL / MariaDB

## Instalação

### Com docker
- Clone o repositório: `git clone https://github.com/kazordoon/desafio-php-mvc.git`
- Entre no diretório do projeto: `cd desafio-php-mvc`
- Rode o comando: `docker-compose up -d`
- Execute o script que irá instalar as dependências do PHP: `./scripts/install-php-dependencies.sh`
- Execute o script que irá configurar o banco de dados: `./scripts/populate-database.sh`

### Manualmente
Antes de iniciar a instalação do projeto, será necessário instalar algumas extensões do PHP para tudo funcionar normalmente. As extensões são as seguintes:
- [pdo_mysql](https://www.php.net/manual/en/ref.pdo-mysql.php)
- [intl](https://www.php.net/manual/en/book.intl.php)

Após instalar estas extensões de acordo com seu sistema operacional, siga as seguintes instruções para a instalação do projeto em si.
- Clone o repositório: `git clone https://github.com/kazordoon/desafio-php-mvc.git`
- Entre no diretório web do projeto: `cd desafio-php-mvc`
- Configure o banco de dados utilizando os comandos do arquivo *db/dump.sql*: `mysql -u root -p < db/dump.sql`
- Entre no diretório *src*: `cd src`
- Instale as dependências: `composer install`
- Saia do diretório do projeto: `cd ../..`
- Mova o diretório do projeto para o local onde ficam seus arquivos servidos pelo *Apache*: `mv desafio-php-mvc /var/www/html`
- Altere as configurações do projeto de acordo com sua máquina, as configurações ficam no arquivo `src/config/config.inc.php`

## Execução
- Docker
  - Acesse pelo seu navegador o link: `http://localhost:8080`
- Manual
  - Acesse pelo seu navegador o link que você configurou no arquivo `web/config/config.inc.php` que está localizado na constante `BASE_URL`.

## Construído com
- [PHP 7.4](https://www.php.net/)
	- [coffeecode/router](https://packagist.org/packages/coffeecode/router)
	- [twig/twig](https://packagist.org/packages/twig/twig)
	- [twig/intl-extra](https://packagist.org/packages/twig/intl-extra)
	- [mongodb/mongodb](https://packagist.org/packages/mongodb/mongodb)
	- [phpmailer/phpmailer](https://packagist.org/packages/phpmailer/phpmailer)
  - [pecee/pixie](https://packagist.org/packages/pecee/pixie)
- [MongoDB](https://www.mongodb.com/)

## Autores
- **Felipe Barros** - [kazordoon](https://github.com/kazordoon)

## Licença
Este projeto está licenciado sob a licença MIT - Veja o arquivo [LICENSE](LICENSE) para mais detalhes.
