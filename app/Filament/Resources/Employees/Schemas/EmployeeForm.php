<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('employee_id')
                    ->required()
                    ->maxLength(255)
                    ->label('Employee ID')
                    ->unique(ignoreRecord: true),

                TextInput::make('first_name')
                    ->required()
                    ->maxLength(255)
                    ->label('First Name'),

                TextInput::make('last_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Last Name'),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->label('Email Address'),

                TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                    ->label('Phone Number'),

                Textarea::make('address')
                    ->label('Address')
                    ->rows(3)
                    ->columnSpanFull(),

                DatePicker::make('date_of_birth')
                    ->label('Date of Birth')
                    ->maxDate(now()),

                DatePicker::make('hire_date')
                    ->required()
                    ->label('Hire Date')
                    ->default(now()),

                Select::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive(),

                Select::make('position_id')
                    ->label('Position')
                    ->relationship('position', 'title')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->options(function (callable $get) {
                        $departmentId = $get('department_id');
                        if (!$departmentId) {
                            return Position::all()->pluck('title', 'id');
                        }
                        return Position::where('department_id', $departmentId)->pluck('title', 'id');
                    }),

                TextInput::make('salary')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01)
                    ->label('Salary'),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'terminated' => 'Terminated',
                        'on_leave' => 'On Leave',
                    ])
                    ->default('active')
                    ->required(),

                TextInput::make('emergency_contact_name')
                    ->maxLength(255)
                    ->label('Emergency Contact Name'),

                TextInput::make('emergency_contact_phone')
                    ->tel()
                    ->maxLength(255)
                    ->label('Emergency Contact Phone'),

                Select::make('user_id')
                    ->label('User Account')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
            ]);
    }
}
