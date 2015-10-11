<?php

namespace Portfolio\Http\Controllers;

use Jenssegers\Agent\Agent;
use Portfolio\Services\ApiService;

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

        return view('content.'.$routeSuffix, $this->data);
    }

    /**
     * Build Landing Page
     *
     * @param $routeSuffix
     * @param null $articleId
     * @throws \Exception
     *
     * @return \Illuminate\View\View
     */
    public function landingPage($routeSuffix, $articleId = null)
    {
        $service = new ApiService();
        $this->data['pageType'] = $routeSuffix;
        $this->data['pageContent'] = $service->read(str_singular($routeSuffix), $articleId);

        return view('landingPages.'.$routeSuffix, $this->data);
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
