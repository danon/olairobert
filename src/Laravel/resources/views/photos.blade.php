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
</style>
<div class="images">
 
  @forelse($images as $image)
    <img src="{{$image}}" alt="{{$image}}" class="photo"/>
  @empty
    <h4 style="text-align:center; opacity:0.5; margin-top:25vh;">
      Wrzuć pierwsze zdjęcie!
    </h4>
  @endforelse
</div>
