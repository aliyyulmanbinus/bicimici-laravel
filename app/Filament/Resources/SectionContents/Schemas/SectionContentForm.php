<?php

namespace App\Filament\Resources\SectionContents\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

class SectionContentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_section_id')
                    ->label('CourseSection')
                    ->options(function () {
                        return \App\Models\CourseSection::with('course')
                        ->get()
                        ->mapWithKeys(function ($section) {
                            return [
                                $section->id => $section->course
                                    ? "{$section->course->name} - {$section->name}"
                                    : $section->name, //fallback if course is null
                                ];
                        })
                        ->toArray(); //convert the collection to an array
                    })
                    ->searchable()
                    ->required(),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
