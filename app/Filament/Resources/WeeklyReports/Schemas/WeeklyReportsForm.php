<?php

namespace App\Filament\Resources\WeeklyReports\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class WeeklyReportsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('journal_number')
                    ->required()
                    ->numeric(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                DatePicker::make('week_start')
                    ->required(),
                DatePicker::make('week_end')
                    ->required(),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'viewed' => 'Viewed', 'certified' => 'Certified'])
                    ->required(),
                DateTimePicker::make('submitted_at'),
                DateTimePicker::make('viewed_at'),
                DateTimePicker::make('certified_at'),
                TextInput::make('certified_by')
                    ->numeric()
                    ->default(null),
                TextInput::make('signature')
                    ->default(null),
                Textarea::make('entries')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
