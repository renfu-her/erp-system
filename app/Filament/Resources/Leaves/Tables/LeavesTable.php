<?php

namespace App\Filament\Resources\Leaves\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LeavesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.full_name')
                    ->label('Employee')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('type')
                    ->colors([
                        'primary' => 'annual',
                        'success' => 'sick',
                        'warning' => 'personal',
                        'info' => 'maternity',
                        'secondary' => 'paternity',
                        'danger' => 'emergency',
                        'gray' => 'unpaid',
                    ]),

                TextColumn::make('start_at')
                    ->label('Start Date')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('end_at')
                    ->label('End Date')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('hours')
                    ->label('Hours')
                    ->suffix(' hrs')
                    ->sortable(),

                TextColumn::make('duration_in_days')
                    ->label('Days')
                    ->getStateUsing(fn ($record) => $record->duration_in_days . ' days')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'draft',
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'secondary' => 'cancelled',
                    ]),

                TextColumn::make('approver.full_name')
                    ->label('Approved By')
                    ->placeholder('Not assigned'),

                TextColumn::make('approved_at')
                    ->label('Approved At')
                    ->dateTime()
                    ->placeholder('Not approved'),

                TextColumn::make('reason')
                    ->label('Reason')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'annual' => 'Annual Leave',
                        'sick' => 'Sick Leave',
                        'personal' => 'Personal Leave',
                        'maternity' => 'Maternity Leave',
                        'paternity' => 'Paternity Leave',
                        'emergency' => 'Emergency Leave',
                        'unpaid' => 'Unpaid Leave',
                    ]),

                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'cancelled' => 'Cancelled',
                    ]),

                SelectFilter::make('employee_id')
                    ->label('Employee')
                    ->relationship('employee', 'first_name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_at', 'desc');
    }
}
