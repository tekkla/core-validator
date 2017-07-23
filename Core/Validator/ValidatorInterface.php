<?php
namespace Core\Validator;

use Core\Validator\Rules\RuleInterface;

/**
 * Validator.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2017
 * @license MIT
 */
interface ValidatorInterface
{

    /**
     * Sets a value to validate
     *
     * When setting a new value the current result stack gets resetted.
     *
     * @param mixed $value
     * @param bool $trim
     *            Flag to control if the value should be trimmed before it's get used
     */
    public function setValue($value, bool $trim = true);

    /**
     * Sets rule (name)
     *
     * @param string $rule
     */
    public function setRule(string $rule);

    /**
     * Returns set rule (name)
     *
     * @return string
     */
    public function getRule(): string;

    /**
     * Sets rule arguments
     *
     * @param array $args
     */
    public function setArgs(array $args);

    /**
     * Returns set rule arguments
     *
     * @return array
     */
    public function getArgs(): array;

    /**
     * Sets custom rule text
     *
     * @param string $text
     */
    public function setText(string $text);

    /**
     * Returns set custom rule text
     *
     * @return string
     */
    public function getText(): string;

    /**
     * Sets the rule to validate the value against
     *
     * @param string|array $rule
     */
    public function parseRule($rule);

    /**
     * Validates a value against a rule and returns bool as result
     *
     * @return bool
     */
    public function validate(): bool;

    /**
     * Returns the last validation result
     *
     * @return bool
     */
    public function isValid(): bool;

    /**
     * Returns the last validation msg
     *
     * @return string
     */
    public function getResult(): string;

    /**
     * Creates and returns a singleton rule object
     *
     * @param string $rule_name
     *            Name of the rule
     *            
     * @return RuleInterface
     */
    public function &createRule(string $rule_name): RuleInterface;
}
