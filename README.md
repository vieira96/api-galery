# API de uma galeria de fotos com autenticação via JWT com a possibilidade de adicionar fotos, criar albums separados e adicionar fotos ao mesmo

## Instalação

Composer install
cp .env-example .env - copiar o arquivo .env-example para o arquivo .env
Configurar arquivo .env
php artisan storage:link - para criar um link do storage para a pasta publica para ser exibida a imagem.

Configurar a url base no .env em APP_URL=(sua url base) para na hora de adicionar foto, seja criada a url da imagem corretamente.

php artisan migrate
php artisan serve

## endpoints

### Autenticação

/login
/signup
/me
/logout

### Fotos

/photo POST - Adicionar nova(s) foto(s).
/photo GET - Exibir todas as fotos do usuário.
/photo/{id} GET - Exibir uma unica foto.
/photo/{id} DELETE - Apagar a foto.

### Albums

/album POST - Criar um novo album com a opção de adicionar fotos ou não.
/album GET - Pega todos os albums do usuário.
/album/{id} GET - Pega todos os albums do usuário.
/album/{id} PUT - Edita o album.
/album/{id} DELETE - Deleta o album e todas as fotos.
/album/{id}/photo POST - Adiciona fotos ao album selecionado.
