<?php

namespace App;

use Illuminate\Http\Request;

class FormValidation
{
    /**
     * Validate data.
     *
     * @param Request $request
     *  Request data.
     * @param array $inputs
     *  Rules.
     * @return array
     *  Return array of errors.
     */
    public static function validate(Request $request, array $rules)
    {
        $errors = array();

        foreach ($rules as $key => $rule) {
            $ruleSets = explode('|', $rule);
            foreach ($ruleSets as $ruleSet) {
                $isValidated = self::validateInputRule($ruleSet, $request->{$key});
                if (!$isValidated) {
                    $errors[$key] = [
                        'name' => $key,
                        'rule' => $ruleSet,
                    ];
                    break;
                }
            }
        }

        return $errors;
    }

    /**
     * Validate rule with value.
     *
     * @param string $rule
     *  Rule.
     * @param string $value
     *  Value to be validated.
     * @return bool
     *  Return true if is validated.
     */
    public static function validateInputRule($rule, $value)
    {
        switch ($rule) {
            case 'required':
                if (!isset($value)) {
                    return false;
                }
                break;
            
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return false;
                }
                break;
            default:
                # code...
                break;
        }

        return true;
    }
}
