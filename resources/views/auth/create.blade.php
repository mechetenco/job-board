<x-layout>
    <h1 class="my-16 text-center text-4xl font-medium text-slate-600">
        Create an account
      </h1>
 <x-card class="py-8 px-16">
        <form action="{{ route('auth.store') }}" method="POST">
          @csrf
    
          <div class="mb-8">
            <x-label for="name"
            :required="true">Name</x-label>
            <x-text-input name="name" value="{{ old('name') }}" required />
          </div>

           <div class="mb-8">
            <x-label for="email"
            :required="true">E-mail</x-label>
            <x-text-input name="email" value="{{ old('email') }}" required />
          </div>

           <div class="mb-8">
            <x-label for="password"
            :required="true">Password</x-label>
            <x-text-input name="password" type="password" required />
          </div>

          <div class="mb-8">
            <x-label for="password_confirmation"
            :required="true">Retype Password</x-label>
            <x-text-input name="password_confirmation" type="password" required />
          </div>
    
          
    
          
             
            </div>
          </div>
    
          <x-button class="w-full bg-green-50">Signup</x-button>
        </form>
      </x-card>

</x-layout>