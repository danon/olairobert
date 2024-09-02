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

    .photo-preview .icon {
        position: absolute;
        color: white;
        font-size: 1.5em;
        text-shadow: rgba(0, 0, 0, 0.5) -1px 4px 5px;
    }

    .photo-preview .icon.change {
        top: calc(50% - 100px);
        height: 200px;
        padding-top: 87px;
        width: 100px;
    }

    .photo-preview .icon.change.prev {
        left: 15px;
        text-align: left;
    }

    .photo-preview .icon.change.next {
        right: 15px;
        text-align: right;
    }

    .photo-preview .close {
        right: 10px;
        top: 9px;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
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
      @if ($index < 0)
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
  <div class="icon close">
    <i class="fa-solid fa-times"></i>
  </div>
  <div class="icon change prev">
    <i class="fa-solid fa-chevron-left"></i>
  </div>
  <div class="icon change next">
    <i class="fa-solid fa-chevron-right"></i>
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

  function imageSrc(image) {
    if (typeof image.dataset.src === "undefined") {
      return image.src;
    }
    return image.dataset.src;
  }

  window.addEventListener("DOMContentLoaded", function () {
    const notYetLoadedImages = Array.from(document.querySelectorAll(".images img[data-src]"));
    loadNextImage(notYetLoadedImages);
    window.addEventListener("scroll", () => {
      if (openForScroll) {
        openForScroll = false;
        loadNextImage(notYetLoadedImages);
      }
    });

    const photoPreview = document.querySelector(".photo-preview");
    const images = document.querySelectorAll(".images .photo");

    let currentlyPreviewedImage = null;

    function previewImage(index) {
      if (!images.hasOwnProperty(index)) {
        return;
      }
      photoPreview.querySelector("img").src = imageSrc(images[index]);
      photoPreview.classList.toggle("open", true);
      currentlyPreviewedImage = index;
    }

    Array.from(images).forEach((image, index) => {
      image.addEventListener("click", () => previewImage(index));
    });

    document.querySelector(".close").addEventListener("click", () => {
      photoPreview.classList.toggle("open", false);
      photoPreview.querySelector("img").removeAttribute("src");
      currentlyPreviewedImage = null;
    });

    Array.from(document.querySelectorAll('.icon.change')).forEach(changeIcon => {
      changeIcon.addEventListener('click', event => {
        const isDirectionNext = changeIcon.classList.contains('next');
        if (isDirectionNext) {
          previewImage(currentlyPreviewedImage + 1);
        } else {
          previewImage(currentlyPreviewedImage - 1);
        }
      });
    });
  });
</script>
