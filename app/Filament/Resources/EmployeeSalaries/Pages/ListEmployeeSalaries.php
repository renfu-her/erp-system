<?php

namespace App\Filament\Resources\EmployeeSalaries\Pages;

use App\Filament\Resources\EmployeeSalaries\EmployeeSalaryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeSalaries extends ListRecords
{
    protected static string $resource = EmployeeSalaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
