<?php
namespace Core\Validator\Rules;

/**
 * NumberRangeRule.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class NumberRangeRule extends AbstractRule
{

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Validator\Rules\AbstractRule::execute()
     *
     */
    public function execute()
    {
        $min = func_get_arg(0);
        $max = func_get_arg(1);
        
        $result = $this->value >= $min && $this->value <= $max;
        
        if (!$result) {
            $this->msg = [
                'validator.rule.numberrange',
                [
                    $min,
                    $max
                ]
            ];
        }
    }
}
