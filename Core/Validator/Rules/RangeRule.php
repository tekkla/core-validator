<?php
namespace Core\Validator\Rules;

/**
 * RangeRule.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class RangeRule extends AbstractRule
{

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Validator\Rules\AbstractRule::execute()
     */
    public function execute()
    {
        // Which rule object shoud be used? Number or text?
        $rule_name = is_numeric($this->value) ? 'NumberRange' : 'TxtLengthBetween';

        \FB::log($rule_name);

        $rule = $this->createRule($rule_name);
        $rule->setValue($this->value);
        $rule->execute(func_get_arg(0), func_get_arg(1));

        // Work with the result of check
        if (!$rule->isValid()) {
            $this->msg = $rule->getMsg();
        }
    }
}

