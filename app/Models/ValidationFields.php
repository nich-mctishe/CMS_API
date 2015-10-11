<?php

namespace Portfolio\Models;

use Portfolio\Exceptions\ArrayKeyNotFoundException;
use Portfolio\Exceptions\FieldNotFoundException;
use Portfolio\Models\Field;

class ValidationFields
{
    /**
     * @var array[Field]
     */
    protected $fields;
    /**
     * Add Field
     *
     * @param $name
     * @param $rules
     *
     * @return $this
     */
    public function addField($name, $rules)
    {
        $field = new Field();
        $field->setName($name)->setRules($rules);

        return $this;
    }
    /**
     * Get Field
     *
     * @param $index
     *
     * @return mixed
     */
    public function getField($index)
    {
        if (!array_key_exists($index, $this->fields)) {
            throw new ArrayKeyNotFoundException('the field does not exist', 401);
        }

        return $this->fields[$index];
    }
    /**
     * Get Field
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get Field By Name
     *
     * @param $name
     * @throws FieldNotFoundException
     *
     * @return null
     */
    public function getFieldByName($name)
    {
        $field = null;

        foreach ($this->fields as $fieldEntry) {
               if ($field->getName() == $name) {
                   $field = $fieldEntry;
               }
        }

        if (null != $field) {
            return $field;
        }

        throw new FieldNotFoundException(spritf("the field %s does not exist", $name), 401);
    }
}