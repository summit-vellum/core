<?php


namespace Vellum\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Quill\Post\Resource\PostResource;
use Vellum\Contracts\Shortcode;
use App\Http\Controllers\Controller;


class ShortcodeController extends Controller
{

	public $shortcode;


	public function __construct(?Shortcode $shortcode)
	{
		if(!$shortcode) return;

        $this->middleware('auth');

		$this->shortcode = $shortcode;

	}

	public function index(Request $request)
	{
        return $this->shortcode->view($request);
	}

	public function store(Request $request)
	{
		//dd($request->all());
		return $this->shortcode->registerShortcodeCookie($request);
	}
}
