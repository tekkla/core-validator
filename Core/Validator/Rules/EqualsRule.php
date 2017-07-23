<?php
namespace Core\Validator\Rules;

/**
 * EqualsRule.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class EqualsRule extends AbstractRule
{

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Validator\Rules\AbstractRule::execute()
     */
    public function execute()
    {
        $to_compare = func_get_arg(0);
        
        if (is_string($this->value) && is_string($to_compare)) {
            $result = $this->value == $to_compare ? true : false;
        }
        elseif ((is_int($this->value) && is_int($to_compare)) || (is_float($this->value) && is_float($to_compare))) {
            $result = $this->value == $to_compare ? true : false;
        }
        else {
            $result = false;
        }
        
        if (!$result) {
            $this->msg = 'validator.rule.equals';
        }
    }
}
