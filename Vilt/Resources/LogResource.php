<?php


namespace Modules\Log\Vilt\Resources;


use Illuminate\Http\Request;
use Modules\Log\Entities\LogFile;
use Modules\Log\Vilt\Resources\LogResource\Traits\Methods;
use Modules\Base\Services\Resource\Resource;
use Modules\Log\Vilt\Resources\LogResource\Traits\Translations;
use Modules\Log\Vilt\Resources\LogResource\Traits\Components;

use Modules\Base\Services\Rows\Text;


class LogResource extends Resource
{
    use Translations,Components, Methods;

    public ?string $model = LogFile::class;
    public ?string $icon = "bx bx-bug-alt";
    public ?string $group = "Settings";
    public ?string $module = "Log";
    public ?bool $api = true;

    public function rows():array
    {
        $this->canCreate = false;
        $this->canEdit = false;
        $this->canDeleteAny = false;

        return [
            Text::make('id')
                ->sortable(false)
                ->label(__('SN')),
            Text::make('name')
                ->color('primary')
                ->badge()
                ->label(__('Name')),
        ];
    }
}
