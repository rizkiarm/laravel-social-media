@php
    $carouselId = 'carousel'.uniqid();
@endphp

<div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="true">
  <div class="carousel-indicators">
    @foreach($images as $image)
    <button type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $loop->iteration }}"></button>
    @endforeach
  </div>
  <div class="carousel-inner">
    @foreach($images as $image)
    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
      <img class="d-block w-100" src="{{ $image }}" alt="" />
    </div>
    @endforeach
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>