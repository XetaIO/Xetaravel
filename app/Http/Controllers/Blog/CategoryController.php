<?php
namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Show the article by his id.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug, $id)
    {
        $category = Category::with('articles')
            ->where('id', $id)
            ->first();

        if (is_null($category)) {
            return redirect()
                ->route('blog_article_index')
                ->with('danger', 'This category doesn\'t exist or has been deleted !');
        }

        $articles = $category->articles()->paginate(10);

        return view('Blog::category.show', ['articles' => $articles, 'category' => $category]);
    }
}
