 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Are you sure want to delete?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-left">
          {{ $post->title }}
        </div>
        <div class="modal-footer">
            <form action="/posts/destroy/{{ $post->slug }}" method="POST">
                @csrf
                @method('delete')
                <button class="btn btn-danger btn-sm" type="submit">
                    Delete
                </button>
            </form>
        </div>
      </div>
    </div>
  </div>