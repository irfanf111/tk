<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentGradeResource\Pages;
use App\Filament\Resources\StudentGradeResource\RelationManagers;
use App\Models\StudentGrade;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentGradeResource extends Resource
{
    protected static ?string $model = StudentGrade::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('student_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('academic_year_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('competency_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('grade')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('academic_year_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('competency_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grade')
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
            'index' => Pages\ListStudentGrades::route('/'),
            'create' => Pages\CreateStudentGrade::route('/create'),
            'edit' => Pages\EditStudentGrade::route('/{record}/edit'),
        ];
    }
}
