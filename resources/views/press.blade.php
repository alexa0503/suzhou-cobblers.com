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
  //var recipient = button.data('whatever') // Extract info from data-* attributes
  var src = button.data('src');
  //alert(url);
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  var w = $('#press-image').width() - 50;
  var image = new Image();
  image.src = src;
  image.onload = function() {
      if( w < image.width ){
          modal.find('.modal-body').html('<img src="'+src+'" />').find('img').width(w);
      }
  }



  //modal.find('.modal-title').text('New message to ' + recipient)
  //modal.find('.modal-body input').val(recipient)
})
</script>
@endsection
