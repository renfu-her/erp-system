<?php

namespace App\Filament\Resources\Attendances\Schemas;

use App\Models\Employee;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AttendanceForm
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

                DatePicker::make('date')
                    ->label('Date')
                    ->required()
                    ->default(now()),

                TimePicker::make('checkin')
                    ->label('Check In Time')
                    ->seconds(false),

                TimePicker::make('checkout')
                    ->label('Check Out Time')
                    ->seconds(false),

                TextInput::make('overtime_minutes')
                    ->label('Overtime (minutes)')
                    ->numeric()
                    ->default(0)
                    ->minValue(0),

                Select::make('source')
                    ->label('Source')
                    ->options([
                        'device' => 'Device',
                        'import' => 'Import',
                        'manual' => 'Manual',
                    ])
                    ->default('manual')
                    ->required(),

                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
