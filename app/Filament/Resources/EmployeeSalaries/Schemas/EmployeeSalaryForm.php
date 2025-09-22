<?php

namespace App\Filament\Resources\EmployeeSalaries\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EmployeeSalaryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('employee_id')
                    ->label('Employee')
                    ->relationship('employee', 'first_name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('name')
                    ->label('Salary Component Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., Base Salary, Allowance, Bonus'),

                TextInput::make('salary')
                    ->label('Amount')
                    ->numeric()
                    ->required()
                    ->prefix('$')
                    ->step(0.01)
                    ->minValue(0),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->required(),
                DatePicker::make('effective_date')
                    ->label('Effective Date')
                    ->nullable(),

                DatePicker::make('end_date')
                    ->label('End Date')
                    ->nullable(),

                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
