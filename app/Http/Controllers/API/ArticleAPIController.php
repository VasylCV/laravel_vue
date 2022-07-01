<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Article\CreateArticleAPIRequest;
use App\Http\Requests\API\Article\UpdateArticleAPIRequest;
use App\Models\Article;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ArticleController
 * @package App\Http\Controllers\API
 */

class ArticleAPIController extends AppBaseController
{
    /** @var  ArticleRepository */
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepository = $articleRepo;
    }

    /**
     * Display a listing of the Article.
     * GET|HEAD /articles
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $articles = $this->articleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($articles->toArray(), __('app.success.retrieved'));
    }

    /**
     * Store a newly created Article in storage.
     * POST /articles
     *
     * @param CreateArticleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateArticleAPIRequest $request)
    {
        $input = $request->all();

        $input['author_id'] = auth()->id();

        $article = $this->articleRepository->create($input);

        if (!$article) {
            return $this->sendError(__('app.error.save'));
        }

        return $this->sendResponse($article->toArray(), __('app.success.retrieved'));
    }

    /**
     * Display the specified Article.
     * GET|HEAD /articles/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Article $article */
        $article = $this->articleRepository->find($id);

        if (empty($article)) {
            return $this->sendError(__('app.error.noFound'));
        }

        return $this->sendResponse($article->toArray(), __('app.success.retrieved'));
    }

    /**
     * Update the specified Article in storage.
     * PUT/PATCH /articles/{id}
     *
     * @param int $id
     * @param UpdateArticleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateArticleAPIRequest $request)
    {
        $input = $request->all();

        /** @var Article $article */
        $article = $this->articleRepository->find($id);

        if (empty($article)) {
            return $this->sendError(__('app.error.noFound'));
        }

        $input['author_id'] = auth()->id();

        $article = $this->articleRepository->update($input, $id);

        return $this->sendResponse($article->toArray(), __('app.success.updated'));
    }

    /**
     * Remove the specified Article from storage.
     * DELETE /articles/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Article $article */
        $article = $this->articleRepository->find($id);

        if (empty($article)) {
            return $this->sendError(__('app.error.noFound'));
        }

        $article->delete();

        return $this->sendSuccess(__('app.success.deleted'));
    }
}
