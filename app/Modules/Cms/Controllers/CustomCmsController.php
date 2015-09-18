<?php 

namespace App\Modules\Cms\Controllers; 
use App\Http\Controllers\Controller;

class CustomCmsController extends Controller
{
    public function __construct() { }

    public function testAction()
    {
        // Code

        return view('Cms::test_custom_view');
    }
}

