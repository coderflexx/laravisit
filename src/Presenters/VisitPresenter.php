<?php

namespace Coderflex\Laravisit\Presenters;

class VisitPresenter extends Presenter
{
    public function getIp()
    {
        return $this->model->data['ip'];
    }
}