<?php

namespace Portfolio\Http\Controllers;

use Portfolio\Services\ApiFileService;
use Portfolio\Models\JsonObject;

class ApiFileController extends Controller {

    /**
     * all exceptions should be bubbled up to here.
     */
    protected $response;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->response = new JsonObject();
    }

    /**
     * File Upload Action
     *
     * @param $parentSection
     * @param $parentId
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fileUploadAction($parentSection, $parentId, $id = null)
    {
        try {
            $fileService = new ApiFileService($parentSection, $parentId);
            $data = $fileService->handleImages($id);
            $this->response->setContent($data)->setStatus(200);
        } catch (Exception $e) {
            $this->response->setContent($e->getMessage())->setStatus($e->getCode());
        }

        return response()->json($this->response->getContent(), $this->response->getStatus());
    }
}
