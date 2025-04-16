<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">

            <div class="p-4">

                    @include('profile.partials.update-profile-information-form')

            </div>

            <div class="p-4">

                    @include('profile.partials.update-password-form')

            </div>



    </div>
</x-app-layout>
