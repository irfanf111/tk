<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaffResource\Pages;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StaffResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Staf Pengajar';

    protected static ?string $navigationGroup = 'Manajemen Website';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('position')
                ->label('Jabatan')
                ->required()
                ->maxLength(255),
            Forms\Components\FileUpload::make('image')
                ->label('Foto')
                ->image()
                ->directory('uploads')
                ->nullable()
                ->columnSpanFull(),
            Forms\Components\Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
            Forms\Components\RichEditor::make('bio')
                ->label('Biodata Singkat')
                ->columnSpanFull()
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Foto')->circular(),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('position')->label('Jabatan')->searchable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Aktif'),
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
            'index'  => Pages\ListStaff::route('/'),
            'create' => Pages\CreateStaff::route('/create'),
            'edit'   => Pages\EditStaff::route('/{record}/edit'),
        ];
    }
}
