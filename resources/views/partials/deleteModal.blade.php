<!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{$loop->index}}">
<i class="fa fa-trash"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal{{$loop->index}}" tabindex="-1" aria-labelledby="exampleModal{{$loop->index}}Label" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      
      <div class="modal-body">
            <h1 class="text-danger text-center">
                <i class="fa fa-trash"></i>
            </h1>

            <h5 class="text-center">
                @yield('modalText'.$loop->index)
            </h5>
            <hr>
            @yield('modalForm'.$loop->index)

      </div>
      
    </div>
  </div>
</div>