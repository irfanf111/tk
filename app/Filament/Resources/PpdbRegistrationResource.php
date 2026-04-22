<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpdbRegistrationResource\Pages;
use App\Filament\Resources\PpdbRegistrationResource\RelationManagers;
use App\Models\PpdbRegistration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PpdbRegistrationResource extends Resource
{
    protected static ?string $model = PpdbRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('no_pendaftaran')
                    ->required(),
                Forms\Components\TextInput::make('nama_lengkap')
                    ->required(),
                Forms\Components\TextInput::make('nama_panggilan'),
                Forms\Components\TextInput::make('jenis_kelamin')
                    ->required(),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->required(),
                Forms\Components\TextInput::make('nik')
                    ->required(),
                Forms\Components\Textarea::make('alamat_jalan')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_pendaftaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_panggilan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->label('Verify')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (PpdbRegistration $record) {
                        $record->update(['status' => 'verified']);
                    })
                    ->requiresConfirmation()
                    ->visible(fn (PpdbRegistration $record) => $record->status !== 'verified'),
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
            RelationManagers\StudentParentRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPpdbRegistrations::route('/'),
            'create' => Pages\CreatePpdbRegistration::route('/create'),
            'edit' => Pages\EditPpdbRegistration::route('/{record}/edit'),
        ];
    }
}
