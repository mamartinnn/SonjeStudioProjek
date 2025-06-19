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
    // Menentukan model yang digunakan oleh resource ini
    protected static ?string $model = User::class;

    // Ikon yang ditampilkan pada menu navigasi admin
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Formulir untuk create/edit data user
    public static function form(Form $form): Form
    {
        return $form->schema([
            // Input untuk nama user
            Forms\Components\TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255),

            // Input email, wajib unik dan valid
            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            // Input password (hanya disimpan jika diisi)
            Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => !empty($state) ? bcrypt($state) : null)
                ->required(fn (string $context): bool => $context === 'create') // wajib hanya saat create
                ->dehydrated(fn ($state) => filled($state)) // hanya dikirim ke server jika diisi
                ->maxLength(255),

            // Toggle status apakah user adalah admin
            Forms\Components\Toggle::make('is_admin')
                ->label('Is Admin')
                ->helperText('Centang jika user ini adalah admin.')
                ->default(false),
        ]);
    }

    // Tabel daftar user di halaman index
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom nama user
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                // Kolom email user
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),

                // Kolom status admin (true/false)
                Tables\Columns\IconColumn::make('is_admin')
                    ->label('Admin')
                    ->boolean(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                // Aksi edit untuk masing-masing user
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Aksi hapus massal
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // Tidak ada relasi tambahan pada resource ini
    public static function getRelations(): array
    {
        return [];
    }

    // Halaman-halaman yang tersedia untuk resource ini
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),         // halaman daftar user
            'create' => Pages\CreateUser::route('/create'), // halaman tambah user
            'edit' => Pages\EditUser::route('/{record}/edit'), // halaman edit user
        ];
    }
}
