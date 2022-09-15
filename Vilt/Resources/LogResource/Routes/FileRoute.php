<?php


namespace Modules\Log\Vilt\Resources\LogResource\Routes;
use Modules\Log\Vilt\Resources\LogResource;

use Modules\Base\Services\Components\Routes;

class FileRoute extends Routes
{
    public function setup(): void
    {
         $this->name('file');
         $this->type('get');
         $this->method('file');
         $this->controller(LogResource::class);
         $this->path('file/{id}/{file}');
    }
}

