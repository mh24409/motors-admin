<?php

namespace Modules\Admin\Filament\Resources\AdminResource\Pages;

use Modules\Admin\Filament\Resources\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;
}
