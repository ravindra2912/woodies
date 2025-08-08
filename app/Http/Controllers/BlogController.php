<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BlogController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index(Request $request)
	{		
		

		return view('front.blog.index');
	}
	
	public function details(Request $request, $slug)
	{		
		$blog = Blog::where('slug', $slug)->first();

		return view('front.blog.details', compact('blog'));
	}
}
