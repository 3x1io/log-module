<?php


namespace Modules\Log\Vilt\Resources\LogResource\Traits;


use Modules\Base\Services\Components\Base\Action;
use Modules\Base\Services\Components\Base\Component;
use Modules\Base\Services\Components\Base\Form;
use Modules\Base\Services\Components\Base\Table;
use Modules\Log\Vilt\Resources\LogResource\Routes\FileRoute;


trait Components
{
    public function components():array
    {
        $components = parent::components();
        return array_merge($components, [
            Component::make(FileRoute::class)->route()
        ]);
    }

    public function form(): Form
    {
        return Form::make('page');
    }
}
