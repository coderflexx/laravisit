<?php

namespace Coderflex\Laravisit\Presenters;

use Illuminate\Database\Eloquent\Model;

class VisitPresenter extends Presenter
{
    /**
     * Get the associated IP of from the model instance
     *
     * @return string
     */
    public function ip(): string
    {
        return $this->model->data['ip'];
    }

    /**
     * Get the associated User of from the model instance
     *
     * @return Model
     */
    public function user(): Model
    {
        $userId = $this->model->data['user_id'];

        $user = config('laravisit.user_namespace');

        return (new $user())->find($userId);
    }
}
