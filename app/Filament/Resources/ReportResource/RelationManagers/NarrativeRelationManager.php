<?php

namespace App\Filament\Resources\ReportResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class NarrativeRelationManager extends RelationManager
{
    protected static string $relationship = 'narrative';

    protected static ?string $title = 'Narasi Capaian Pembelajaran';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Capaian Perkembangan Pembelajaran')
                    ->description('Isi narasi deskriptif untuk setiap elemen capaian perkembangan anak.')
                    ->schema([
                        Forms\Components\Textarea::make('elemen_agama_budi_pekerti')
                            ->label('Nilai Agama dan Budi Pekerti')
                            ->placeholder('Deskripsikan capaian perkembangan nilai agama dan budi pekerti anak...')
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('elemen_jati_diri')
                            ->label('Jati Diri')
                            ->placeholder('Deskripsikan capaian perkembangan jati diri anak...')
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('elemen_literasi_steam')
                            ->label('Dasar-Dasar Literasi, Matematika, Sains, Teknologi, Rekayasa, dan Seni')
                            ->placeholder('Deskripsikan capaian perkembangan literasi dan STEAM anak...')
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('projek_p5')
                            ->label('Projek Penguatan Profil Pelajar Pancasila (P5)')
                            ->placeholder('Deskripsikan capaian projek P5 anak...')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('elemen_agama_budi_pekerti')
                    ->label('Nilai Agama & Budi Pekerti')
                    ->limit(80)
                    ->wrap(),

                Tables\Columns\TextColumn::make('elemen_jati_diri')
                    ->label('Jati Diri')
                    ->limit(80)
                    ->wrap(),

                Tables\Columns\TextColumn::make('elemen_literasi_steam')
                    ->label('Literasi & STEAM')
                    ->limit(80)
                    ->wrap(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Narasi'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
