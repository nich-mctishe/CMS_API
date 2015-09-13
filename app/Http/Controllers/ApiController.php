<?php

namespace Portfolio\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Portfolio\Exceptions\EmptyFileException;
use Portfolio\Http\Requests;
use Portfolio\Http\Controllers\Controller;
use Portfolio\Models\JsonObject;
use Portfolio\Services\ApiService;
use Exception;
use Symfony\Component\CssSelector\Exception\SyntaxErrorException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

class ApiController extends Controller
{
    /**
     * all exceptions should be bubbled up to here.
     */

    protected $response;

    public function __construct()
    {
        $this->response = new JsonObject();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $section
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create($section, Request $request)
    {
        $requestData = ['section' => $section, 'request' => $request, 'referrerMethod' => 'create'];

        return $this->runRequest($requestData);
    }

    /**
     * Display the specified resource.
     *
     * @param string $section
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($section, $id = null)
    {
        $requestData = ['section' => $section, 'id' => $id, 'referrerMethod' => 'read'];

        return $this->runRequest($requestData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @param  $section
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($section, $id, Request $request)
    {
        $requestData = ['section' => $section, 'id' => $id, 'request' => $request, 'referrerMethod' => 'update'];

        return $this->runRequest($requestData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($section, $id)
    {
        $requestData = ['section' => $section, 'id' => $id, 'referrerMethod' => 'delete'];

        return $this->runRequest($requestData);
    }

    private function runRequest($requestData)
    {
        $service = new ApiService();
        $validation = $this->runValidation($requestData);
        if ($validation['success']) {
            try {
                switch ($requestData['referrerMethod']) {
                    case 'write':
                        $action = $service->write($requestData['section'], $requestData['request']);
                        break;
                    case 'update':
                        $action = $service->update($requestData['section'], $requestData['id'], $requestData['request']);
                        break;
                    case 'delete':
                        $action = $service->delete($requestData['section'], $requestData['id']);
                        break;
                    default:
                        $action = $service->read($requestData['section'], $requestData['id']);
                        break;
                }
                $this->response->setContent($action)->setStatus(200);
            } catch (Exception $e) {
                $this->response->setContent($e->getMessage())->setStatus($e->getCode());
            }
        } else {
            $this->response->setContent($validation['errors'])->setStatus(401);
        }

        return response()->json($this->response->getContent(), $this->response->getStatus());
    }

    private function runValidation($requestData)
    {
        $result = ['success' => false];
        if ('delete' != $requestData['referrerMethod'] && 'read' != $requestData['referrerMethod']) {
            $rules = $this->getValidationRules($requestData['section']);
            $validation = Validator::make($requestData['request']->all(), $rules);

            if ($validation->fails()) {
                $result['errors'] = $validation->errors()->toJson();
            } else {
                $result['success'] = true;
            }
            //the validate function takes a third optional input of error messages that could be tailored to the api.
        } else {
            $result['success'] = true;
        }

        return $result;
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
        $data = $this->buildFromYaml($section);

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
    private function buildFromYaml($section)
    {
        $yamlFolder = '../../portfolio/storage/yaml';
        $yamlFileName = 'ValidationRules.yml';
        $yamlFile = $yamlFolder.'/'.$yamlFileName;

        if (!file_exists($yamlFile)) {
            //throw file not found exception
            throw new FileNotFoundException($yamlFile, 500);
        }

        try {
            $yaml = new Parser();
            $data = $yaml->parse(file_get_contents($yamlFile, true));
            if (null === $data) {
                //throw empty file exception
                throw new EmptyFileException(sprintf('The %s file is empty and cannot be parsed.', $yamlFile), 500);

            }

        } catch (SyntaxErrorException $e) {
            //throw parse exception
            throw new ParseException($e->getMessage(), 500, $e);
        }

        return $data;
    }
}
