<style>
    .drawer {
        position: fixed;
        width: 100%;
        box-sizing: border-box;
        transition: bottom 0.5s;
        bottom: 0;
        border-top-left-radius: 25px;
        border-top-right-radius: 25px;
        background: white;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        border: 1px solid #eee;
        padding: 25px 15px;
        z-index: 1;
    }

    .hidden-drawer {
        z-index: 2;
    }

    .previews {
        display: flex;
        flex-wrap: wrap;
    }

    .preview {
        background-size: contain;
        background-repeat: no-repeat;
        margin-right: 15px;
    }

    .visible {
        margin-bottom: 15px;
        width: 100px;
        height: 100px;
        border: 1px solid #333;
        background-size: cover;
    }

    small {
        opacity: 0.7;
        font-size: 0.8em;
    }

    form, p {
        margin: 0;
    }

    .drawer.closed {
        bottom: -260px;
    }
</style>

<script>
  function openDrawer() {
    document.querySelector(".hidden-drawer").classList.toggle("closed", false);
  }
</script>

<div class="drawer" style="text-align:center;" onClick="openDrawer()">
  <i class="fa fa-plus"></i>
  Dodaj
</div>

<div class="drawer hidden-drawer closed">
  <form action="{{ $uploadUrl }}" method="POST" enctype="multipart/form-data">
    <div style="display:flex;justify-content:space-between; margin-bottom:15px;">
      <p>Wrzuć zdjęcie: <small>(max. 10MB)</small></p>
      <div>
        <button type="submit" disabled class="upload-button">
          Wyślij
          <i class="fa-solid fa-arrow-up"></i>
        </button>
      </div>
    </div>
    <div style="margin-bottom:1rem;">
      <i class="fa fa-plus"></i>
      <input type="file" name="photos[]" onchange="onImageSelect(event)" accept="image/jpeg" multiple="multiple">
    </div>
    <div class="previews">
    </div>
  </form>

  <script type="text/javascript">
    function onImageSelect(event) {
      const uploadButton = document.querySelector(".upload-button");
      uploadButton.setAttribute("disabled", "disabled");
      const fileUploadInput = event.target;
      if (!fileUploadInput.value) {
        return;
      }
      for (const image of fileUploadInput.files) {
        if (image.type !== '') {
          if (!image.type.includes("image")) {
            return alert("Możesz wrzucić tylko zdjęcia.");
          }
        }
        if (image.size > 10485760) {
          return alert("Maksymalny rozmiar zdjęcia to 10MB.");
        }
      }
      const previews = document.querySelector(".previews");
      previews.textContent = '';
      for (const image of fileUploadInput.files) {
        uploadButton.removeAttribute("disabled");
        const fileReader = new FileReader();
        fileReader.readAsDataURL(image);
        fileReader.onload = fileReaderEvent => {
          console.log(fileReaderEvent.target.result);
          const preview = document.createElement("div");
          preview.style.backgroundImage = `url(${fileReaderEvent.target.result})`;
          preview.classList.toggle("preview", true);
          preview.classList.toggle("visible", true);
          previews.appendChild(preview);
        };
      }
    }
  </script>
</div>
