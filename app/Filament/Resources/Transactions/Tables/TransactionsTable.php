<?php

namespace App\Filament\Resources\Transactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use App\Models\Transaction;
use Illuminate\Support\Facades\Notification;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                ImageColumn::make('student.photo')
                ->circular()
                ,

                TextColumn::make('student.name')
                    ->searchable(),

                TextColumn::make('booking_trx_id')
                ->searchable(),

                TextColumn::make('pricing.name'),

                IconColumn::make('is_paid')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Terverifikasi'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),

                Action::make('approve')
                    ->label('Approve')
                    ->action(function (Transaction $record) {
                        $record->is_paid = true;
                        $record->save();

                        // Trigger the custom notification
                        Notification::make()
                            ->title('Order Approved')
                            ->success()
                            ->body('The Order has been successfully approved.')
                            ->send();

                        // kirim email, kirim sms

                    })
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Transaction $record) => !$record->is_paid),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
