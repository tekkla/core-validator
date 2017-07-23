<?php
namespace Core\Validator\Rules;

/**
 * Time24Rule.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class Time24Rule extends AbstractRule
{

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Validator\Rules\AbstractRule::execute()
     *
     */
    public function execute()
    {
        $regexp = '/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/';
        $result = filter_var($this->value, FILTER_VALIDATE_REGEXP, [
            'options' => [
                'regexp' => $regexp
            ]
        ]);

        if (!$result) {
            $this->msg = 'validator.rule.time24';
        }
    }
}
