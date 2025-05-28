<x-layout>
    <h1 class="my-16 text-center text-4xl font-medium text-slate-600">
        Reset Your Password
      </h1>


      <x-card class="py-8 px-16">

        <form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <div class="mb-8">
            <x-label for="password"
            :required="true">Password</x-label>
            <x-text-input name="password" type="password" placeholder="New Password" required />
          </div>

          <div class="mb-8">
            <x-label for="password_confirmation"
            :required="true">Retype Password</x-label>
            <x-text-input name="password_confirmation" type="password" placeholder="Confirm Password" required />
          </div>

          <x-button class="w-full bg-green-50">Reset password</x-button>
      </x-card>
</x-layout>