<?php

namespace App\Filament\Resources\Templates\Schemas;

use Filament\Schemas\Components\FileUpload;
use Filament\Schemas\Components\KeyValue;
use Filament\Schemas\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Toggle;
use Filament\Schemas\Schema;

class TemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de la Plantilla')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),
                        
                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(3)
                            ->maxLength(500),
                        
                        FileUpload::make('preview_image')
                            ->label('Imagen de Vista Previa')
                            ->image()
                            ->directory('templates/previews')
                            ->nullable(),
                        
                        Toggle::make('is_active')
                            ->label('Activa')
                            ->default(true),
                    ])->columns(2),

                Section::make('Estructura de la Plantilla')
                    ->schema([
                        Repeater::make('structure')
                            ->label('Componentes Predefinidos')
                            ->schema([
                                Select::make('type')
                                    ->label('Tipo de Componente')
                                    ->options(\App\Models\PageComponent::getAvailableTypes())
                                    ->required(),
                                
                                KeyValue::make('content')
                                    ->label('Contenido por Defecto')
                                    ->keyLabel('Campo')
                                    ->valueLabel('Valor')
                                    ->reorderable(),
                                
                                KeyValue::make('settings')
                                    ->label('Configuración por Defecto')
                                    ->keyLabel('Propiedad')
                                    ->valueLabel('Valor')
                                    ->reorderable(),
                            ])
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => 
                                \App\Models\PageComponent::getAvailableTypes()[$state['type'] ?? ''] ?? 'Componente'
                            )
                            ->addActionLabel('Agregar Componente')
                            ->defaultItems(0),
                    ]),

                Section::make('Estilos por Defecto')
                    ->schema([
                        KeyValue::make('default_styles')
                            ->label('Estilos CSS')
                            ->keyLabel('Propiedad')
                            ->valueLabel('Valor')
                            ->reorderable()
                            ->helperText('Define estilos CSS por defecto para esta plantilla'),
                    ])->collapsed(),
            ]);
    }
}
