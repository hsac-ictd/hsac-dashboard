<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\RedirectToDashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Swis\Filament\Backgrounds\ImageProviders\MyImages;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->passwordReset()
            ->colors([
                'primary' => Color::Indigo,     // Main theme accent
                'success' => Color::Emerald,    // For success statuses
                'danger' => Color::Rose,        // For errors or destructive actions
                'warning' => Color::Amber,      // For warnings or pending items
                'info' => Color::Sky,           // For general info or tips
                'gray' => Color::Zinc,          // Neutral/background
                'neutral' => Color::Stone,      // Secondary neutral (subtle UI parts)
                'blue' => Color::Blue,          // Optional charting/secondary actions
                'red' => Color::Red,            // Alternative error
                'green' => Color::Green,        // Alternative success
                'yellow' => Color::Yellow,      // Optional for statuses
                'orange' => Color::Orange,      // Optional accent
                'lime' => Color::Lime,          // For dynamic visuals (less common)
                'cyan' => Color::Cyan,          // For analytics/dashboard
                'violet' => Color::Violet,      // Creative / reports
                'fuchsia' => Color::Fuchsia,    // Rare use (tags, optional categories)
                'teal' => Color::Teal,          // Calm / balance visual
                'pink' => Color::Pink,          // Rare, expressive
                'purple' => Color::Purple,      // Brand / navigation highlight
                'indigo' => Color::Indigo,      // Used as primary
                'sky' => Color::Sky,            // Matches info
                'stone' => Color::Stone,        // UI skeleton / base
            ])
            ->maxContentWidth(MaxWidth::Full)
            ->font('TikTok Sans')
            ->brandName('CMD')
            ->brandLogo(fn () => view('filament.admin.logo'))
            ->brandLogoHeight('3.5rem')
            ->favicon(asset('images/logo.png'))
            ->topNavigation()
            ->sidebarWidth('sm')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                //Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
                RedirectToDashboard::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
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
                \Swis\Filament\Backgrounds\FilamentBackgroundsPlugin::make()
                    ->imageProvider(MyImages::make()->directory('images/backgrounds')),
                \Jeffgreco13\FilamentBreezy\BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: true, // Sets the 'account' link in the panel User Menu (default = true)
                        userMenuLabel: 'My Profile', // Customizes the 'account' link label in the panel User Menu (default = null)
                        shouldRegisterNavigation: false, // Adds a main navigation item for the My Profile page (default = false)
                        navigationGroup: 'Settings', // Sets the navigation group for the My Profile page (default = null)
                        hasAvatars: false, // Enables the avatar upload form component (default = false)
                        slug: 'my-profile', // Sets the slug for the profile page (default = 'my-profile'),
                    )
                    ->enableBrowserSessions(condition: true),
            ])
            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn ():  View => view('filament.components.loading-indicator')
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                    fn (): View => view('filament.components.custom-footer')
            )
            ->spa()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s');
    }
}
