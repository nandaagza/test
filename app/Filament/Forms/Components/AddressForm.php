<?php

namespace App\Filament\Forms\Components;

use Filament\Forms;
use App\Models\Region;
use App\Models\Quarter;
use App\Models\Township;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;

class AddressForm extends Forms\Components\Field
{
    protected string $view = 'filament-forms::components.group';

    public $relationship = null;

    public function relationship(string | callable $relationship): static
    {
        $this->relationship = $relationship;

        return $this;
    }

    public function saveRelationships(): void
    {
        $state = $this->getState();
        $record = $this->getRecord();
        $relationship = $record?->{$this->getRelationship()}();

        if ($relationship === null) {
            return;
        } elseif ($address = $relationship->first()) {
            $address->update($state);
        } else {
            $relationship->updateOrCreate($state);
        }

        $record->touch();
    }

    public function getChildComponents(): array
    {
        return [
            Repeater::make('address')
                ->relationship('addresses')
                ->columns(3)
                ->label('Address')
                ->schema([
                    TextInput::make('address')
                        ->label('Address')
                        ->columns(1)
                        ->required(),
                    Select::make('region_id')
                        ->label('Region')
                        ->placeholder('Please choose region')
                        ->options(Region::all()->pluck('name', 'id')->toArray())
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('township_id', null))
                        ->columns(1)
                        ->required(),
                    Select::make('township_id')
                        ->label('Township')
                        ->columns(1)
                        ->placeholder('Please choose township')
                        ->options(function (callable $get) {
                            $region = Region::find($get('region_id'));
                            if (!$region) {
                                return Township::all()->pluck('name', 'id')->toArray();
                            }
                            return $region->townships->pluck('name', 'id')->toArray();
                        })
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('quarter_id', null))
                        ->required(),

                    Select::make('quarter_id')
                        ->label('Quarter')
                        ->columns(1)
                        ->placeholder('Please choose quarter')
                        // ->options(function (callable $get){
                        //     $township = Township::find($get('township_id'));
                        //     if (!$township) {
                        //         return Quarter::all()->pluck('name','id')->toArray();
                        //     }
                        //     return $township->quarters->pluck('name','id')->toArray();
                        // })
                        // ->reactive()
                        // ->required(),
                        ->options(function (callable $get) {
                            $townshipId = $get('township_id');

                            if (!$townshipId) {
                                return Quarter::all()->pluck('name', 'id')->toArray();
                            }

                            $township = Township::with('quarters')->find($townshipId);

                            return $township ? $township->quarters->pluck('name', 'id')->toArray() : [];
                        })
                        ->reactive()
                        ->required(),

                ])
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (AddressForm $component, ?Model $record) {
            $address = $record?->getRelationValue($this->getRelationship());

            $component->state($address ? $address->toArray() : [
                'address',
                'region_id',
                'township_id'
            ]);
        });

        $this->dehydrated(false);
    }

    public function getRelationship(): string
    {
        return $this->evaluate($this->relationship) ?? $this->getName();
    }
}
