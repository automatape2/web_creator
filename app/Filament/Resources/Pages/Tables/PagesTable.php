<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Slug copiado')
                    ->copyMessageDuration(1500),
                
                TextColumn::make('template.name')
                    ->label('Plantilla')
                    ->sortable()
                    ->toggleable(),
                
                IconColumn::make('is_published')
                    ->label('Publicada')
                    ->boolean()
                    ->sortable(),
                
                TextColumn::make('components_count')
                    ->label('Componentes')
                    ->counts('components')
                    ->sortable(),
                
                TextColumn::make('created_at')
                    ->label('Creada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('updated_at')
                    ->label('Actualizada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_published')
                    ->label('Estado')
                    ->options([
                        1 => 'Publicadas',
                        0 => 'Borradores',
                    ]),
                
                SelectFilter::make('template_id')
                    ->label('Plantilla')
                    ->relationship('template', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
