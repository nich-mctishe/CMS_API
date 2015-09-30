<?php

namespace Portfolio\Http\Controllers;

use Jenssegers\Agent\Agent;

class ViewController extends Controller
{
    /**
     * @var Agent
     */
    protected $agent;

    /**
     * @var array
     */
    protected $data;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->agent = new Agent();
        $this->data = [
            'agent' => $this->agent,
        ];
    }

    /**
     * Index - route requested pages
     *
     * @param $routeSuffix
     *
     * @return \Illuminate\View\View
     */
    public function index($routeSuffix)
    {
        $this->data['pageType'] = $routeSuffix;
        ($routeSuffix == 'projlets') ? $routeSuffix = 'projects' : $routeSuffix;

        return view('content.'.$routeSuffix, $this->data);
    }

    /**
     * Run Home (Main) Page
     *
     * @return \Illuminate\View\View
     */
    public function runHome()
    {
        return view('main', $this->data);
    }

    /**
     * Redirect to baseUrl when hit
     *
     * @return Redirect
     */
    public function redirectToBase()
    {
        return redirect()->intended('/');
    }
}
