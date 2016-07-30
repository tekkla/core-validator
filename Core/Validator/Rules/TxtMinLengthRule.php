<?php
namespace Core\Validator\Rules;

/**
 * TxtMinLengthRule.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class TxtMinLengthRule extends AbstractRule
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

        $result = strlen((string) $this->value) >= $min;

        if (!$result) {
            $this->msg = [
                'validator.rule.textminlength',
                [$min]
            ];
        }
    }
}
