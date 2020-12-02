<?php

namespace App\Listeners\ArticleWasCreated;

use App\Events\ArticleWasCreated;

class UpdateArticlesCount
{
    public function handle(ArticleWasCreated $event)
    {
        $article = $event->article;

        $article->user->update([
            'articles_count' => $article->user->articles()->count()
        ]);
    }
}
 