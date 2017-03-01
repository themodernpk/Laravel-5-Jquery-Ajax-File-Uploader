<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class FileController extends BaseController
{
    public function index()
    {
        return view('file-form');
    }
    //--------------------------------------------
    public function fileUploader(Request $request)
    {
        error_reporting(E_ALL | E_STRICT);
        new \App\Http\Controllers\UploadController();
    }
    //--------------------------------------------
}