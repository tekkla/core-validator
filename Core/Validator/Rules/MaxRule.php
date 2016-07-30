<?php
namespace Core\Validator\Rules;

/**
 * MaxRule.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class MaxRule extends AbstractRule
{

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Validator\Rules\AbstractRule::execute()
     */
    public function execute()
    {
        // Which rule object shoud be used? Number or text?
        $rule_name = is_numeric($this->value) ? 'NumberMax' : 'TxtMaxLength';
        
        $rule = $this->createRule($rule_name);
        $rule->setValue($this->value);
        $rule->execute(func_get_arg(0));
        
        // Work with the result of check
        if (!$rule->isValid()) {
            $this->msg = $rule->getMsg();
        }
    }
}

