<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="text-5xl font-bold">
                Login
            </a>
        </x-slot>

        <x-validation-errors />
        <x-myerror />

        <form method="POST" action="{{ route('mylogin.verify') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="text" :value="__('ID')" />

                <x-input id="login" class="block mt-1 w-full" type="text" name="login" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div class="mt-4">
                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>

            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
