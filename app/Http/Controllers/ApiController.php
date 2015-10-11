<?php

namespace Portfolio\Http\Controllers;

use Illuminate\Http\Request;
use Portfolio\Http\Requests;
use Portfolio\Services\ApiService;
use Exception;

class ApiController extends ApiBaseController
{
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
        $requestData = ['section' => $section, 'request' => $request, 'referrerMethod' => 'write'];

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
     * @param  int $id
     * @return Response
     */
    public function destroy($section, $id)
    {
        $requestData = ['section' => $section, 'id' => $id, 'referrerMethod' => 'delete'];

        return $this->runRequest($requestData);
    }

    /**
     * Run Request
     *
     * @param $requestData
     * @return \Illuminate\Http\JsonResponse
     */
    private function runRequest($requestData)
    {
        $service = new ApiService();

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
            ($e->getCode() > 0) ? $code = $e->getCode() : $code = 400;
            $this->response->setContent($e->getMessage())->setStatus($code);
        }

        return response()->json($this->response->getContent(), $this->response->getStatus());
    }
}
