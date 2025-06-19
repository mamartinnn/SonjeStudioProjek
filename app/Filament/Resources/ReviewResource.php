<?php

namespace App\Filament\Resources;

// Komponen Filament untuk placeholder (menampilkan informasi non-editable)
use Filament\Forms\Components\Placeholder;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

// Resource untuk manajemen data review di admin panel Filament
class ReviewResource extends Resource
{
    // Model yang digunakan dalam resource ini
    protected static ?string $model = Review::class;

    // Ikon untuk menu navigasi di sidebar admin
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    // Formulir tambah/edit review
    public static function form(Form $form): Form
    {
        return $form->schema([
            // Menampilkan nama user yang memberikan review (readonly)
            Placeholder::make('user_name')
                ->label('User')
                ->content(fn ($record) => $record->user->name ?? '-'),

            // Menampilkan nama produk yang di-review (readonly)
            Placeholder::make('product_name')
                ->label('Product')
                ->content(fn ($record) => $record->product->name ?? '-'),

            // Kolom komentar review (editable)
            Textarea::make('comment')
                ->label('Comment')
                ->required(),

            // Input rating (1–5)
            TextInput::make('rating')
                ->numeric()
                ->minValue(1)
                ->maxValue(5)
                ->required(),

            // Status apakah review terlihat publik atau tidak
            Toggle::make('is_visible')
                ->label('Visible to Public')
                ->default(true),
        ]);
    }

    // Tabel daftar review
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Nama user yang memberi review
                TextColumn::make('user.name')->label('User'),

                // Nama produk yang di-review
                TextColumn::make('product.name')->label('Product'),

                // Komentar, dibatasi 50 karakter agar tabel rapi
                TextColumn::make('comment')->limit(50),

                // Rating dari review
                TextColumn::make('rating'),

                // Status visibilitas review
                IconColumn::make('is_visible')->boolean()->label('Visible'),

                // Waktu review dibuat
                TextColumn::make('created_at')->dateTime()->label('Created'),
            ])
            ->filters([
                // Tambahkan filter di sini jika diperlukan, contoh: filter berdasarkan rating
            ])
            ->actions([
                // Aksi edit untuk setiap review
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Aksi hapus massal
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // Tidak ada relasi tambahan yang digunakan dalam resource ini
    public static function getRelations(): array
    {
        return [];
    }

    // Menentukan halaman-halaman yang tersedia untuk resource ini
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
