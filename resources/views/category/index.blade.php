<x-app-layout>
  <x-slot name="header">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Categories') }}
    </h2>
</x-slot>

<script>
  $(document).ready(function() {
    $('#createCategoryModal').modal({
      show: false
    });

    $('.open-modal-btn').click(function(e) {
      e.preventDefault();
      $('#createCategoryModal').modal('show');
    });
  });
</script> 
<br/>
<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="d-flex flex-row-reverse">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCategoryModal">
              Create Category
          </button>
      </div>
<br/>
<br/>
<div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-body">
            <!-- Category create form goes here -->
            <form action="/category/insert" method="POST">
              @csrf
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name">
              </div>
              <div class="form-group">
                <textarea id="description" name="description" placeholder="Type here Your description" rows="5" cols="40"></textarea>
              </div>
             
              <button type="submit" class="btn btn-primary">Create</button>
            </form>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <form action="{{ route('category.index') }}" method="GET">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Search " name="search" value="{{ request()->query('search') }}">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">Search</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
<table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>description</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{$category->id}}</td>
            <td>{{$category->name}}</td>
            <td>{{$category->description}}</td>
            <td>
                <a href="{{route('category.edit',$category->id)}}" class="btn btn-primary">Edit</a> 
            </td>
            <td>
                <form action="{{ route('category.delete', $category->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                 </form>
            </td>
          </tr>
          @endforeach
    </tbody>
</table> 
{{ $categories->links() }}
</div>
</div>
</div>
</div>
</div>
</x-app-layout>