<?php
namespace Core\Validator\Rules;

/**
 * BlankRule.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2015
 * @license MIT
 */
class BlankRule extends AbstractRule
{

    /**
     * (non-PHPdoc)
     *
     * @see \Core\Validator\Rules\AbstractRule::execute()
     */
    public function execute()
    {
        $result = $this->value !== '' ? true : false;

        if (!$result) {
            $this->msg = 'validator.rule.blank';
        }
    }
}
