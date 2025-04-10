# Desafio Aula 03

## Objetivo

Corrigir os testes existentes da integração entre `DisplayHeaders` e `Cookie`, garantindo que a geração do cabeçalho `Set-Cookie` funcione corretamente, incluindo o parâmetro `Expires`. Ao final, o teste deve ter 100% de cobertura.

---

## Etapas Realizadas

1. Corrigido o uso incorreto da classe `Expires` nos testes.  
   O método `setExpires()` da classe `Cookie` espera uma instância de `Expires` construída com métodos encadeados como `->days()`, `->hours()`, `->minutes()`, etc.  
   O erro original ocorreu porque os testes estavam passando uma string diretamente, o que resultava em uma exceção do tipo `DateMalformedIntervalStringException`.

2. Atualizados todos os testes para usar a construção correta da classe `Expires`, por exemplo:

    ```php
    (new Expires())->hours(2)->minutes(20)->seconds(38)
    ```

3. Gerei novos testes para classe Expires para que a cobertura pudesse ficar em 100% - teste para chamada de método inválido e teste com um valor negativo.

---

## Execução

### Subir o ambiente e instalar dependências

```bash
docker compose up -d
./shell/composer install
```

### Acessar o container

```bash
docker exec -it desafio-php-1 bash
```

### Rodar os testes

```bash
composer test
```

### Gerar o coverage

```bash
composer coverage
```

O relatório de cobertura estará disponível na pasta:

```bash
./html/index.html
```
