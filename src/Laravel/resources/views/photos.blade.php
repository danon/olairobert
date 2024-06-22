<style>
    .images {
        padding: 15px;
    }

    img.photo {
        background: white;
        max-width: 150px;
        max-height: 150px;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
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
        padding-bottom: 140px;
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
<div class="images">
  @forelse($images as $index => $image)
    @if ($index < 20)
      <img src="{{$image}}" alt="{{$image}}" class="photo"/>
    @else
      <img data-src="{{$image}}" data-id="{{$index}}" alt="{{$image}}" class="photo"/>
    @endif
  @empty
    <h4 style="text-align:center; opacity:0.5; margin-top:25vh;">
      Wrzuć pierwsze zdjęcie!
    </h4>
  @endforelse
</div>

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
