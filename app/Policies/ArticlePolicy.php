<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    /**
     * Determine whether the user cis an admin and see all articles.
     */
    public function viewAny(User $user): bool
    {
        dd('hit');

        return $user->hasPerm('admin-access-articles');
    }

    /**
     * Any user can view a article, but this is used for getting edit data.
     */
    public function view(User $user, Article $article): bool
    {
        if ($user->hasPerm('admin-update-articles')) {
            return true;
        }

        return $user->hasPerm('update-articles') && $user->isAuthor($article);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasPerm('admin-create-articles')) {
            return true;
        }

        return $user->hasPerm('create-articles');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool
    {
        if ($user->hasPerm('admin-update-articles')) {
            return true;
        }

        return $user->hasPerm('update-articles') && $user->isAuthor($article);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
        if ($user->hasPerm('admin-delete-articles')) {
            return true;
        }

        return $user->hasPerm('delete-articles') && $user->isAuthor($article);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Article $article): bool
    {
        return $user->hasPerm('admin-delete-articles');
    }
}
