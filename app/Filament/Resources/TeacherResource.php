<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationGroup = 'Sistem Akademik';
    protected static ?string $navigationIcon  = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'Guru';
    protected static ?int    $navigationSort  = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ── Bagian Atas: Foto Profil ──────────────────────────────────
                Forms\Components\Section::make('Foto Profil')
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label('Foto Guru')
                            ->image()                              // hanya terima file gambar
                            ->disk('public')                      // simpan di storage/app/public
                            ->directory('teachers-photos')        // subfolder
                            ->imageEditor()                       // aktifkan editor crop bawaan
                            ->circleCropper()                     // crop melingkar (avatar)
                            ->maxSize(2048)                       // maks 2 MB (dalam kilobytes)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Format: JPG, PNG, WebP. Maks 2 MB.')
                            ->columnSpanFull(),
                    ]),

                // ── Bagian Data Utama ─────────────────────────────────────────
                Forms\Components\Section::make('Data Guru')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('jabatan')
                            ->label('Jabatan / Mata Pelajaran')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('bio')
                            ->label('Biografi Singkat')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Foto profil sebagai avatar bulat di tabel
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=Guru&background=10b981&color=fff')
                    ->width(48)
                    ->height(48),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index'  => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit'   => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
