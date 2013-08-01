<?php

class HomeController extends BaseController {

	/**
	 * Display the homepage.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$posts = get_posts()->published()->orderBy('date')->take(5);

		return $this->view('public.index', compact('posts'));
	}

}