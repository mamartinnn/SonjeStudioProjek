<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput;
use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    // Menentukan model yang digunakan untuk resource ini
    protected static ?string $model = Category::class;

    // Menentukan ikon di sidebar panel admin
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Konfigurasi form (create/edit)
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')   // Field input teks untuk nama kategori
                ->required()          // Wajib diisi
                ->maxLength(255),    // Maksimal 255 karakter
        ]);
    }

    // Konfigurasi tampilan tabel data kategori
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'), // Kolom nama
            ])
            ->filters([
                // (Opsional) Filter bisa ditambahkan di sini
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Tombol edit untuk setiap baris
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Aksi hapus massal
                ]),
            ]);
    }

    // Menentukan relasi yang bisa dimanage lewat Filament (belum ada)
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    // Halaman bawaan dari resource ini (List, Create, Edit)
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
