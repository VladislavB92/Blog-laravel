<?php

namespace App\Listeners\ArticleWasCreated;

use App\Events\ArticleWasCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateArticlesCount implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ArticleWasCreated $event)
    {
        $article = $event->article;

        $article->user->update([
            'articles_count' => $article->user->articles()->count()
        ]);
    }
}
 