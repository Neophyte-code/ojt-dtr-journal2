<?php

namespace App\Filament\Resources\WeeklyReports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;

class WeeklyReportsTable
{
    public static function configure(Table $table): Table
    {
            return $table
            ->groups([
               'status',
               'week_start',
            ])
            ->defaultPaginationPageOption(10)
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('week_start')
                    ->date()
                    ->sortable(),
                TextColumn::make('week_end')
                    ->date()
                    ->sortable(),
                BadgeColumn::make('status')

                    ->colors([
                        'warning' => 'pending',   
                        'info'    => 'viewed',     
                        'success' => 'certified',  
                    ])
                    ->icon(fn ($record) => match ($record->status) {
                        'pending'  => 'heroicon-o-clock',  
                        'viewed' => 'heroicon-m-eye',    
                        'certified' => 'heroicon-m-check', 
                        default => 'heroicon-o-question-mark',
                    })
                    ->searchable()
                    ->sortable()
                    ->label('Status'),
                TextColumn::make('submitted_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('viewed_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('certified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('certified_by')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('signature')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'certified' => 'Certified',
                        'viewed'    => 'Viewed',
                        'pending'   => 'Pending',
                    ]),

                Filter::make('week_range')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        $query
                            ->when($data['from'] ?? null, fn($query, $date) =>
                                $query->whereDate('week_start', '>=', $date)
                            )
                            ->when($data['until'] ?? null, fn($query, $date) =>
                                $query->whereDate('week_end', '<=', $date)
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                ->color('info'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
