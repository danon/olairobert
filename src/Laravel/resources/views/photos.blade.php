<style>
    .images {
        padding: 15px;
        display: flex;
        flex-wrap: wrap;
        box-sizing: border-box;
    }

    img.photo {
        width: 33%;
        height: 150px;
        object-fit: cover;
    }

    img.photo[data-src] {
        visibility: hidden;
    }

    .photo-preview {
        display: none;
    }

    .photo-preview.open {
        display: flex;
        position: fixed;
        align-items: center;
        justify-content: center;
        top: 0;
        left: 0;
        height: 100%;
        box-sizing: border-box;
        width: 100%;
        background-color: black;
        z-index: 2;
    }

    .photo-preview .close {
        position: absolute;
        right: 10px;
        top: 9px;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5em;
    }

    .photo-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
</style>

@if (\count($images) > 0)
  <div class="images">
    @foreach($images as $index => $image)
      @if ($index < 20)
        <img src="{{$image}}" alt="{{$image}}" class="photo"/>
      @else
        <img data-src="{{$image}}" alt="{{$image}}" class="photo"/>
      @endif
    @endforeach
  </div>
@else
  <h4 style="text-align:center; opacity:0.5; margin-top:25vh;">
    Wrzuć pierwsze zdjęcie!
  </h4>
@endif

<div class="photo-preview">
  <img>
  <div class="close">
    <i class="fa-solid fa-times"></i>
  </div>
</div>

<script>
  let openForScroll = false;

  function load(image, images, callback) {
    if (image.getBoundingClientRect().top < window.innerHeight) {
      images.shift();
      image.onload = image.onerror = callback;
      image.src = image.dataset.src;
      delete image.dataset.src;
    } else {
      openForScroll = true;
    }
  }

  function loadNextImage(images) {
    if (images.length === 0) {
      return;
    }
    requestIdleCallback(() => {
      load(images[0], images, () => loadNextImage(images));
    });
  }

  window.addEventListener("DOMContentLoaded", function () {
    const images = Array.from(document.querySelectorAll(".images img[data-src]"));
    loadNextImage(images);
    window.addEventListener("scroll", () => {
      if (openForScroll) {
        openForScroll = false;
        loadNextImage(images);
      }
    });

    const element = document.querySelector(".photo-preview");

    Array.from(document.querySelectorAll(".images .photo")).forEach(image => {
      image.addEventListener("click", function () {
        element.querySelector("img").src = image.src;
        element.classList.toggle("open", true);
      });
    });

    document.querySelector(".close").addEventListener("click", () => {
      element.querySelector("img").src = null;
      element.classList.toggle("open", false);
    });
  });
</script>
