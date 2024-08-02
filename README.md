# Documentação da API

## Rotas de Autenticação

### Login
- **URL:** `/login`
- **Método:** `POST`
- **Descrição:** Realiza o login de um usuário e retorna um token de autenticação.
- **Body:**
  - `email` (string): O e-mail do usuário.
  - `password` (string): A senha do usuário.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `{
    "token": "string",
    "user": {
        "id": int,
        "name": "string",
        "email": "string",
        "created_at": "string",
        "updated_at": "string"
    }
}`
- **Resposta de Erro:**
  - Código: `401 Unauthorized`
  - Corpo: `{
    "errors": {
        "email": [
            "O email é obrigatório."
        ],
        "password": [
            "A senha é obrigatória."
        ]
    }
}`

### Registro
- **URL:** `/register`
- **Método:** `POST`
- **Descrição:** Registra um novo usuário e retorna um token de autenticação.
- **Body:**
  - `name` (string): O nome do usuário.
  - `email` (string): O e-mail do usuário.
  - `password` (string): A senha do usuário.
  - `password_confirmation` (string): Confirmação da senha.
- **Resposta de Sucesso:**
  - Código: `201 Created`
  - Corpo: `{
    "token": "string",
    "user": {
        "name": "string",
        "email": "string",
        "updated_at": "string",
        "created_at": "string",
        "id": int
    }
}`
- **Resposta de Erro:**
  - Código: `400 Bad Request`
  - Corpo: `{
    "errors": {
        "name": [
            "O nome é obrigatório."
        ],
        "email": [
            "O email é obrigatório."
        ],
        "password": [
            "A senha é obrigatória.",
            "As senhas precisam ser iguais.",
            "A senha deve ter mais do que 6 caractéres."
        ]
    }
}`

## Rotas Protegidas (Requer Autenticação)

### Logout
- **URL:** `/logout/{user}`
- **Método:** `POST`
- **Descrição:** Realiza o logout do usuário autenticado.
- **Parâmetros:**
  - `user` (integer): O ID do usuário.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `{ "message": "Deslogado(a) com sucesso" }`
- **Resposta de Erro:**
  - Código: `401 Unauthorized`
  - Corpo: `{ "error": "Unauthenticated" }`

### Obter Informações do Usuário
- **URL:** `/user`
- **Método:** `GET`
- **Descrição:** Obtém as informações do usuário autenticado.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `"user": {
        "id": int,
        "name": "string",
        "email": "string",
        "created_at": "string",
        "updated_at": "string"
    }`
- **Resposta de Erro:**
  - Código: `401 Unauthorized`
  - Corpo: `{ "error": "Unauthenticated" }`

### Obter Pedidos do Usuário
- **URL:** `/user/{user}/orders`
- **Método:** `GET`
- **Descrição:** Obtém os pedidos de um usuário específico.
- **Parâmetros:**
  - `user` (integer): O ID do usuário.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `{
    "status": boolean,
    "orders": [
        {
            "id": int,
            "user_id": int,
            "category_id": int,
            "name": "string",
            "image": "string",
            "description": "string",
            "price": "decimal",
            "quantity": int,
            "created_at": "string",
            "updated_at": "string",
            "pivot": {
                "user_id": int,
                "product_id": int,
                "quantity": int
            }
        },
    ]
}`
- **Resposta de Erro:**
  - Código: `401 Unauthorized` ou `404 Not Found`
  - Corpo: `{ "error": "User not found" }` ou `{ "error": "Unauthenticated" }`

### Criar Pedido
- **URL:** `/user/orders/create`
- **Método:** `POST`
- **Descrição:** Cria um novo pedido para o usuário autenticado.
- **Body:**
  - `user_id` (integer): O ID do usuário.
  - `product_id` (integer): O ID do produto.
  - `price` (decimal): O preço do total do produto.
  - `quantity` (integer): A quantidade do produto.
- **Resposta de Sucesso:**
  - Código: `201 Created`
  - Corpo: `{
    "status": true,
    "message": "Produto adicionado ao carrinho!",
  }`
- **Resposta de Erro:**
  - Código: `400 Bad Request`
  - Corpo: `"errors": {
        "user_id": [
            "O id do usuário é obrigatório."
        ],
        "product_id": [
            "O id do produto é obrigatório."
        ],
        "price": [
            "O preço total é obrigatório."
        ],
        "quantity": [
            "A quantidade é obrigatória."
        ]
    }`

### Criar Produto
- **URL:** `/products/create`
- **Método:** `POST`
- **Descrição:** Adiciona um novo produto ao sistema.
- **Body:**
  - `user_id` (string): id do usuário.
  - `category_id` (string): id da categoria.
  - `name` (string): Nome do produto.
  - `image` (string): Url da imagem do produto.
  - `description` (string): Descrição do produto.
  - `price` (decimal): Preço do produto.
  - `quantity` (int): Quantidade do produto.
- **Resposta de Sucesso:**
  - Código: `201 Created`
  - Corpo: `{
    "status": true,
    "product": {
        "user_id": "string",
        "category_id": "string",
        "name": "string",
        "image": "string",
        "description": "string",
        "price": "decimal",
        "quantity": int,
        "updated_at": "string",
        "created_at": "string",
        "id": int
    }
}`
- **Resposta de Erro:**
  - Código: `400 Bad Request`
  - Corpo: `"errors": {
        "user_id": [
            "O id do usuário é obrigatório"
        ],
        "category_id": [
            "O id da categoria é obrigatório"
        ],
        "name": [
            "O nome do produto é obrigatório."
        ],
        "image": [
            "É obrigatório o envio de uma imagem."
        ],
        "description": [
            "A descrição é obrigatória"
        ],
        "price": [
            "A preço é obrigatório"
        ],
        "quantity": [
            "A quantidade é obrigatória"
        ]
    }`

### Atualizar Produto
- **URL:** `/products/update`
- **Método:** `Patch`
- **Descrição:** Atualiza as informações de um produto existente.
- **Body:**
  - `user_id` (string): id do usuário.
  - `category_id` (string): id da categoria.
  - `name` (string): Nome do produto.
  - `image` (string): Url da imagem do produto.
  - `description` (string): Descrição do produto.
  - `price` (decimal): Preço do produto.
  - `quantity` (int): Quantidade do produto.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `{ 'status' => true, 'message' => 'produto editado com sucesso' }`
- **Resposta de Erro:**
  - Código: `400 Bad Request`
  - Corpo: `"errors": {
        "user_id": [
            "O id do usuário é obrigatório"
        ],
        "category_id": [
            "O id da categoria é obrigatório"
        ],
        "name": [
            "O nome do produto é obrigatório."
        ],
        "image": [
            "É obrigatório o envio de uma imagem."
        ],
        "description": [
            "A descrição é obrigatória"
        ],
        "price": [
            "A preço é obrigatório"
        ],
        "quantity": [
            "A quantidade é obrigatória"
        ]
    }`

### Deletar Produto
- **URL:** `/products/delete/{product}`
- **Método:** `DELETE`
- **Descrição:** Remove um produto do sistema.
- **Parâmetros:**
  - `product` (integer): ID do produto.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `{
    "status": true,
    "message": "item deletado com sucesso"
}`
- **Resposta de Erro:**
  - Código: `404 Not Found`
  - Corpo: `{ 
      'status' => false,
      'message' => 'você não tem permissão para deletar este produto.'
   }`

## Rotas Públicas

### Listar Produtos
- **URL:** `/products`
- **Método:** `GET`
- **Descrição:** Obtém a lista de todos os produtos.
- **Opções:**
  - `order` (asc, desc): Ordem de exibição dos produtos.
  - `limit`: Quantidade de produtos a serem exibidos.
  - `category` (category_id): Exibir produtos de uma determinada categoria.
  - `search`: Exibe produtos baseados em uma busca.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `"products": [
      {
          "id": int,
          "user_id": int,
          "category_id": int,
          "name": "string",
          "image": "string",
          "description": "string",
          "price": "decimal",
          "quantity": int,
          "created_at": "string",
          "updated_at": "string"
      }
  ]`

### Obter Detalhes do Produto
- **URL:** `/products/{product}`
- **Método:** `GET`
- **Descrição:** Obtém detalhes de um produto específico.
- **Parâmetros:**
  - `product` (integer): ID do produto.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `{
    "status": boolean,
    "product": {
        "id": int,
        "user_id": int,
        "category_id": int,
        "name": "string",
        "image": "string",
        "description": "string",
        "price": "decimal",
        "quantity": int,
        "created_at": "string",
        "updated_at": "string"
    }
}`


