<?php

namespace Portfolio\Http\Controllers;

use Jenssegers\Agent\Agent;

class ViewController extends Controller {

    protected $agent;

    protected $data;

    public function __construct()
    {
        $this->agent = new Agent();
        $this->data = [
            'agent' => $this->agent,
        ];
    }

    public function index($routeSuffix)
    {
        $this->data['pageType'] = $routeSuffix;
        ($routeSuffix == 'projlets') ? 'projects' : $routeSuffix;

        return view('content.'.$routeSuffix, $this->data);
    }

    public function runHome()
    {
        return view('main', $this->data);
    }
}