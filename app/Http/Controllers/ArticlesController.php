<?php

namespace App\Http\Controllers;

use App\Events\ArticleWasCreated;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index()
    {
        return view('articles.index', [
            'articles' => (new Article)->all()
        ]);
    }

    public function create()
    {
        $this->authorize('create', Article::class);

        return view('articles.create', [Article::class]);
    }

    public function store(Request $request, Article $article)
    {
        $this->authorize('create', Article::class);

        $article = (new Article)->fill($request->all());
        $article->user()->associate(auth()->user());
        $article->save();

        event(new ArticleWasCreated($article));

        return redirect()->route('articles.index');
    }

    public function show(Article $article)
    {
        return view('articles.show', [
            'article' => $article
        ]);
    }

    public function edit(Article $article)
    {
        $this->authorize('edit', $article);

        return view('articles.edit', [
            'article' => $article
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $article->update($request->all());

        return redirect()->route('articles.edit', $article);
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();

        return redirect()->route('articles.index');
    }
}
