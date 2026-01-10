<?php

namespace App\Classes\Core;

class Validator
{
    private array $data;
    private array $rules;
    private array $errors = [];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;

        $this->run();
    }

    private function run(): void
    {
        foreach ($this->rules as $field => $rulesString) {

            $rules = explode('|', $rulesString);
            $value = $this->data[$field] ?? null;

            foreach ($rules as $rule) {

                $params = null;

                if (str_contains($rule, ':')) {
                    [$rule, $params] = explode(':', $rule);
                }

                $method = "validate" . ucfirst($rule);

                if (method_exists($this, $method)) {
                    $this->$method($field, $value, $params);
                }
            }
        }
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    private function addError(string $field, string $message): void
    {
        $this->errors[$field] = $message;
    }

    private function validateRequired(string $field, $value): void
    {
        if ($value === null || $value === '') {
            $this->addError($field, "Le champ $field est obligatoire.");
        }
    }

    private function validateEmail(string $field, $value): void
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "Le champ $field doit être un email valide.");
        }
    }

    private function validateMin(string $field, $value, $min): void
    {
        if (strlen($value) < (int) $min) {
            $this->addError($field, "Le champ $field doit contenir au moins $min caractères.");
        }
    }

    private function validateMax(string $field, $value, $max): void
    {
        if (strlen($value) > (int) $max) {
            $this->addError($field, "Le champ $field ne peut pas dépasser $max caractères.");
        }
    }

    private function validateNumeric(string $field, $value): void
    {
        if (!is_numeric($value)) {
            $this->addError($field, "Le champ $field doit être un nombre.");
        }
    }

    private function validateString(string $field, $value): void
    {
        if (!is_string($value)) {
            $this->addError($field, "Le champ $field doit être une chaîne de caractères.");
        }
    }

    private function validateConfirmed(string $field, $value): void
    {
        $confirmation = $this->data[$field . '_confirmation'] ?? null;

        if ($value !== $confirmation) {
            $this->addError($field, "Le champ $field doit être confirmé.");
        }
    }
}