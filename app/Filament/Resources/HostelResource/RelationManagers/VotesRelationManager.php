<?php

declare(strict_types=1);

namespace App\Filament\Resources\HostelResource\RelationManagers;

use App\Filament\Traits\Localizable;
use App\Models\Vote;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class VotesRelationManager extends RelationManager
{
    use Localizable;

    protected static string $relationship = 'votes';

    protected static ?string $recordTitleAttribute = 'description';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('score')
                    ->options([
                        '0.2' => '1 ✯',
                        '0.4' => '2 ✯',
                        '0.6' => '3 ✯',
                        '0.8' => '4 ✯',
                        '1' => '5 ✯',
                    ])
                    ->required(),
                MarkdownEditor::make('description')
                    ->maxLength(255),
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('owner.name')
                    ->localizeLabel(),
                TextColumn::make('score')
                    ->getStateUsing(fn (Vote $record) => $record->score * 5 .' ✯')
                    ->localizeLabel(),
                TextColumn::make('description')
                    ->localizeLabel(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->localizeLabel(),
            ])
            ->filters([
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data) {
                        $data['owner_id'] = auth()->id();

                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
        ;
    }

    protected function canCreate(): bool
    {
        return auth()->user()->can('create', [Vote::class, $this->getOwnerRecord()]);
    }
}
