<?php

namespace App\Filament\Driver\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;

class MyDriverInfo extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'My Driver Info';
    protected static ?string $title = ' Driver Info';
    protected static string $view = 'filament.driver.pages.my-driver-info';

    public ?array $data = [];
    public bool $editing = false;

    public function mount(): void
    {
        $driver = Auth::user()?->driver;
        if ($driver) {
            $this->editing = false;
            $this->form->fill($driver->only([
                'phone_number',
                'address',
                'city',
                'DOB',
                'license_number',
            ]));
        } else {
            $this->editing = true;
        }
    }

    public function form(Form $form): Form
    {
        $user = Auth::user();

        return $form
            ->schema([
                Forms\Components\Placeholder::make('name')
                    ->label('Name')
                    ->content($user?->name),
                Forms\Components\Placeholder::make('email')
                    ->label('Email')
                    ->content($user?->email),
                Forms\Components\TextInput::make('phone_number')->label('Phone Number')->required(),
                Forms\Components\TextInput::make('address')->label('Address')->required(),
                Forms\Components\TextInput::make('city')->label('City')->required(),
                Forms\Components\TextInput::make('DOB')->label('Date of Birth')->required(),
                Forms\Components\TextInput::make('license_number')->label('License Number')->required(),
            ])
            ->statePath('data');
    }

public function save()
{
    $user = Auth::user();
    $driver = $user->driver;

    if (!$driver) {
        $driver = $user->driver()->create([
            'user_id' => $user->id,
            ...$this->data,
        ]);
    } else {
        $driver->update($this->data);
    }

    $this->editing = false;
}

    public function edit()
    {
        $this->editing = true;
    }
}