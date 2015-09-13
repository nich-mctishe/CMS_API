<?php

namespace Portfolio\Http\Controllers;


class ViewController extends Controller {


    public function index() {
        return view('main');
    }


}