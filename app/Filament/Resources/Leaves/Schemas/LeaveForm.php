<?php

namespace App\Filament\Resources\Leaves\Schemas;

use App\Models\Employee;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LeaveForm
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

                Select::make('type')
                    ->label('Leave Type')
                    ->options([
                        'annual' => 'Annual Leave',
                        'sick' => 'Sick Leave',
                        'personal' => 'Personal Leave',
                        'maternity' => 'Maternity Leave',
                        'paternity' => 'Paternity Leave',
                        'emergency' => 'Emergency Leave',
                        'unpaid' => 'Unpaid Leave',
                    ])
                    ->required(),

                DateTimePicker::make('start_at')
                    ->label('Start Date & Time')
                    ->required()
                    ->seconds(false),

                DateTimePicker::make('end_at')
                    ->label('End Date & Time')
                    ->required()
                    ->seconds(false),

                TextInput::make('hours')
                    ->label('Hours')
                    ->numeric()
                    ->step(0.5)
                    ->required()
                    ->minValue(0.5),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('draft')
                    ->required(),

                Select::make('approver_id')
                    ->label('Approver')
                    ->relationship('approver', 'first_name')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Textarea::make('reason')
                    ->label('Reason')
                    ->rows(3)
                    ->required()
                    ->columnSpanFull(),

                Textarea::make('rejection_reason')
                    ->label('Rejection Reason')
                    ->rows(2)
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('status') === 'rejected'),
            ]);
    }
}
