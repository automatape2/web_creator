<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use App\Services\AIPageGeneratorService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate_with_ai')
                ->label('Generar con IA')
                ->icon('heroicon-o-sparkles')
                ->color('primary')
                ->modalHeading('Generar Página con IA')
                ->modalDescription('Describe lo que quieres crear y la IA generará la estructura de tu página')
                ->modalSubmitActionLabel('Generar')
                ->form([
                    Textarea::make('description')
                        ->label('Descripción')
                        ->placeholder('Ej: Quiero una landing page para mi agencia de marketing digital con sección hero, características y formulario de contacto')
                        ->required()
                        ->rows(4),
                    
                    Select::make('page_type')
                        ->label('Tipo de Página')
                        ->options([
                            'landing' => 'Landing Page',
                            'portfolio' => 'Portfolio',
                            'blog' => 'Blog',
                            'business' => 'Página de Negocio',
                            'ecommerce' => 'E-commerce',
                        ])
                        ->default('landing')
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $aiService = app(AIPageGeneratorService::class);
                    
                    // Generar componentes con IA
                    $components = $aiService->generateComponents(
                        $data['description'],
                        $data['page_type']
                    );
                    
                    // Prellenar el formulario
                    $this->form->fill([
                        'title' => ucfirst($data['page_type']) . ' - Generada por IA',
                        'description' => $data['description'],
                        'is_published' => false,
                        'components' => $components,
                    ]);
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Página generada con éxito')
                        ->success()
                        ->body('Revisa y ajusta los componentes según tus necesidades.')
                        ->send();
                }),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        
        return $data;
    }
}
