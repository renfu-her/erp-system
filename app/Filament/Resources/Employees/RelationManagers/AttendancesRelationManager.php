<?php

namespace App\Filament\Resources\Employees\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';

    protected static ?string $title = 'Attendance Records';

    protected static ?string $modelLabel = 'Attendance';

    protected static ?string $pluralModelLabel = 'Attendance Records';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->default(now()),
                Forms\Components\TimePicker::make('checkin')
                    ->label('Check In Time'),
                Forms\Components\TimePicker::make('checkout')
                    ->label('Check Out Time'),
                Forms\Components\TextInput::make('overtime_minutes')
                    ->label('Overtime (minutes)')
                    ->numeric()
                    ->default(0),
                Forms\Components\Select::make('source')
                    ->options([
                        'device' => 'Device',
                        'import' => 'Import',
                        'manual' => 'Manual',
                    ])
                    ->default('manual')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('checkin')
                    ->time()
                    ->label('Check In'),
                Tables\Columns\TextColumn::make('checkout')
                    ->time()
                    ->label('Check Out'),
                Tables\Columns\TextColumn::make('total_hours')
                    ->label('Total Hours')
                    ->getStateUsing(fn ($record) => $record->total_hours . ' hrs')
                    ->sortable(),
                Tables\Columns\TextColumn::make('overtime_hours')
                    ->label('Overtime')
                    ->getStateUsing(fn ($record) => $record->overtime_hours . ' hrs')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('source')
                    ->colors([
                        'primary' => 'device',
                        'success' => 'import',
                        'warning' => 'manual',
                    ]),
                Tables\Columns\TextColumn::make('is_late')
                    ->label('Late')
                    ->getStateUsing(fn ($record) => $record->is_late ? 'Yes' : 'No')
                    ->color(fn ($record) => $record->is_late ? 'danger' : 'success'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('source')
                    ->options([
                        'device' => 'Device',
                        'import' => 'Import',
                        'manual' => 'Manual',
                    ]),
                Tables\Filters\Filter::make('date_range')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('until')
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
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
    }
}
