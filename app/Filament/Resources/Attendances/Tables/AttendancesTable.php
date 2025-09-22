<?php

namespace App\Filament\Resources\Attendances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AttendancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.full_name')
                    ->label('Employee')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('checkin')
                    ->label('Check In')
                    ->time()
                    ->placeholder('Not checked in'),

                TextColumn::make('checkout')
                    ->label('Check Out')
                    ->time()
                    ->placeholder('Not checked out'),

                TextColumn::make('total_hours')
                    ->label('Total Hours')
                    ->getStateUsing(fn ($record) => $record->total_hours . ' hrs')
                    ->sortable(),

                TextColumn::make('overtime_hours')
                    ->label('Overtime')
                    ->getStateUsing(fn ($record) => $record->overtime_hours . ' hrs')
                    ->sortable(),

                BadgeColumn::make('source')
                    ->colors([
                        'primary' => 'device',
                        'success' => 'import',
                        'warning' => 'manual',
                    ]),

                TextColumn::make('is_late')
                    ->label('Late')
                    ->getStateUsing(fn ($record) => $record->is_late ? 'Yes' : 'No')
                    ->color(fn ($record) => $record->is_late ? 'danger' : 'success'),

                TextColumn::make('is_complete')
                    ->label('Complete')
                    ->getStateUsing(fn ($record) => $record->is_complete ? 'Yes' : 'No')
                    ->color(fn ($record) => $record->is_complete ? 'success' : 'warning'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('source')
                    ->options([
                        'device' => 'Device',
                        'import' => 'Import',
                        'manual' => 'Manual',
                    ]),

                Filter::make('date_range')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        \Filament\Forms\Components\DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    }),

                Filter::make('incomplete')
                    ->label('Incomplete Records')
                    ->query(fn (Builder $query): Builder => $query->whereNull('checkin')->orWhereNull('checkout')),

                Filter::make('late_arrivals')
                    ->label('Late Arrivals')
                    ->query(fn (Builder $query): Builder => $query->whereTime('checkin', '>', '09:00:00')),
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
            ->defaultSort('date', 'desc');
    }
}
