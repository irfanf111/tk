<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Artikel & Berita';

    protected static ?string $navigationGroup = 'Manajemen Website';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label('Judul')
                ->required()
                ->maxLength(255)
                ->live(debounce: 500)
                ->afterStateUpdated(function (Set $set, ?string $state, string $operation) {
                    // Auto-generate slug hanya saat CREATE, bukan edit
                    if ($operation === 'create' && $state) {
                        $set('slug', Str::slug($state));
                    }
                })
                ->columnSpanFull(),

            Forms\Components\TextInput::make('slug')
                ->label('Slug URL')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->hint('URL berita: /artikel/{slug}')
                ->hintColor('success')
                ->columnSpanFull(),

            Forms\Components\FileUpload::make('image')
                ->label('Gambar')
                ->image()
                ->directory('uploads')
                ->nullable()
                ->columnSpanFull(),

            Forms\Components\DatePicker::make('published_at')
                ->label('Tanggal Terbit')
                ->required(),

            Forms\Components\Textarea::make('excerpt')
                ->label('Ringkasan')
                ->required()
                ->rows(3)
                ->columnSpanFull(),

            Forms\Components\RichEditor::make('content')
                ->label('Konten')
                ->required()
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Gambar'),
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable()->limit(50),
                Tables\Columns\TextColumn::make('published_at')->label('Terbit')->date('d F Y')->sortable(),
                Tables\Columns\TextColumn::make('excerpt')->label('Ringkasan')->limit(50),
            ])
            ->defaultSort('published_at', 'desc')
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
            'index'  => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit'   => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
