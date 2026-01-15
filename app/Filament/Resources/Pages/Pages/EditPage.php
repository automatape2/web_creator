<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('visual_editor')
                ->label('Editor Visual')
                ->icon('heroicon-o-pencil-square')
                ->url(fn () => route('page.edit', $this->record))
                ->color('success'),
            
            Action::make('preview')
                ->label('Vista Previa')
                ->icon('heroicon-o-eye')
                ->url(fn () => route('page.preview', $this->record))
                ->openUrlInNewTab(),
            
            Action::make('view_public')
                ->label('Ver Página Pública')
                ->icon('heroicon-o-globe-alt')
                ->url(fn () => route('page.show', $this->record->slug))
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->is_published),
            
            DeleteAction::make(),
        ];
    }
}
