<?php
namespace Core\Validator\Rules;

/**
 * RequiredRule.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2015
 * @license MIT
 */
class RequiredRule extends AbstractRule
{

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Validator\Rules\AbstractRule::execute()
     */
    public function execute()
    {
        $result = !empty($this->value);
        
        if (!$result) {
            $this->msg = 'validator.rule.required';
        }
    }
}
