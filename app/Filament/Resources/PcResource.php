<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PCResource\Pages;
use App\Models\Pc;
use Carbon\Carbon;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PcResource extends Resource
{
    protected static ?string $model = Pc::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static ?string $navigationLabel = 'PCs';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Information')
                ->schema([
                    TextEntry::make('name')
                        ->label('Name'),
                    TextEntry::make('url')
                        ->label('Url'),
                ]),
        ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    TextColumn::make('name')
                        ->alignCenter()
                        ->weight(FontWeight::Bold)
                        ->searchable()
                        ->sortable(),

                    TextColumn::make('updated_at')
                        ->alignCenter()
                        ->badge()
                        ->tooltip(fn ($state) => 'Last Seen : '.Carbon::parse($state)->diffForHumans())
                        ->formatStateUsing(fn ($state) => Carbon::parse($state)->diffInHours(now()) > 24 ? 'Offline' : 'Online')
                        ->icon(function ($state) {
                            $hour = Carbon::parse($state)->diffInHours(now());

                            return match (true) {
                                $hour > 24 => 'heroicon-o-x-circle',
                                $hour > 12 => 'heroicon-o-exclamation-circle',
                                default => 'heroicon-o-check-circle',
                            };
                        })
                        ->color(function ($state) {
                            $hour = Carbon::parse($state)->diffInHours(now());

                            return match (true) {
                                $hour > 24 => 'danger',
                                $hour > 12 => 'warning',
                                default => 'success',
                            };
                        }),
                    TextColumn::make('url')
                        ->copyable()
                        ->copyMessage('Copied!')
                        ->copyMessageDuration(1500)
                        ->alignCenter(),

                    TextColumn::make('created_at')
                        ->formatStateUsing(fn ($state) => 'Last Seen : '.Carbon::parse($state)->format('d/m/Y H:i'))
                        ->alignCenter(),

                    TextColumn::make('url')
                        ->badge()
                        ->copyable()
                        ->copyMessage('Copied!')
                        ->copyMessageDuration(1500)
                        ->copyableState(fn ($state) => 'mstsc '.$state)
                        ->size(TextColumn\TextColumnSize::Large)
                        ->visible(fn ($state) => str($state)->contains('tcp'))
                        ->formatStateUsing(fn ($state) => 'Copy MSTSC')
                        ->alignCenter(),

                    TextColumn::make('url')
                        ->badge()
                        ->url(fn ($state) => $state)
                        ->size(TextColumn\TextColumnSize::Large)
                        ->visible(fn ($state) => str($state)->contains('http'))
                        ->formatStateUsing(fn ($state) => 'Open In Browser')
                        ->alignCenter(),
                ])->space(3),
            ])
            ->contentGrid([
                'md' => 2,
                'lg' => 3,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->poll();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPcS::route('/'),
            'create' => Pages\CreatePc::route('/create'),
            'view' => Pages\ViewPc::route('/{record}'),
            'edit' => Pages\EditPc::route('/{record}/edit'),
        ];
    }
}
