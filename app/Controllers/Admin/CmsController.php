<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MetaData;

class CmsController extends BaseController
{
    public function index()
    {
        //
    }
    public function about()
    {
        $AboutModel = new MetaData();
        $about = $AboutModel->getData('about');
        return view('admin/cms/about', ['about' => $about]);
    }
    public function aboutSet()
    {
        $this->validate([
            'about' => 'required',
        ]);
        $AboutModel = new MetaData();
        $AboutModel->setData('about', $this->request->getPost('about'));
        return redirect()->back()->with('success', 'About section updated successfully.');
    }
}
