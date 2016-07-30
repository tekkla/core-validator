<?php
namespace Core\Validator\Rules;

/**
 * NumberMaxRule.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class NumberMaxRule extends AbstractRule
{

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Validator\Rules\AbstractRule::execute()
     *
     */
    public function execute()
    {
        $max = func_get_arg(0);

        $result = $this->value <= $max;

        if (!$result) {
            $this->msg = [
                'validator.rule.numbermax',
                [
                    $max
                ]
            ];
        }
    }
}
