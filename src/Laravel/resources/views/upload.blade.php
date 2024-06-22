<style>
    .drawer {
        position: fixed;
        width: 100%;
        box-sizing: border-box;
        bottom: 0;
        border-top-left-radius: 25px;
        border-top-right-radius: 25px;
        background: white;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        border: 1px solid #eee;
        padding: 15px;
    }

    .preview {
        background-size: contain;
        background-repeat: no-repeat;
    }

    .visible {
        margin-bottom: 15px;
        width: 100px;
        height: 100px;
        border: 1px solid #333;
        background-size: cover;
    }
</style>

<div class="drawer">
  <p>Wrzuć zdjęcie:</p>

  <form action="{{ $uploadUrl }}" method="POST" enctype="multipart/form-data">
    <div class="add-button" style="margin-bottom:1rem;">
      <i class="fa fa-plus"></i>
      <input type="file" name="image" onchange="upload(event)" accept="image/*">
    </div>
    <div class="preview"></div>
    <button type="submit" class="upload-button">
      Wyślij
    </button>
  </form>

  <script>
    function upload(event) {
      const fileUploadInput = event.target;
      if (!fileUploadInput.value) {
        return;
      }
      const image = fileUploadInput.files[0];
      if (!image.type.includes("image")) {
        return alert("Only images are allowed!");
      }
      if (image.size > 10485760) {
        return alert("Maximum upload size is 10MB!");
      }
      const fileReader = new FileReader();
      fileReader.readAsDataURL(image);
      fileReader.onload = fileReaderEvent => {
        const profilePicture = document.querySelector(".preview");
        console.log(fileReaderEvent.target.result);
        profilePicture.style.backgroundImage = `url(${fileReaderEvent.target.result})`;
        profilePicture.classList.toggle("visible", true);
      };
    }
  </script>
</div>
