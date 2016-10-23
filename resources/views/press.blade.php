@extends('layouts.app')
@section('content')
<div class="container">
    @foreach ($types as $type)
    <div class="row press">
        <div style="width:164px;text-align:center;" class="pull-left">
            <div style="width:130px;overflow:hidden;margin:0 17px;">
                <a href="#" class="product-size" data-src="{{asset($type->image)}}"  data-toggle="modal" data-target="#press-image"><img src="{{asset($type->thumb)}}"></a>
            </div>
            <h4 style="margin:10px 10px;">{{$type->title}}</h4>
        </div>
        <div style="margin-left:186px;padding-right:0px;">
            <div class="rows">
                @foreach ($type->subPresses as $press)
                <div class="press-list">
                    <img src="{{asset($press->thumb)}}" height="108">
                    <div><p style="margin:10px 0 20px;">{{$press->title}}</p></div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @endforeach
</div>
<div class="modal fade" id="press-image" tabindex="-1" role="dialog" aria-labelledby="press-image">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
      <div class="modal-body">

      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
$('#press-image').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var src = button.data('src');
  var modal = $(this)
  var w = $('#press-image').width() - 50;
  modal.find('.modal-body').html('<img src="'+src+'" width="'+w+'" />').find('img').load(function(){
      var image = new Image();
      image.src = src;
      image.onload = function() {
          if( w < image.width ){
             $(this).width(w);
          }
          else{
              $(this).width(image.width)
          }
      }
  });
})
</script>
@endsection
