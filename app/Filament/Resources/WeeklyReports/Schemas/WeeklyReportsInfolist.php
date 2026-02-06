<?php

namespace App\Filament\Resources\WeeklyReports\Schemas;

use Illuminate\Support\HtmlString;
use App\Models\WeeklyReports;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;




class WeeklyReportsInfolist
{


    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                ->columnSpanFull()
                ->schema([
                TextEntry::make('user.name')
                    ->label('User'),              
                TextEntry::make('week_start')
                    ->date(),
                TextEntry::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state)=>ucfirst("{$state}"))
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'pending' => 'warning',
                        'viewed' => 'info',
                        'certified' => 'success'
                    }),               
                TextEntry::make('week_end')
                    ->date(),
                TextEntry::make('submitted_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('viewed_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('certified_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('certified_by')
                    ->label('Certified by')
                    ->getStateUsing(fn ($record) => $record->certifiedBy?->name)
                    ->placeholder('-'),
                TextEntry::make('signature')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ])->columns(2),
                //entries        
                Section::make('Week Focus')
                ->description('What was your main focus this week? What skill or concept were you trying to improve?')
                ->schema([      
                    TextEntry::make('entries.week_focus')  
                    ->disableLabel()
                        ->getStateUsing(fn ($record) =>
                            data_get($record->entries_decoded, 'week_focus', '—')
                        )
                    ])->columnSpanFull(),
                    Section::make('Topics Learned')
                    ->description('List the topics, tools, or concepts you worked on this week.')
                    ->schema([  
                        TextEntry::make('topics_learned')
                            ->disableLabel()
                            ->getStateUsing(fn ($record) =>
                                collect(data_get($record->entries, 'topics_learned', []))
                                    ->pluck('topic') // keep as array
                                    ->all()           // convert collection to plain array
                                    ?: ['—']          // fallback as array
                            )
                            ->bulleted() // <-- this tells TextEntry to show each item as a separate bullet
                    ])
                    ->columnSpanFull(),              
                Section::make('Outputs Links')
                ->description('Provide direct links to your work. Each link must have a short description.')
                ->schema([  
                TextEntry::make('outputs_links')
                        ->disableLabel()
                        ->getStateUsing(fn ($record) =>
                            collect(data_get($record->entries, 'outputs_links', []))
                                ->map(fn ($item) => $item['url'])
                                ->join("\n")
                                ?: '—'
                    )
                ]),          
                Section::make('Decisions / Reasoning')
                ->description('Explain at least two decisions you made this week.')
                ->schema([   
                        TextEntry::make('decisions_reasoning')
                        ->disableLabel()
                        ->getStateUsing(fn ($record) =>
                            collect(data_get($record->entries, 'decisions_reasoning', []))
                                ->map(fn ($value, $key) => ucfirst(str_replace('_', ' ', $key)) . ': ' . $value)
                                ->values()      // make sure it’s a plain array
                                ->all()         // convert collection to array
                        )
                        ->bulleted(), 
                ]),          
                Section::make('What I Built')
                ->description('Describe what you created and what problem it was meant to solve.')
                ->schema([        
                    TextEntry::make('what_built')
                    ->disableLabel()
                        ->getStateUsing(fn ($record) =>
                            new HtmlString(data_get($record->entries, 'what_built', '—'))
                        ),
                    ])->columnSpanFull(),
                
                Section::make('Challenges / Blockers')
                ->description('What was difficult or confusing? What slowed you down? ')
                ->schema([                   
                    TextEntry::make('challenges_blockers')
                    ->disableLabel()
                    ->getStateUsing(fn ($record) =>
                        data_get($record->entries_decoded, 'challenges_blockers', '—')
                    ),
                ])->columnSpanFull(),
                Section::make('Improvements Next Time')
                ->description('If you had more time, what would you improve or change? ')
                ->schema([   
                TextEntry::make('improve_next_time')
                ->disableLabel()
                    ->getStateUsing(fn ($record) =>
                        data_get($record->entries_decoded, 'improve_next_time', '—')
                    )->bulleted(),
                ])->columnSpanFull(),
                Section::make('Key Takeaway')
                ->description('What is the most important thing you learned this week? How will it change how you work next week? ')
                ->schema([   
                    TextEntry::make('key_takeaway')
                    ->disableLabel()
                    ->getStateUsing(fn ($record) =>
                        data_get($record->entries_decoded, 'key_takeaway', '—')
                    ),
                ])->columnSpanFull(),
                 Section::make()
                ->columnSpanFull()
                ->schema([
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (WeeklyReports $record): bool => $record->trashed()),
                    ])
                    ->columns(2)
                ]);
              
    }
}
