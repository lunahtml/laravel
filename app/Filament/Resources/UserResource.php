<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->label('Name'),

            TextInput::make('email')
                ->email()
                ->required()
                ->label('Email'),

            TextInput::make('password')
                ->password()
                ->required()
                ->minLength(8)
                ->label('Password')
                ->hiddenOn('edit'), // Скрываем поле пароля при редактировании
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')
                ->sortable()
                ->label('ID'),

            TextColumn::make('name')
                ->sortable()
                ->searchable()
                ->label('Name'),

            TextColumn::make('email')
                ->sortable()
                ->searchable()
                ->label('Email'),

            TextColumn::make('created_at')
                ->label('Created At')
                ->date(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

