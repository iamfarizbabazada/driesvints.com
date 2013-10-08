<?php

class TagsController extends BaseController {

	/**
	 * Displays a listing of all the posts with a specific tag.
	 *
	 * @return \Illuminate\View\View
	 */
	public function show($tag)
	{
		$posts = get_posts()
			->published()
			->filter(function($post) use ($tag)
			{
				return in_array($tag, $post->tags);
			})
			->orderBy('date', 'desc');

		return View::make('tag', compact('tag', 'posts'));
	}

}