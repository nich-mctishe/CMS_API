<?php

namespace Portfolio\Models;


class Field
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $rules;
    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set Name
     *
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    /**
     * Get Rules
     *
     * @return string
     */
    public function getRules()
    {
        return $this->rules;
    }
    /**
     * Set Rules
     *
     * @param $rules
     *
     * @return $this
     */
    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }
}
