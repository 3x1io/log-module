<?php

namespace Modules\Log\Vilt\Resources\LogResource\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Base\Services\Components\Base\Alert;
use Modules\Base\Services\Components\Base\Render;
use Jackiedo\LogReader\Facades\LogReader;
use Modules\Base\Services\Rows\Date;
use Modules\Base\Services\Rows\Text;

trait Methods
{
    public function view(Request $request, $id): \Inertia\Response
    {
        $record = $this->model::find($id);
        $this->canDelete = false;
        $this->canDeleteAny = false;
        $this->canEdit = false;

        $rows = [
            Date::make('date')->sortable(false),
            Text::make('environment')->sortable(false),
            Text::make('level')->badge()->color('primary')->sortable(false),
            Text::make('context.message')->label(__('context'))->max(5)->sortable(false),
        ];

        $log = LogReader::filename($record->name);
        $logs = $log->paginate($request->get('per_page') ?: 10, $request->get('page') ?: 1); // we need to paginate...

        return Render::make(ucfirst(Str::camel($this->table)).'/View')->module($this->module)->data([
            "collection" => $logs,
            "record" => $record,
            "rows" => $rows,
            "roles" => [
                "view" => $this->canView,
                "viewAny" => $this->canViewAny,
                "edit" => $this->canEdit,
                "create" => $this->canCreate,
                "delete" => $this->canDelete,
                "deleteAny" => $this->canDeleteAny,
            ],
            "list" => [
                "url" => $this->table,
                "model" => $this->model,
                "search" => $this->search,
                "per_page" => $this->per_page,
                "orderBy" => $this->orderBy,
                "desc" => $this->orderDirection,
                "filters" => $this->filters,
            ],
            "render" => [
                "create" => $this->create,
                "components" => $this->components(),
                "lang" => $this->loadTranslations(),
                "form" => $this->form(),
                "table" => $this->table()
            ]
        ])->render();
    }

    public function file(Request $request,$id, $file){
        $record = LogReader::find($id);
        $getFile = $this->model::find($file);

        return Render::make('Logs/File')->module($this->module)->data([
            "record" => $record,
            "file" => $getFile,
            "rows" => $this->rows(),
            "url" => $this->table
        ])->render();
    }

    public function destory(Request $request, $id)
    {
        $record = $this->model::find($id);
        $log = LogReader::filename($record->name);
        $deleted = $log->delete();
        LogReader::removeLogFile();
        $this->model::boot();

        Alert::make(__('Deleted Successfully'))->fire();
    }
}
