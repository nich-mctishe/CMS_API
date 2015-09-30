<?php

namespace Portfolio\Http\Controllers;

use Portfolio\Models\JsonObject;
use Portfolio\Http\Controllers\Controller;

class ApiBaseController extends Controller
{
    /**
     * all exceptions should be bubbled up to here.
     */

    /**
     * @var JsonObject
     */
    protected $response;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->response = new JsonObject();
    }
}
