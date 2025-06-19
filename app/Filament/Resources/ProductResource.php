<?php

namespace App\Filament\Resources;
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
class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(3),

                    TextInput::make('price')
                    ->label('Price (Rupiah)')
                    ->numeric()
                    ->required(),

                    
                    

                
 

                // TextInput::make('price')
                //     ->label('Price')->currency('idr')
                //     ->numeric()
                //     ->required(),

                TextInput::make('stock_quantity')
                    ->label('Stock Quantity')
                     
                    ->numeric()
                    ->default(0),

                Toggle::make('is_visible')
                    ->label('Visible')
                    ->default(true),

               FileUpload::make('image_url')
                    ->label('Image')
                    ->image()
                    ->directory('products') 
                    ->imagePreviewHeight('250')
                    ->preserveFilenames() 
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']) 
                    ->required(false)
                    ->visibility('public'), 



                Select::make('categories')
                ->label('Categories')
                ->relationship('categories', 'name') 
                ->multiple()
                ->preload()
                ->required(),
                TextInput::make('shopee_url')
                ->label('Shopee URL')
                ->url()
                ->nullable(),

            TextInput::make('tiktok_url')
                ->label('TikTok Shop URL')
                ->url()
                ->nullable(),

                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->searchable(),
              TextColumn::make('price')
                ->label('Price')
                ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                ->sortable(),


                TextColumn::make('stock_quantity'),
                IconColumn::make('is_visible')->boolean()->label('Visible'),
                TextColumn::make('categories.name')
                ->label('Categories')
                ->badge() // tampilkan sebagai badge
                ->separator(', '),
                TextColumn::make('created_at')->label('Created')->date()->sortable(),
            ])

                
            ->filters([
                Tables\Filters\TrashedFilter::make(), // if you want to show soft-deleted
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // e.g. RelationManagers\ReviewsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
