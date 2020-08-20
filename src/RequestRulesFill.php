<?php

namespace Manzadey\RequestRulesFill;

/**
 * Class RequestRulesFill
 *
 * @package Manzadey\RequestRulesFill
 */
class RequestRulesFill
{
    /**
     * @var string
     */
    private $fields = [];

    /**
     * @var array
     */
    private $rules = [];

    /**
     * @param array $fields
     *
     * @return $this
     */
    public function fields(...$fields) : self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @param mixed ...$rules
     *
     * @return $this
     */
    public function rule(...$rules) : self
    {
        foreach ($this->fields as $field) {
            $this->rules[$field] = isset($this->rules[$field]) ? array_merge($this->rules[$field], $rules) : $rules;;
        }

        return $this;
    }

    /**
     * @param string $field
     * @param string $ruleReplaced
     * @param        $rule
     *
     * @return $this
     */
    public function replaceRule(string $field, string $ruleReplaced, $rule) : self
    {
        $key = array_search($ruleReplaced, $this->rules[$field], true);
        $this->rules[$field][$key] = $rule;

        return $this;
    }

    /**
     * @param string $field
     * @param mixed  ...$rules
     *
     * @return $this
     */
    public function addRuleToField(string $field, ...$rules)
    {
        $this->rules[$field] = array_unique(array_merge($this->rules[$field], $rules));

        return $this;
    }

    /**
     * @return array
     */
    public function get() : array
    {
        return $this->rules;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return $this->get();
    }

    /**
     * @return string
     */
    public function getFields() : string
    {
        return $this->fields;
    }

    /**
     * @param string $fields
     */
    public function setFields(string $fields) : void
    {
        $this->fields = $fields;
    }

    /**
     * @return array
     */
    public function getRules() : array
    {
        return $this->rules;
    }

    /**
     * @param array $rules
     */
    public function setRules(array $rules) : void
    {
        $this->rules = $rules;
    }
}