<?php

namespace Coderflex\Laravisit\Presenters;

use Coderflex\LaravelPresenter\Presenter;
use Illuminate\Database\Eloquent\Model;

class VisitPresenter extends Presenter
{
    /**
     * Get the associated IP from the model instance
     *
     * @return string
     */
    public function ip(): string
    {
        return $this->model->data['ip']; // @phpstan-ignore-line
    }

    /**
     * Get the associated User from the model instance
     *
     * @return Model
     */
    public function user(): Model
    {
        $userId = $this->model->data['user_id']; // @phpstan-ignore-line
        $userNamespace = config('laravisit.user_namespace');

        $user = is_null($userNamespace) || empty($userNamespace)
                ? '\Coderflex\Laravisit\Models\User'
                : $userNamespace;

        return (new $user())->find($userId);
    }
}
