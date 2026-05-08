<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolIdentityResource\Pages;
use App\Models\SchoolIdentity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SchoolIdentityResource extends Resource
{
    protected static ?string $model = SchoolIdentity::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'Identitas Sekolah';

    protected static ?string $navigationGroup = 'Manajemen Website';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Identitas Umum')
                ->schema([
                    Forms\Components\TextInput::make('school_name')
                        ->label('Nama Sekolah')->required(),
                    Forms\Components\TextInput::make('npsn')
                        ->label('NPSN'),
                    Forms\Components\TextInput::make('status')
                        ->label('Status')->default('Swasta'),
                    Forms\Components\TextInput::make('education_form')
                        ->label('Bentuk Pendidikan')->default('TK'),
                    Forms\Components\TextInput::make('ownership_status')
                        ->label('Status Kepemilikan')->default('Yayasan'),
                    Forms\Components\TextInput::make('establishment_decree')
                        ->label('SK Pendirian Sekolah'),
                    Forms\Components\DatePicker::make('establishment_date')
                        ->label('Tanggal SK Pendirian'),
                    Forms\Components\TextInput::make('operational_decree')
                        ->label('SK Izin Operasional'),
                    Forms\Components\DatePicker::make('operational_date')
                        ->label('Tanggal SK Izin Operasional'),
                ])->columns(2),

            Forms\Components\Section::make('Alamat Sekolah')
                ->schema([
                    Forms\Components\TextInput::make('address')
                        ->label('Alamat')->columnSpanFull(),
                    Forms\Components\TextInput::make('hamlet')
                        ->label('Dusun'),
                    Forms\Components\TextInput::make('village')
                        ->label('Desa/Kelurahan'),
                    Forms\Components\TextInput::make('district')
                        ->label('Kecamatan'),
                    Forms\Components\TextInput::make('regency')
                        ->label('Kabupaten/Kota'),
                    Forms\Components\TextInput::make('province')
                        ->label('Provinsi'),
                    Forms\Components\TextInput::make('postal_code')
                        ->label('Kode Pos'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school_name')->label('Nama Sekolah')->searchable(),
                Tables\Columns\TextColumn::make('npsn')->label('NPSN'),
                Tables\Columns\TextColumn::make('status')->label('Status'),
                Tables\Columns\TextColumn::make('regency')->label('Kabupaten'),
                Tables\Columns\TextColumn::make('updated_at')->label('Diperbarui')->dateTime('d M Y')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSchoolIdentities::route('/'),
            'create' => Pages\CreateSchoolIdentity::route('/create'),
            'edit'   => Pages\EditSchoolIdentity::route('/{record}/edit'),
        ];
    }
}
