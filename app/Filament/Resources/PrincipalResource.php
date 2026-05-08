<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrincipalResource\Pages;
use App\Models\Principal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PrincipalResource extends Resource
{
    protected static ?string $model = Principal::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'Kepala Sekolah';

    protected static ?string $navigationGroup = 'Manajemen Website';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Kepala Sekolah')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            Forms\Components\FileUpload::make('image')
                ->label('Foto')
                ->image()
                ->directory('uploads')
                ->nullable()
                ->columnSpanFull(),
            Forms\Components\Textarea::make('message')
                ->label('Sambutan')
                ->required()
                ->rows(6)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Foto'),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('message')->label('Sambutan')->limit(60),
                Tables\Columns\TextColumn::make('updated_at')->label('Diperbarui')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index'  => Pages\ListPrincipals::route('/'),
            'create' => Pages\CreatePrincipal::route('/create'),
            'edit'   => Pages\EditPrincipal::route('/{record}/edit'),
        ];
    }
}
