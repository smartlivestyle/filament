<?php

namespace App\Filament\Pages\Auth;

use Filament\Schemas\Schema;
use Filament\Auth\Pages\PasswordReset\RequestPasswordReset as BaseRequestPasswordReset;
use MortezaAshrafi\FilamentShieldCaptcha\Concerns\InteractsWithCaptcha;

class RequestPasswordReset extends BaseRequestPasswordReset
{
    use InteractsWithCaptcha;

    public function form(Schema $form): Schema
    {
        return parent::form($form)
            ->components([
                ...$form->getComponents(),
                $this->getCaptchaFormComponent()
                ->width(220)
                ->height(5)
                ->length(5)
                ->fontSize(8)
                ->font('vazirmatn')
                ->lightColors(background: [255, 255, 255], text: [30, 30, 30])
                ->darkColors(background: [24, 24, 27], text: [245, 245, 245])
                ->alphanumeric()
                ->caseSensitive(false)
                ->noise(level: 2, lines: 3, dots: 40)
                ->ttl(300)
                ->maxAttempts(5)
            ]);
    }
}
