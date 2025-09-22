<?php

namespace App\Filament\Resources\EmployeeSalaries;

use App\Filament\Resources\EmployeeSalaries\Pages\CreateEmployeeSalary;
use App\Filament\Resources\EmployeeSalaries\Pages\EditEmployeeSalary;
use App\Filament\Resources\EmployeeSalaries\Pages\ListEmployeeSalaries;
use App\Filament\Resources\EmployeeSalaries\Pages\ViewEmployeeSalary;
use App\Filament\Resources\EmployeeSalaries\Schemas\EmployeeSalaryForm;
use App\Filament\Resources\EmployeeSalaries\Tables\EmployeeSalariesTable;
use App\Models\EmployeeSalary;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EmployeeSalaryResource extends Resource
{
    protected static ?string $model = EmployeeSalary::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static string|UnitEnum|null $navigationGroup = 'Human Resources';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return EmployeeSalaryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmployeeSalariesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmployeeSalaries::route('/'),
            'create' => CreateEmployeeSalary::route('/create'),
            'view' => ViewEmployeeSalary::route('/{record}'),
            'edit' => EditEmployeeSalary::route('/{record}/edit'),
        ];
    }
}
