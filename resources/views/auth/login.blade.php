<x-app.template>
  <x-slot:title>Login</x-slot>
  <form action="{{ route('authenticate') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control" name="email" value="{{ old('email') }}" />
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" name="password" />
    </div>
    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" />
      <label class="form-check-label" name="remember">Remember me</label>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>

</x-app.template>