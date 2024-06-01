<x-app.template>
  <x-slot:title>Register</x-slot>
  <form action="{{ route('register.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control" name="email" value="{{ old('email') }}" />
    </div>
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" name="username" value="{{ old('username') }}" />
    </div>
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" name="name" value="{{ old('name') }}" />
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" name="password" />
    </div>
    <div class="mb-3">
      <label for="password_confirmation" class="form-label">Password</label>
      <input type="password" class="form-control" name="password_confirmation" />
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</x-app.template>