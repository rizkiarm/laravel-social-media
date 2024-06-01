<div class="card">
  <div class="card-body">
    <h5 class="card-title">Write a post</h5>
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" style="margin:0px;">
        @csrf
        <div class="d-grid gap-2">
            <textarea name='text' class="form-control">{{ old('text') }}</textarea>
            <input type="file" name="medias[]" class="form-control" multiple />
                    <div>
                <input type="submit" value="Submit" class="btn btn-primary">
                    </div>
        </div>
    </form> 
  </div>
</div>