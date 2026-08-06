<?php

namespace App\Filament\Pages\Auth;

use Filament\Schemas\Schema;
use Filament\Auth\Pages\Login as BaseLogin;
use MortezaAshrafi\FilamentShieldCaptcha\Concerns\InteractsWithCaptcha;

class Login extends BaseLogin
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
