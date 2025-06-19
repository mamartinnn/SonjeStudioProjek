<?php

namespace App\Filament\Resources;

// Komponen tambahan dari plugin untuk input uang
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Infolists\Components\MoneyEntry;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

// Resource untuk model Produk di panel admin Filament
class ProductResource extends Resource
{
    // Model yang digunakan
    protected static ?string $model = Product::class;

    // Ikon menu di sidebar admin
    protected static ?string $navigationIcon = 'heroicon-o-cube';

    // Formulir tambah/edit produk
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Input nama produk (wajib)
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),

                // Slug produk (unik, wajib)
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                // Deskripsi produk
                Textarea::make('description')
                    ->label('Description')
                    ->rows(3),

                // Harga produk dalam Rupiah
                TextInput::make('price')
                    ->label('Price (Rupiah)')
                    ->numeric()
                    ->required(),

                // Stok produk
                TextInput::make('stock_quantity')
                    ->label('Stock Quantity')
                    ->numeric()
                    ->default(0),

                // Status visibilitas produk
                Toggle::make('is_visible')
                    ->label('Visible')
                    ->default(true),

                // Upload gambar produk
                FileUpload::make('image_url')
                    ->label('Image')
                    ->image()
                    ->directory('products') // folder penyimpanan
                    ->imagePreviewHeight('250')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->required(false)
                    ->visibility('public'),

                // Relasi ke kategori (banyak)
                Select::make('categories')
                    ->label('Categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload()
                    ->required(),

                // URL ke toko Shopee
                TextInput::make('shopee_url')
                    ->label('Shopee URL')
                    ->url()
                    ->nullable(),

                // URL ke TikTok Shop
                TextInput::make('tiktok_url')
                    ->label('TikTok Shop URL')
                    ->url()
                    ->nullable(),
            ]);
    }

    // Tabel daftar produk
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom ID produk
                TextColumn::make('id')->sortable(),

                // Kolom nama produk, bisa dicari
                TextColumn::make('name')->searchable(),

                // Kolom harga, diformat ke Rupiah
                TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                // Kolom stok
                TextColumn::make('stock_quantity'),

                // Kolom visibilitas produk
                IconColumn::make('is_visible')->boolean()->label('Visible'),

                // Kolom kategori, ditampilkan sebagai badge
                TextColumn::make('categories.name')
                    ->label('Categories')
                    ->badge()
                    ->separator(', '),

                // Tanggal produk dibuat
                TextColumn::make('created_at')->label('Created')->date()->sortable(),
            ])
            ->filters([
                // Filter untuk menampilkan produk yang sudah dihapus (soft delete)
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                // Aksi edit pada setiap baris
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Aksi hapus massal
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    // Jika ada relasi tambahan (misalnya review produk), bisa didefinisikan di sini
    public static function getRelations(): array
    {
        return [
            // Contoh: RelationManagers\ReviewsRelationManager::class
        ];
    }

    // Rute halaman yang tersedia (list, create, edit)
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
