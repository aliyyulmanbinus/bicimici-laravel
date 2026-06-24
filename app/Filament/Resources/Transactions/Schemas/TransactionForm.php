<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ToggleButtons;
use App\Models\Pricing;
use App\Models\User;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([

                    Wizard\Step::make('Product and Price')
                        ->schema([
                            Grid::make(2)
                                ->schema([

                                    Select::make('pricing_id')
                                    ->relationship('pricing', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $pricing = Pricing::find($state); // get the pricing information

                                        $price = $pricing->price; // get the price
                                        $duration = $pricing->duration; // get the duration

                                        $subTotal = $price * $state; // get the sub total
                                        $totalPpn = $subTotal * 0.11; // get the total ppn
                                        $totalAmount = $subTotal + $totalPpn; // get the total amount

                                        $set('total_tax_amount', $totalPpn);
                                        $set('grand_total_amount', $totalAmount);
                                        $set('sub_total_amount', $price);
                                        $set('duration', $duration);
                                    })
                                    ->afterStateHydrated(function (callable $set, $state) {
                                        $pricingId = $state;
                                        if ($pricingId) {
                                            $pricing = Pricing::find($pricingId);
                                            $duration = $pricing->duration;
                                            $set('duration', $duration);
                                        }
                                    }),

                                    TextInput::make('duration')
                                    ->required()
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix('Months'),

                            ]),

                            Grid::make(3)
                            ->schema([
                                TextInput::make('sub_total_amount')
                                    ->required()
                                    ->numeric()
                                    ->prefix('IDR')
                                    ->readOnly(),

                                TextInput::make('total_tax_amount')
                                    ->required()
                                    ->numeric()
                                    ->prefix('IDR')
                                    ->readOnly(),

                                TextInput::make('grand_total_amount')
                                    ->required()
                                    ->numeric()
                                    ->prefix('IDR')
                                    ->readOnly()
                                    ->helperText('Harga sudah include PPN 11%'),
                            ]),


                            Grid::make(2)
                            ->schema([
                                DatePicker::make('started_at')
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $duration = $get('duration'); // Get the duration from the form state
                                    if ($state && $duration) {
                                        $endedAt = \Carbon\Carbon::parse($state)->addMonth($duration); // Calculate the end date
                                        $set('ended_at', $endedAt->format('Y-m-d')); // Set the calculated end date
                                    }
                                })
                                ->required(),

                                DatePicker::make('ended_at')
                                ->readOnly()
                                ->required(),

                            ]),
                        ]),

                        Wizard\Step::make('Customer Information')
                        ->schema([
                            Select::make('user_id')
                                ->relationship('student', 'email')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $user = User::find($state);

                                    $name = $user->name;
                                    $email = $user->email;

                                    $set('name', $name);
                                    $set('email', $email);
                                })
                                ->afterStateHydrated(function (callable $set, $state) {
                                    $userId = $state;
                                    if ($userId) {
                                        $user = User::find($userId);
                                        $name = $user->name;
                                        $email = $user->email;
                                        $set('name', $name);
                                        $set('email', $email);
                                    }
                                }),
                            TextInput::make('name')
                                ->required()
                                ->readOnly()
                                ->maxLength(255),

                            TextInput::make('email')
                                ->required()
                                ->readOnly()
                                ->maxLength(255),
                        ]),


                    Wizard\Step::make('Payment Information')
                        ->schema([

                            ToggleButtons::make('is_paid')
                                ->label('Apakah sudah membayar?')
                                ->boolean()
                                ->grouped()
                                ->icons([
                                    true => 'heroicon-o-pencil',
                                    false => 'heroicon-o-clock',
                                ])
                                ->required(),

                            Select::make('payment_type')
                                ->options([
                                    'Midtrans' => 'Midtrans',
                                    'Manual' => 'Manual',
                                ])
                                ->required(),

                            FileUpload::make('proof')
                                ->image(),
                        ]),

                ])
                ->columnSpan('full') // Use full width for the wizard
                ->columns(1) // Make sure the form has a single column layout
                ->skippable()

                // TextInput::make('booking_trx_id')
                //     ->required(),
                // TextInput::make('user_id')
                //     ->required()
                //     ->numeric(),
                // TextInput::make('pricing_id')
                //     ->required()
                //     ->numeric(),
                // TextInput::make('sub_total_amount')
                //     ->required()
                //     ->numeric(),
                // TextInput::make('grand_total_amount')
                //     ->required()
                //     ->numeric(),
                // TextInput::make('total_tax_amount')
                //     ->required()
                //     ->numeric(),
                // Toggle::make('is_paid')
                //     ->required(),
                // TextInput::make('payment_type')
                //     ->required(),
                // TextInput::make('proof'),
                // DatePicker::make('started_at')
                //     ->required(),
                // DatePicker::make('ended_at')
                //     ->required(),
            ]);
    }
}
