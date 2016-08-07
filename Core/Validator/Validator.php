<?php
namespace Core\Validator;

use Core\Validator\Rules\RuleInterface;
use Core\Toolbox\Strings\CamelCase;

/**
 * Validator.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016
 * @license MIT
 */
class Validator
{

    /**
     *
     * @var string
     */
    private $result;

    /**
     *
     * @var string
     */
    private $rule;

    /**
     *
     * @var array
     */
    private $args = [];

    /**
     *
     * @var string
     */
    private $text;

    /**
     *
     * @var mixed
     */
    private $value;

    /**
     * Storage for already loaded rules
     *
     * @var array
     */
    private static $rules = [];

    /**
     * Sets a value to validate
     *
     * When setting a new value the current result stack gets resetted.
     *
     * @param mixed $value
     * @param bool $trim
     *            Flag to control if the value should be trimmed before it's get used
     */
    public function setValue($value, bool $trim = true)
    {
        if ($trim) {
            $value = trim($value);
        }

        $this->value = $value;
        $this->result = [];
    }

    /**
     * Sets rule (name)
     *
     * @param string $rule
     *
     * @throws ValidatorException
     */
    public function setRule(string $rule)
    {
        if (empty($rule)) {
            Throw new ValidatorException('Empty rule names are not allowed.');
        }

        $this->rule = $rule;
        $this->result = [];
    }

    /**
     * Returns set rule (name)
     *
     * @return string
     */
    public function getRule(): string
    {
        return $this->rule;
    }

    /**
     * Sets rule arguments
     *
     * @param array $args
     */
    public function setArgs(array $args)
    {
        $this->args = $args;
    }

    /**
     * Returns set rule arguments
     *
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * Sets custom rule text
     *
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * Returns set custom rule text
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Sets the rule to validate the value against
     *
     * @param string|array $rule
     */
    public function parseRule($rule)
    {
        unset($this->rule);
        unset($this->text);
        unset($this->result);

        $this->args = [];

        $string = new CamelCase('');

        // Array type rules are for checks where the func needs one or more parameter
        // So $rule[0] is the func name and $rule[1] the parameter.
        // Parameters can be of type array where the elements are used as function parameters in the .. they are
        // set.
        if (is_array($rule)) {

            // Get the functionname
            $string->setString($rule[0]);
            $this->setRule($string->camelize());

            // Parameters set?
            if (isset($rule[1])) {
                $this->args = !is_array($rule[1]) ? [
                    $rule[1]
                ] : $rule[1];
            }

            // Custom error message
            if (isset($rule[2])) {
                $this->text = $rule[2];
            }
        }
        else {
            // Get the functionname
            $string->setString($rule);
            $this->setRule($string->camelize());
        }
    }

    /**
     * Validates a value against a rule and returns bool as result
     *
     * @return bool
     */
    public function validate(): bool
    {
        // Call rule creation process to make sure rule exists before starting further actions.
        $rule = $this->createRule($this->rule);

        // Execute rule on empty values only when rule is explicitly flagged to do so.
        if (empty($this->value) && $rule->getExecuteOnEmpty() == false) {
            return true;
        }

        $rule->setValue($this->value);

        // Calling the validation function
        call_user_func_array([
            $rule,
            'execute'
        ], $this->args);

        // Is the validation result negative eg false?
        if ($rule->isValid() === false) {

            // Get msg from rule
            $msg = $rule->getMsg();

            // If no error message is set, use the default validator error
            if (empty($msg)) {
                $msg = $this->text ?? 'validator.error';
            }

            $this->result = $msg;
        }

        return $this->isValid();
    }

    /**
     * Returns the last validation result
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->result);
    }

    /**
     * Returns the last validation msg
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Creates and returns a singleton rule object
     *
     * @param string $rule_name
     *            Name of the rule
     *
     * @return RuleInterface
     */
    public function &createRule($rule_name): RuleInterface
    {
        // Make sure that the rules name is camelcased
        $string = new CamelCase($rule_name);
        $rule_name = $string->camelize();

        // Rules have to be singletons
        if (empty(self::$rules[$rule_name])) {

            // Without a leading \ in the rulename it is assumened that we use a Core FW builtin rule
            // otherwise the $rule_name points to a class somewhere outsite of the frameworks default rules.
            $rule_class = strpos($rule_name, '\\') == 0 ? __NAMESPACE__ . '\Rules\\' . $rule_name . 'Rule' : $rule_name;

            // Create the rule obejct instance
            $rule_object = new $rule_class($this);

            // The rule object must be a child of RuleAbstract!
            if (!$rule_object instanceof RuleInterface) {
                Throw new ValidatorException('Validator rules MUST be a either implement the \Core\Validator\Rules\RuleInterface or be an instance of \Core\Validator\Rules\AbstractRule which implements this interface.');
            }

            // Add rule to the rules stack
            self::$rules[$rule_name] = $rule_object;
        }
        else {

            // Reset existing rules
            self::$rules[$rule_name]->reset();
        }

        return self::$rules[$rule_name];
    }
}
