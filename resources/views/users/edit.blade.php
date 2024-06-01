<x-app.template>
  <x-slot:title>{{ $user->name }}</x-slot>

  <x-slot:sidebar>
  </x-slot:sidebar>
  <form action="{{ route('users.update', ['user' => $user]) }}" method="POST" class="m-0" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="card">
      <div class="row g-0">
        <div class="col-md-4">
          <div class="card-body">
            <img src="{{ url($user->profile->photo) }}" class="img-fluid rounded">
            <input type="file" name="photo" class="form-control" />
          </div>
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <input type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $user->name }}" />
            <p class="card-text">
              <textarea class="form-control" rows="5" name="description">{{ old('description') ? old('description') : $user->profile->description }}</textarea>
            </p>
          </div>
        </div>
      </div>
      <div class="card-body py-0">
        <div class="row g-0 text-center">
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-text">
                <i class="fa-regular fa-envelope"></i>
              </span> 
              <input type="email" class="form-control" name="email" value="{{ old('email') ? old('email') : $user->email }}" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-text">
                <i class="fa-solid fa-mars"></i>
              </span> 
              <select class="form-select">
                <option @if(!$user->gender) selected @endif>Select</option>
                <option value="male" @if($user->gender == 'male') selected @endif>Male</option>
                <option value="female" @if($user->gender == 'female') selected @endif>Female</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-text">
                <i class="fa-solid fa-cake-candles"></i>
              </span> 
              <input type="text" class="form-control" name="birthdate" value="{{ old('birthdate') ? old('birthdate') : $user->profile->birthdate }}" />
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-text">
                <i class="fa-solid fa-location-dot"></i>
              </span> 
              <input type="text" class="form-control" name="location" value="{{ old('location') ? old('location') : $user->profile->location }}" />
            </div>
          </div>
        </div>
        <div class="row g-0 mt-5">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" value="{{ old('username') ? old('username') : $user->username }}" />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" />
          </div>
          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Password Confirmation</label>
            <input type="password" class="form-control" name="password_confirmation" />
          </div>
          <div class="form-check">
            <input type="hidden" name="private" value="0">
            <input class="form-check-input" type="checkbox" name="private" value="1" @if($user->profile->private) checked @endif />
            <label class="form-check-label">Private</label>
          </div>
        </div>
      </div>   
      <div class="card-body">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('users.show', ['user' => $user]) }}" class="btn btn-danger">Cancel</a>
      </div>
    </div>
  </form>
</x-app.template>