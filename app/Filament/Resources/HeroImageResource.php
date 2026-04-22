<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroImageResource\Pages;
use App\Models\HeroImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroImageResource extends Resource
{
    protected static ?string $model = HeroImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Hero Images';

    protected static ?string $navigationGroup = 'Website';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('hero-images')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('alt_text')
                    ->label('Alt Text')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image'),
                Tables\Columns\TextColumn::make('alt_text')
                    ->label('Alt Text')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroImages::route('/'),
            'create' => Pages\CreateHeroImage::route('/create'),
            'edit' => Pages\EditHeroImage::route('/{record}/edit'),
        ];
    }
}
