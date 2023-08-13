<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TokensRelationManager extends RelationManager
{
    protected static string $relationship = 'tokens';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Device Name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions(actions: [
                Tables\Actions\Action::make('create_token')
                    ->label('Create Token')
                    ->icon('heroicon-o-plus-circle')
                    ->action(function ($data) {
                        $token = auth()->user()->createToken($data['name'])->plainTextToken;

                        Notification::make('Token Created')
                            ->title('The token for '.$data['name'].' are shown below.')
                            ->body($token)
                            ->success()
                            ->persistent()
                            ->send();
                    })
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label('Device Name')
                            ->helperText('This can be any name that helps you identify this device.')
                            ->required()
                            ->maxLength(255),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
