<?php
namespace Core\Validator\Rules;

/**
 * DateRule.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class DateRule extends AbstractRule
{

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Validator\Rules\AbstractRule::execute()
     *
     */
    public function execute()
    {
        $result = strtotime($this->value) === false ? false : true;
        
        if (!$result) {
            $this->msg = 'validator.rule.date';
        }
    }
}
