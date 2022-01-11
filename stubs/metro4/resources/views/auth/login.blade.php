<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}" class="login-form bg-white p-6 mx-auto"
              data-role="validator"
              data-clear-invalid="2000"
              data-on-error-form="invalidForm"
              data-on-validate-form="validateForm">
            @csrf
            <hr class="thin mt-4 mb-4 bg-white">

            <!-- Email Address -->
            <div class="form-group">
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="" type="email" name="email" data-validate="required email"
                         :value="old('email')"
                         placeholder="Enter your email..."/>
            </div>

            <!-- Password -->
            <div class="form-group">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="d-flex flex-column flex-align-center mt-4">
                <x-button class="">
                    {{ __('Log in') }}
                </x-button>

                @if (Route::has('password.request'))
                    <a class="fg-gray fg-darkGray-hover" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif


            </div>
        </form>

    </x-auth-card>
</x-guest-layout>
