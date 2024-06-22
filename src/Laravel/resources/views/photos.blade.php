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

<script>
  let openForScroll = false;

  function load(image, callback) {
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
      load(images[0], () => loadNextImage(images));
    });
  }

  const images = Array.from(document.querySelectorAll(".images img[data-src]"));
  window.addEventListener("DOMContentLoaded", function () {
    loadNextImage(images);
    window.addEventListener("scroll", () => {
      if (openForScroll) {
        openForScroll = false;
        loadNextImage(images);
      }
    });
  });
</script>
