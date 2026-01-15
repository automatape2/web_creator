<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Models\Template;
use Filament\Schemas\Components\KeyValue;
use Filament\Schemas\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Toggle;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información Básica')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => 
                                $set('slug', \Illuminate\Support\Str::slug($state))
                            ),
                        
                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL amigable para la página'),
                        
                        Select::make('template_id')
                            ->label('Plantilla')
                            ->options(Template::active()->pluck('name', 'id'))
                            ->searchable()
                            ->nullable()
                            ->helperText('Selecciona una plantilla prediseñada'),
                        
                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Descripción breve de la página'),
                        
                        Toggle::make('is_published')
                            ->label('Publicada')
                            ->default(false)
                            ->helperText('La página será visible públicamente'),
                    ])->columns(2),

                Section::make('Componentes de la Página')
                    ->schema([
                        Repeater::make('components')
                            ->relationship()
                            ->schema([
                                Select::make('type')
                                    ->label('Tipo de Componente')
                                    ->options(\App\Models\PageComponent::getAvailableTypes())
                                    ->required()
                                    ->reactive(),
                                
                                KeyValue::make('content')
                                    ->label('Contenido')
                                    ->keyLabel('Campo')
                                    ->valueLabel('Valor')
                                    ->reorderable()
                                    ->helperText('Define el contenido del componente'),
                                
                                KeyValue::make('settings')
                                    ->label('Configuración')
                                    ->keyLabel('Propiedad')
                                    ->valueLabel('Valor')
                                    ->reorderable()
                                    ->helperText('Colores, tamaños, etc.'),
                            ])
                            ->reorderable()
                            ->collapsible()
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => 
                                \App\Models\PageComponent::getAvailableTypes()[$state['type'] ?? ''] ?? 'Nuevo Componente'
                            )
                            ->addActionLabel('Agregar Componente')
                            ->defaultItems(0)
                    ]),

                Section::make('SEO y Personalización')
                    ->schema([
                        KeyValue::make('meta_tags')
                            ->label('Meta Tags')
                            ->keyLabel('Nombre')
                            ->valueLabel('Contenido')
                            ->reorderable()
                            ->helperText('Meta tags para SEO (keywords, author, etc.)'),
                        
                        Textarea::make('styles')
                            ->label('CSS Personalizado')
                            ->rows(5)
                            ->helperText('Agrega estilos CSS personalizados')
                            ->columnSpanFull(),
                        
                        Textarea::make('scripts')
                            ->label('JavaScript Personalizado')
                            ->rows(5)
                            ->helperText('Agrega scripts JavaScript personalizados')
                            ->columnSpanFull(),
                        
                        TextInput::make('domain')
                            ->label('Dominio Personalizado')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Opcional: dominio personalizado para esta página')
                            ->columnSpanFull(),
                    ])->columns(2)->collapsed(),
            ]);
    }
}
