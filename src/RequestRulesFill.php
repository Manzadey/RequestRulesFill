<?php

namespace Manzadey\RequestRulesFill;

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
     * @return self
     */
    public function rule(...$rules) : self
    {
        foreach ($this->fields as $field) {
            $this->rules[$field] = $rules;
        }

        return $this;
    }

    public function replaceRule(string $field, string $ruleReplaced, $rule) : self
    {
        $key = array_search($ruleReplaced, $this->rules[$field], true);
        $this->rules[$field][$key] = $rule;

        return $this;
    }

    /**
     * @return array
     */
    public function get() : array
    {
        return $this->rules;
    }
}