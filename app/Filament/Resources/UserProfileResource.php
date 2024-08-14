<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserProfileResource\Pages;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Models\UserProfile;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserProfileResource extends Resource
{
    protected static ?string $model = UserProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id'))
                    ->nullable()
                    ->required(),

                Select::make('country_id')
                    ->label('Country')
                    ->options(Country::all()->pluck('name', 'id'))
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('state_id', null))
                    ->required(),

                Select::make('state_id')
                    ->label('State')
                    ->options(function (callable $get) {
                        $countryId = $get('country_id');
                        if (! $countryId) {
                            return []; // Empty options if no country is selected
                        }

                        return State::where('country_id', $countryId)->pluck('name', 'id');
                    })
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(fn (callable $set) => $set('city_id', null))
                    ->disabled(fn (callable $get) => ! $get('country_id')),

                Select::make('city_id')
                    ->label('City')
                    ->options(function (callable $get) {
                        $stateId = $get('state_id');
                        if (! $stateId) {
                            return []; // Empty options if no state is selected
                        }

                        return City::where('state_id', $stateId)->pluck('name', 'id');
                    })
                    ->required()
                    ->disabled(fn (callable $get) => ! $get('state_id')),

                FileUpload::make('profile_picture')
                    ->label('Profile Picture')
                    ->image()
                    ->directory('profile-pictures')
                    ->disk('public'),

                Textarea::make('bio')
                    ->label('Bio')
                    ->rows(3)
                    ->nullable(),

                Radio::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ])
                    ->label('Gender')
                    ->nullable(),

                CheckboxList::make('hobbies')
                    ->options([
                        'reading' => 'Reading',
                        'sports' => 'Sports',
                        'music' => 'Music',
                    ])
                    ->label('Hobbies')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label(ucfirst('User'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('profile_picture_url')
                    ->label('Profile Picture')
                    ->url(fn ($record) => $record->profile_picture_url),

                Tables\Columns\TextColumn::make('country.name')
                    ->label('Country')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('state.name')
                    ->label(ucfirst('State'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('city.name')
                    ->label('City')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('gender')
                    ->label(ucfirst('Gender'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('hobbies')
                    ->label(ucfirst('Hobbies'))
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('bio')
                    ->label(ucfirst('Bio'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(50),
            ])
            ->filters([
                // Add any filters here if required
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
        return [
            // Add relations if required
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserProfiles::route('/'),
            'create' => Pages\CreateUserProfile::route('/create'),
            'edit' => Pages\EditUserProfile::route('/{record}/edit'),
        ];
    }
}
