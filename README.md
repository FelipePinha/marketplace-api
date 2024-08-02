# Documentação da API

## Rotas de Autenticação

### Login
- **URL:** `/login`
- **Método:** `POST`
- **Descrição:** Realiza o login de um usuário e retorna um token de autenticação.
- **Parâmetros:**
  - `email` (string): O e-mail do usuário.
  - `password` (string): A senha do usuário.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `{
    "token": "string",
    "user": {
        "id": "int",
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
- **Parâmetros:**
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

### Obter Informações do Usuário
- **URL:** `/user`
- **Método:** `GET`
- **Descrição:** Obtém as informações do usuário autenticado.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `"user": {
        "id": "int",
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
            "price": "string",
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
- **Parâmetros:**
  - `product_id` (integer): O ID do produto.
  - `quantity` (integer): A quantidade do produto.
- **Resposta de Sucesso:**
  - Código: `201 Created`
  - Corpo: `{ "order_id": "integer", "status": "string" }`
- **Resposta de Erro:**
  - Código: `400 Bad Request`
  - Corpo: `{ "error": "Validation errors" }`

### Logout
- **URL:** `/logout/{user}`
- **Método:** `POST`
- **Descrição:** Realiza o logout do usuário autenticado.
- **Parâmetros:**
  - `user` (integer): O ID do usuário.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `{ "message": "Logged out successfully" }`
- **Resposta de Erro:**
  - Código: `401 Unauthorized` ou `404 Not Found`
  - Corpo: `{ "error": "Unauthenticated" }` ou `{ "error": "User not found" }`

### Criar Produto
- **URL:** `/products/create`
- **Método:** `POST`
- **Descrição:** Adiciona um novo produto ao sistema.
- **Parâmetros:**
  - `name` (string): Nome do produto.
  - `price` (decimal): Preço do produto.
  - `description` (string): Descrição do produto.
- **Resposta de Sucesso:**
  - Código: `201 Created`
  - Corpo: `{ "product_id": "integer", "name": "string", "price": "decimal" }`
- **Resposta de Erro:**
  - Código: `400 Bad Request`
  - Corpo: `{ "error": "Validation errors" }`

### Atualizar Produto
- **URL:** `/products/update`
- **Método:** `POST`
- **Descrição:** Atualiza as informações de um produto existente.
- **Parâmetros:**
  - `product_id` (integer): ID do produto.
  - `name` (string, opcional): Nome do produto.
  - `price` (decimal, opcional): Preço do produto.
  - `description` (string, opcional): Descrição do produto.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `{ "message": "Product updated successfully" }`
- **Resposta de Erro:**
  - Código: `400 Bad Request`
  - Corpo: `{ "error": "Validation errors" }`

### Deletar Produto
- **URL:** `/products/delete/{product}`
- **Método:** `DELETE`
- **Descrição:** Remove um produto do sistema.
- **Parâmetros:**
  - `product` (integer): ID do produto.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `{ "message": "Product deleted successfully" }`
- **Resposta de Erro:**
  - Código: `404 Not Found`
  - Corpo: `{ "error": "Product not found" }`

## Rotas Públicas

### Listar Produtos
- **URL:** `/products`
- **Método:** `GET`
- **Descrição:** Obtém a lista de todos os produtos.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `[ { "product_id": "integer", "name": "string", "price": "decimal" }, ... ]`
- **Resposta de Erro:**
  - Código: `500 Internal Server Error`
  - Corpo: `{ "error": "Server error" }`

### Obter Detalhes do Produto
- **URL:** `/products/{product}`
- **Método:** `GET`
- **Descrição:** Obtém detalhes de um produto específico.
- **Parâmetros:**
  - `product` (integer): ID do produto.
- **Resposta de Sucesso:**
  - Código: `200 OK`
  - Corpo: `{ "product_id": "integer", "name": "string", "price": "decimal", "description": "string" }`
- **Resposta de Erro:**
  - Código: `404 Not Found`
  - Corpo: `{ "error": "Product not found" }`


