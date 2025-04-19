# Desafio Aula04

## Ajustar um componente validador, para que fique mais inteligente segundo a problemática a seguir

Seu usuário do componente `Validator` quer poder armazenar um conjunto de validações e posteriormente validá-lo
sobre alguns valores. Veja abaixo como está a atual implementação:

```php
$value = '302';
$result1 = Validator::validateInteger($value);
$result2 = Validator::validateGreaterThan($value, 200);
$result3 = Validator::validateEven($value);

var_dump($result1, $result2, $result3);
```

Veja que na implementação atual não tem como `salvar` um conjunto de validação.
Ache uma forma de implementar um design semelhante ao exemplo abaixo:

```php
// Esse é um exemplo, você pode criar uma interface completamente diferente!
// Desde que a funcionalidade de agregar validações funcione semelhante com
// o teste, use sua criatividade!
$validationGroup = $validator->addValidation(new IsInteger())
                             ->addValidation(new IsGreaterThan(200))
                             ->addValidation(new IsEven());
$result = $validationGroup->validate('304');
```

# Resolução do Desafio

## Testes

![image](https://github.com/user-attachments/assets/8fcd4b00-2a43-4071-bde8-0ae9a60579b2)

## Estrutura

A implementação segue o padrão de design *Strategy*, com a seguinte estrutura:

1. **Interface de Validação**: Define o contrato para todas as classes de validação.
2. **Validadores Específicos**: Classes que implementam validações individuais.
3. **Classe Validator**: Gerencia o conjunto de validações.

> Por escolha pessoal, fiz a alteração da estrutura inicial que estava com `Differdev/src` para apontar para `app`.

## Exemplo de Uso

```php
$validator = new Validator();
$validationGroup = $validator
    ->addValidation(new IsInteger())
    ->addValidation(new IsGreaterThan(200))
    ->addValidation(new IsEven());

$result = $validationGroup->validate(302);
```
