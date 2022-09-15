<?php


namespace Modules\Log\Vilt\Resources\LogResource\Traits;

trait Translations
{
    public function loadTranslations(): array
    {
        return [
            "index" => __(" Logs"),
            "create" => __('Create ' . " Logs"),
            "bulk" => __('Delete Selected ' . " Logs"),
            "edit_title" => __('Edit ' . " Logs"),
            "create_title" => __('Create New ' . " Logs"),
            "view_title" => __('View ' . " Logs"),
            "delete_title" => __('Delete ' . " Logs"),
            "bulk_title" => __('Run Bulk Action To ' . " Logs"),
        ];
    }
}

