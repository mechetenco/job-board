<x-layout>
    <h1 class="my-16 text-center text-4xl font-medium text-slate-600">
        Reset Your Password
      </h1>


 <x-card class="py-8 px-16">
        <form action="{{ route('password.email') }}" method="POST">
          @csrf
    
          <div class="mb-8">
            <x-label for="email"
            :required="true">Type your email Address</x-label>
            <x-text-input name="email" />
          </div>

           <x-button class="w-full bg-green-50">Send Password Reset Link</x-button>
        </form>
      </x-card>





</x-layout>