<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 4,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
                \Arseno25\FilamentPrivacyBlur\FilamentPrivacyBlurPlugin::make()
                    ->defaultMode('blur_click')
                    ->blurAmount(4)
                    ->exceptColumns(['id', 'created_at', 'updated_at'])
                    ->exceptPanels(['public'])
                    ->enableAudit(),
                \DamodarBhattarai\FilamentSettings\FilamentSettingsPlugin::make()
                    ->canModifyFields(fn () => auth()->user()->hasRole('super_admin'))
                    ->navigationIcon('heroicon-o-cog-6-tooth')
                    ->navigationGroup('Settings')
                    ->navigationLabel('App Settings')
                    ->navigationSort(100)
                    ->pageTitle('App Settings')
                    ->slug('app-settings')
                    ->canModifyFields(true),
                \UniFileManager\FilamentFileManager\FilamentFileManagerPlugin::make(),
                \Martin6363\FilamentSmartSeo\FilamentSmartSeoPlugin::make(),
                \Matondojk\FilamentSocialLogin\FilamentSocialLoginPlugin::make(),
                \ThalysJuvenal\Aurum\AurumTheme::make()
                    ->preset(\ThalysJuvenal\Aurum\Presets\Gold::class),
                \Ipatco\FilamentProfile\FilamentProfilePlugin::make()
                    ->showOnDropdown()
                    ->icon(\Filament\Support\Icons\Heroicon::OutlinedUserCircle)
                    ->label('Profile'),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
