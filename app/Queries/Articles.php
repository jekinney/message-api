<?php

namespace App\Queries;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Queries\Contracts\EloquentQueries;
use Illuminate\Pagination\LengthAwarePaginator;

class Articles extends EloquentQueries
{
    /**
     * Data to display a message
     *
     * @return Model
     */
    public function show(): Model
    {
        return $this->load('comments', 'comments.replies');
    }

    /**
     * Store a new message
     *
     * @param  Request $request
     * @return Model
     */
    public function store(Request $request): Model
    {
        $article = $this->create($this->validate($request));

        return $article->load('comments', 'comments.replies');
    }

    /**
     * Update a message
     *
     * @param  Request $request
     * @return Model
     */
    public function renew(Request $request): Model
    {
        $this->update($this->validate($request));

        return $this->fresh()->load('comments', 'comments.replies');
    }

    /**
     * A paginated list for admin users.
     * Includes all articles
     *
     * @param  Request $request
     * @return LengthAwarePaginator
     */
    public function adminList(Request $request): LengthAwarePaginator
    {
        return $this->withCount('comments', 'comments.replies')
            ->where('published_at', '<', Carbon::now())
            ->latest('published_at')
            ->paginate($this->amount($request));
    }

    /**
     * Admin to force delete or toggle delete
     *
     * @param  Request $request
     * @return boolean|Model
     */
    public function remove(Request $request): bool|Model
    {
        if ($request->destroy) {
            return $this->forceDelete();
        }

        return $this->toggleDelete();
    }

    /**
     * Allow Author to toggle soft deletes
     *
     * @return Model
     */
    public function toggleDelete(): Model
    {
        if ($this->trashed()) {
            $this->restore();
        } else {
            $this->delete();
        }

        return $this;
    }

    /**
     * Getter to set up validation
     * rules to store new resource
     *
     * @return array
     */
    protected function getStoreRules(): array
    {
        return [
            'slug' => 'required|string|unique:articles,slug',
            'title' => 'required|string|unique:articles,title',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'allow_comments' => 'nullable|boolean',
        ];
    }

    /**
     * Getter to set up validation
     * rules to renew a resource
     *
     * @return array
     */
    protected function getRenewRules(): array
    {
        return [
            'slug' => 'required|string|unique:articles,slug,id,'.$this->id,
            'title' => 'required|string|unique:articles,title,id,'.$this->id,
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'allow_comments' => 'nullable|boolean',
        ];
    }
}
