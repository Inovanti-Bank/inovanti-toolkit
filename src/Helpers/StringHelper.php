<?php

namespace InovantiBank\Toolkit\Helpers;

use InvalidArgumentException;

class StringHelper
{
    protected array $lowercaseWords = [
        'da', 'de', 'do', 'dos', 'das', 'e', 'a', 'ao',
    ];

    protected array $uppercaseWords = [
        'S.A.', 'S.A', 'SA', 'LTDA', 'LTDA.', 'MEI', 'ME', 'EIRELI', 'FIDC',
    ];

    public function formatName(string $name, bool $abbreviate = false, bool $firstAndLast = false): string
    {
        $nameParts = explode(' ', mb_strtolower(trim($name), 'UTF-8'));
        $formattedName = [];

        foreach ($nameParts as $index => $part) {
            if (in_array($part, $this->lowercaseWords, true)) {
                $formattedName[] = $part;
            } elseif (in_array(strtoupper($part), $this->uppercaseWords, true)) {
                $formattedName[] = strtoupper($part);
            } else {
                $formattedName[] = mb_convert_case($part, MB_CASE_TITLE, 'UTF-8');
            }
        }

        if ($abbreviate) {
            foreach ($formattedName as $key => $word) {
                if (! in_array($word, $this->lowercaseWords, true) && ! in_array($word, $this->uppercaseWords, true)) {
                    if ($key !== 0 && $key !== array_key_last($formattedName)) {
                        $formattedName[$key] = mb_substr($word, 0, 1, 'UTF-8').'.';
                    }
                }
            }
        }

        if ($firstAndLast) {
            return reset($formattedName).' '.end($formattedName);
        }

        return implode(' ', $formattedName);
    }

    public function limitString(string $text, int $limit, string $suffix = '...'): string
    {
        if (mb_strlen($text, 'UTF-8') > $limit) {
            return mb_substr($text, 0, $limit, 'UTF-8').$suffix;
        }

        return $text;
    }

    public function removeAccents(string $text): string
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    }

    public function onlyNumbers(string $text): string
    {
        return preg_replace('/\D/', '', $text);
    }

    public function onlyAlphanumeric(string $text, bool $toUpperCase = false): string
    {
        $cleaned = preg_replace('/[^a-zA-Z0-9]/', '', $text);

        return $toUpperCase ? strtoupper($cleaned) : $cleaned;
    }

    public function isPalindrome(string $text): bool
    {
        $cleanedText = preg_replace('/[^a-zA-Z0-9]/', '', mb_strtolower($text, 'UTF-8'));

        return $cleanedText === strrev($cleanedText);
    }

    public function generatePassword(
        int $minLength = 8,
        int $maxLength = 32,
        bool $useUppercase = true,
        bool $useLowercase = true,
        bool $useNumbers = true,
        bool $useSpecialChars = true,
        bool $exactMaxSize = false,
        string $specialCharactersNotAllowed = '()-_+=<>'
    ): string {
        $minLength = max(8, $minLength);
        $maxLength = min(32, $maxLength);

        if (! $useUppercase && ! $useLowercase && ! $useNumbers && ! $useSpecialChars) {
            throw new InvalidArgumentException('Ao menos um tipo de caractere deve ser permitido.');
        }

        $charSets = [
            'uppercase' => $useUppercase ? 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' : '',
            'lowercase' => $useLowercase ? 'abcdefghijklmnopqrstuvwxyz' : '',
            'numbers' => $useNumbers ? '0123456789' : '',
            'special' => $useSpecialChars ? '!@#$%^&*()-_+=<>?' : '',
        ];

        foreach ($charSets as $key => $chars) {
            if ($chars && $useSpecialChars) {
                $charSets[$key] = str_replace(str_split($specialCharactersNotAllowed), '', $chars);
            }
        }

        $availableChars = implode('', $charSets);
        if (empty($availableChars)) {
            throw new InvalidArgumentException('Após a exclusão, é necessário permitir pelo menos um tipo de caractere.');
        }

        $length = $exactMaxSize ? $maxLength : random_int($minLength, $maxLength);
        $password = [];

        foreach ($charSets as $chars) {
            if ($chars) {
                $password[] = $chars[random_int(0, strlen($chars) - 1)];
            }
        }

        while (count($password) < $length) {
            $password[] = $availableChars[random_int(0, strlen($availableChars) - 1)];
        }

        shuffle($password);

        return implode('', $password);
    }
}
