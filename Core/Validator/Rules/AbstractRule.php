<?php
namespace Core\Validator\Rules;

use Core\Validator\Validator;

/**
 * AbstractRule.php
 *
 * @author Michael "Tekkla" Zorn <tekkla@tekkla.de>
 * @copyright 2016-2017
 * @license MIT
 */
abstract class AbstractRule implements RuleInterface
{

    /**
     *
     * @var string
     */
    protected $msg = '';

    /**
     *
     * @var mixed
     */
    protected $value;

    /**
     *
     * @var bool
     */
    protected $execute_on_empty;

    /**
     *
     * @var Validator
     */
    private $validator;

    /**
     * Constructor
     *
     * @param Validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Sets value to check
     *
     * @param mixed $value
     */
    public function setValue($value)
    {
        // Reset rule object;
        $this->reset();

        // Assign value
        $this->value = $value;
    }

    /**
     * Execute rule on empty value?
     *
     * @return bool
     */
    final public function getExecuteOnEmpty(): bool
    {
        return $this->execute_on_empty ?? true;
    }

    /**
     * Checks for empty txt property and returns result as validation result
     *
     * Empty msg property means the validation check was successful.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->msg);
    }

    /**
     * Returns the stored message
     *
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg ?? '';
    }

    /**
     * Resets rule message.
     *
     * Will be called on rule creation process in validator object.No need to call it manually.
     */
    public function reset()
    {
        // Reset old message;
        unset($this->msg);
    }

    /**
     * Creates a rule object.
     *
     * Ideal for rules where you need to combine or accees another rule.
     *
     * @param string $rule_name
     *
     * @return RuleInterface
     */
    protected function createRule(string $rule_name): RuleInterface
    {
        return $this->validator->createRule($rule_name);
    }

    /**
     * Validation method
     *
     * @param
     *            mixed Optional arguments
     */
    abstract public function execute();
}
