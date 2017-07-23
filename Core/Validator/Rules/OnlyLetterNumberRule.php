<?php
namespace Core\Validator\Rules;

/**
 * OnlyLetterNumberRule.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class OnlyLetterNumberRule extends AbstractRule
{

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Validator\Rules\AbstractRule::execute()
     *
     */
    public function execute()
    {
        $regexp = '/^[0-9a-zA-Z]+$/';
        
        $result = filter_var($this->value, FILTER_VALIDATE_REGEXP, [
            'options' => [
                'regexp' => $regexp
            ]
        ]);
        
        if (!$result) {
            $this->msg = 'validator.rule.alnum';
        }
    }
}
