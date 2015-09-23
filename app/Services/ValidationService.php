<?php

namespace Portfolio\Services;

use Symfony\Component\CssSelector\Exception\SyntaxErrorException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;
use Portfolio\Exceptions\EmptyFileException;
use Portfolio\Exceptions\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ValidationService
{
    /**
     * @var string
     */
    protected $yamlFolder;

    /**
     * @var string
     */
    protected $yamlFileName;

    public function __construct($yamlFileName = null, $yamlFolder = null)
    {
        ($yamlFolder == null) ? $this->yamlFolder = '../../portfolio/storage/yaml' : $this->yamlFolder = $yamlFolder;
        ($yamlFileName == null) ? $this->yamlFileName = 'ValidationRules.yml' : $this->yamlFileName = $yamlFileName;
    }

    /**
     * Run Validation
     *
     * @param $section
     * @param Request $request
     *
     * @throws ValidationException
     */
    public function runValidation($section, Request $request)
    {
        $rules = $this->getValidationRules($section);
        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            throw new ValidationException($validation->errors()->toJson(), 402);
        }
        //the validate function takes a third optional input of error messages that could be tailored to the api.
    }

    /**
     * Run Validation From Array
     *
     * @param $section
     * @param $array
     *
     * @throws ValidationException
     */
    public function runValidationFromArray($section, $array)
    {
        $rules = $this->getValidationRules($section);

        foreach ($array as $entry) {
            $validation = Validator::make($entry, $rules);

            if ($validation->fails()) {

                throw new ValidationException($validation->errors()->toJson(), 402);
            }
        }
    }

    /**
     * Get Validation Rules
     *
     * @param $section
     * @throws EmptyFileException
     * @throws FileNotFoundException
     * @throws ParseException
     *
     * @return array
     */
    private function getValidationRules($section)
    {
        $data = $this->buildFromYaml();
        $validationRules = [];

        foreach ($data[ucfirst($section)]['ValidationRules'] as $validationRule) {
            $validationRules[$validationRule['name']] = $validationRule['criteria'];
        }

        return $validationRules;
    }

    /**
     * Build From Yaml
     *
     * @param $section
     * @throws EmptyFileException
     * @throws FileNotFoundException
     * @throws ParseException
     *
     * @return array
     */
    private function buildFromYaml()
    {
        $yamlFile = $this->yamlFolder.'/'.$this->yamlFileName;

        if (!file_exists($yamlFile)) {
            throw new FileNotFoundException($yamlFile, 500);
        }

        try {
            $yaml = new Parser();
            $data = $yaml->parse(file_get_contents($yamlFile, true));
            if (null === $data) {
                throw new EmptyFileException(sprintf('The %s file is empty and cannot be parsed.', $yamlFile), 500);
            }
        } catch (SyntaxErrorException $e) {
            throw new ParseException($e->getMessage(), 500, $e);
        }

        return $data;
    }
}
