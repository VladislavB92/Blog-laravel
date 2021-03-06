<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;

class ArticlePolicy
{
    public function update(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }

    public function create(User $user): bool
    {
        return $user->articles->count() < 200;
    }

    public function edit(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }

    public function store(User $user): bool
    {
        return true;
    }
}
