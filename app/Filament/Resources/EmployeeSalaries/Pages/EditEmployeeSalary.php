<?php

namespace App\Filament\Resources\EmployeeSalaries\Pages;

use App\Filament\Resources\EmployeeSalaries\EmployeeSalaryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeSalary extends EditRecord
{
    protected static string $resource = EmployeeSalaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
