<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Add extends CI_Controller
{
    public function index()
    {

        $data['_activeMenu'] = 'add';
        $this->tpl->view('backend/home/', $data);
    }

    public function post()
    {
        $data['_activeMenu'] = 'add';
        $this->tpl->view('frontend/add/post/', $data);
    }
}