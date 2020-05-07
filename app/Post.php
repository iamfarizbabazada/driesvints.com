<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

final class Post extends Model implements Feedable
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at',
    ];

    public function previous(): ?Post
    {
        return self::query()->where('published_at', '<', $this->published_at)->orderByDesc('published_at')->first();
    }

    public function next(): ?Post
    {
        return self::query()->where('published_at', '>', $this->published_at)->orderBy('published_at')->first();
    }

    public function excerpt(int $length = 255): string
    {
        $content = $this->excerpt ?? $this->content();
        $cleaned = strip_tags(
            preg_replace(['/<pre>[\w\W]*?<\/pre>/', '/<h\d>[\w\W]*?<\/h\d>/'], '', $content),
            '<code>'
        );
        $truncated = substr($cleaned, 0, $length);

        if (substr_count($truncated, '<code>') > substr_count($truncated, '</code>')) {
            $truncated .= '</code>';
        }

        return strlen($cleaned) > $length
            ? preg_replace('/\s+?(\S+)?$/', '', $truncated) . '...'
            : $cleaned;
    }

    public function content(): string
    {
        return app(Markdown::class)->toHtml($this->content);
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id(route('post', $this))
            ->title($this->title)
            ->summary($this->excerpt())
            ->updated($this->updated_at)
            ->link(route('post', $this))
            ->author('Dries Vints');
    }

    public static function getFeedItems(): Collection
    {
        return Post::all();
    }
}