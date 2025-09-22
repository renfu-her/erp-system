<?php

namespace App\Filament\Resources\Positions\Schemas;

use App\Models\Department;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Position Title'),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->columnSpanFull(),

                Select::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('salary_range_min')
                    ->label('Minimum Salary')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01),

                TextInput::make('salary_range_max')
                    ->label('Maximum Salary')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
