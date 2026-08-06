<?php

namespace App\Filament\Pages\Auth;

use Filament\Schemas\Schema;
use Filament\Auth\Pages\Register as BaseRegister;
use MortezaAshrafi\FilamentShieldCaptcha\Concerns\InteractsWithCaptcha;

class Register extends BaseRegister
{
    use InteractsWithCaptcha;

    public function form(Schema $form): Schema
    {
        return parent::form($form)
            ->components([
                ...$form->getComponents(),
                $this->getCaptchaFormComponent()
                ->width(371),
            ]);
    }
}
