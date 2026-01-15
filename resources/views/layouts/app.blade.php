<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item>

                <flux:sidebar.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>
        </flux:sidebar>

        <flux:header sticky container class="border-b border-zinc-200 dark:border-zinc-700">
            <flux:sidebar.toggle />

            <flux:spacer />

            <flux:dropdown align="start" class="lg:hidden">
                <flux:navbar.item icon-trailing="chevron-down" :arrow="true" class="max-lg:hidden">{{ __('Options') }}</flux:navbar.item>

                <x-slot:button>
                    <flux:button size="sm" variant="ghost" icon="ellipsis-vertical" inset="top bottom"></flux:button>
                </x-slot:button>

                <flux:menu class="min-w-32">
                    <flux:menu.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">{{ __('Repository') }}</flux:menu.item>
                    <flux:menu.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">{{ __('Documentation') }}</flux:menu.item>
                </flux:menu>
            </flux:dropdown>

            <flux:dropdown align="end">
                <flux:profile :avatar="auth()->user()->gravatar()" name="{{ auth()->user()->name }}" />

                <flux:menu class="min-w-44">
                    <flux:menu.item icon="user" :href="route('profile.edit')" wire:navigate>{{ __('Profile') }}</flux:menu.item>
                    <flux:menu.separator />
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <flux:menu.item type="submit" icon="arrow-right-start-on-rectangle">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <flux:main>
            @yield('content')
        </flux:main>

        @fluxScripts
    </body>
</html>
