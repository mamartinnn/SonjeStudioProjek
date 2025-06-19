<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\TextInput::make('name')
            ->label('Name')
            ->required()
            ->maxLength(255),

        Forms\Components\TextInput::make('email')
            ->label('Email')
            ->email()
            ->required()
            ->unique(ignoreRecord: true)
            ->maxLength(255),

        Forms\Components\TextInput::make('password')
            ->label('Password')
            ->password()
            ->dehydrateStateUsing(fn ($state) => !empty($state) ? bcrypt($state) : null)
            ->required(fn (string $context): bool => $context === 'create')
            ->dehydrated(fn ($state) => filled($state))
            ->maxLength(255),

        Forms\Components\Toggle::make('is_admin')
            ->label('Is Admin')
            ->helperText('Centang jika user ini adalah admin.')
            ->default(false),
    ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),

                 Tables\Columns\IconColumn::make('is_admin')
                ->label('Admin')
                ->boolean(),
            ])

                

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
