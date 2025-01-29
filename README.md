# 🛠️ Inovanti Toolkit

[![Latest Stable Version](https://poser.pugx.org/inovanti-bank/inovanti-toolkit/v)](https://packagist.org/packages/inovanti-bank/inovanti-toolkit)
[![Total Downloads](https://poser.pugx.org/inovanti-bank/inovanti-toolkit/downloads)](https://packagist.org/packages/inovanti-bank/inovanti-toolkit)
[![License](https://poser.pugx.org/inovanti-bank/inovanti-toolkit/license)](https://packagist.org/packages/inovanti-bank/inovanti-toolkit)
[![PHP Version Require](https://poser.pugx.org/inovanti-bank/inovanti-toolkit/require/php)](https://packagist.org/packages/inovanti-bank/inovanti-toolkit)

### **Biblioteca de utilitários para Laravel 11**

O **Inovanti Toolkit** é um componente projetado para **simplificar tarefas comuns** em aplicações Laravel 11. Ele fornece um conjunto de **helpers reutilizáveis** para formatação, validação e manipulação de strings, números, datas, arrays, e muito mais.

---

# 🚀 Instalação

O pacote pode ser instalado via Composer:

```bash
composer require inovanti-bank/inovanti-toolkit
```

---

# ⚙️ Configuração

Atualmente, não há configuração obrigatória. No entanto, o pacote se integra automaticamente ao Laravel via ToolkitServiceProvider.

# 📩 Uso

## 🔠 Manipulação de Strings (StringHelper)

### 📌 Métodos Disponíveis

- `formatName(string $name, bool $abbreviate = false, bool $firstAndLast = false): string`
- `limitString(string $text, int $limit, string $suffix = '...'): string`
- `removeAccents(string $text): string`
- `onlyNumbers(string $text): string`
- `isPalindrome(string $text): bool`
- `generatePassword(int $minLength = 8, int $maxLength = 32, bool $useUppercase = true, bool $useLowercase = true, bool $useNumbers = true, bool $useSpecialChars = true, bool $exactMaxSize = false, string $specialCharactersNotAllowed = '()-_+=<>'): string`

### ✅ Exemplo de Uso

```php
use InovantiBank\Toolkit\Helpers\StringHelper;

$stringHelper = new StringHelper();

echo $stringHelper->formatName("JOÃO DA SILVA LTDA", true, true);
// Saída: "João Silva"
```

# 🔢 Manipulação de Números (NumberHelper)

## 📌 Métodos Disponíveis

- `formatCurrency(float $amount, string $prefix = 'R$'): string`
- `padZero(int $number, int $length): string`
- `numberToWords(float $value, bool $isCurrency = true): string`
- `formatPercentage(float $value, int $decimals = 2): string`

### ✅ Exemplo de Uso

```php
use InovantiBank\Toolkit\Helpers\NumberHelper;

$numberHelper = new NumberHelper();

echo $numberHelper->formatCurrency(1234.56);
// Saída: "R$ 1.234,56"
```

# 📅 Manipulação de Datas (DateHelper)

## 📌 Métodos Disponíveis

- `formatDate(string $date, string $formatFrom = 'Y-m-d', string $formatTo = 'd/m/Y'): string`
- `addBusinessDays(string $date, int $days): string`

### ✅ Exemplo de Uso

```php
use InovantiBank\Toolkit\Helpers\DateHelper;

$dateHelper = new DateHelper();

echo $dateHelper->formatDate('2025-01-28');
// Saída: "28/01/2025"
```

# 📑 Formatação de Dados (FormatterHelper)

## 📌 Métodos Disponíveis

- `formatCpfCnpj(string $number): string`
- `formatDateHuman(string $date): string`
- `formatDateShortHuman(string $date): string`
- `formatDateTimeHuman(string $date): string`
- `formatDateRelative(string $date): string`
- `formatDateWeekday(string $date): string`
- `formatDateCustom(string $date, string $format): string`

### ✅ Exemplo de Uso

```php
use InovantiBank\Toolkit\Helpers\FormatterHelper;

$formatter = new FormatterHelper();

echo $formatter->formatDateRelative('2025-01-28 14:01:23');
// Saída: "há 2 dias"
```

# ✅ Validação de Documentos (ValidatorHelper)

## 📌 Métodos Disponíveis

- `isValidCPF(string $cpf): bool`
- `isValidCNPJ(string $cnpj): bool`
- `isValidPIS(string $pis): bool`
- `isValidTitle(string $title): bool`
- `isValidRENAVAM(string $renavam): bool`
- `isValidCNH(string $cnh): bool`
- `isValidEmail(string $email): bool`
- `isValidDate(string $date, string $format = 'Y-m-d'): bool`
- `isValidCEP(string $cep): bool`
- `isValidCreditCard(string $number): bool`

### ✅ Exemplo de Uso

```php
use InovantiBank\Toolkit\Helpers\ValidatorHelper;

$validator = new ValidatorHelper(new StringHelper());

echo $validator->isValidCPF('123.456.789-09') ? "Válido" : "Inválido";
// Saída: "Inválido"
```

# 🧮 Conversão de Unidades (UnitConverter)

## 📌 Métodos Disponíveis

- `bytesToHumanReadable(int $bytes, int $precision = 2): string`

### ✅ Exemplo de Uso

```php
use InovantiBank\Toolkit\Helpers\UnitConverter;

$converter = new UnitConverter();

echo $converter->bytesToHumanReadable(1048576);
// Saída: "1.00 MB"
```

# 🧮 Enums Disponíveis

## 📌 CreditCardTypeEnum

Enum responsável por armazenar as bandeiras de cartões e seus formatos:

```php
use InovantiBank\Toolkit\Enums\CreditCardTypeEnum;

echo CreditCardTypeEnum::VISA->getMask();
// Saída: #### #### #### ####
```

## 📌 StateEnum

Enum que representa os 27 estados brasileiros, armazenando a máscara e a quantidade de dígitos esperados da Inscrição Estadual.

```php
use InovantiBank\Toolkit\Enums\StateEnum;

echo StateEnum::SP->getIEMask();
// Saída: ###.###.###.###

echo StateEnum::RJ->getIEDigitLength();
// Saída: 8
```

# 🧪 Testes

O pacote inclui testes unitários para garantir que todas as funcionalidades funcionem conforme o esperado.

```bash
vendor/bin/phpunit
composer test
```

### Para testes unit:

```bash
vendor/bin/phpunit --testsuite=Unit
composer unit
```

# 🤝 Contribuindo

Contribuições são bem-vindas! Se você deseja reportar um bug, solicitar um novo recurso ou contribuir com código, fique à vontade para abrir uma issue ou enviar um Pull Request.

1. Faça um Fork do projeto
2. Crie sua feature branch: `git checkout -b minha-nova-feature`
3. Commit suas mudanças: `git commit -m 'Adiciona nova feature'`
4. Faça o push para a branch: `git push origin minha-nova-feature`
5. Crie um novo Pull Request

---

# 📜 Licença

Este projeto está licenciado sob a [MIT license](https://github.com/Inovanti-Bank/inovanti-toolkit/blob/production/LICENSE).
Sinta-se livre para usá-lo e modificá-lo conforme necessário.

💡 Dúvidas ou sugestões? Abra uma [issue](https://github.com/inovanti-bank/inovanti-toolkit/issues). 🚀
