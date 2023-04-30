<x-app-layout>
    <x-slot name="header">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('product') }}
      </h2>
  </x-slot>
  <script>
    $(document).ready(function() {
      $('#createProductModal').modal({
        show: false
      });
  
      $('.open-modal-btn').click(function(e) {
        e.preventDefault();
        $('#createProductModal').modal('show');
      });
    });
  </script> 
  <script>

  function editProduct(productId) {
  $('#product_id').val(productId);

  $.ajax({
    url: '/products/edit/'+productId,
    method: 'GET',
    //data: {id: productId},
    success: function(response) {
      if (response.success) {
        var product = response.data;

        $('#name').val(product.name);
        $('#description').val(product.description);
        $('#price').val(product.price);
        $('#category_id').val(product.category_id);
        // Set the image preview
        if (product.image) {
          $('#image-preview').attr('src', '/images/' + product.image);
        }
      } else {
        alert(response.message);
      }
    },
    error: function() {
      alert('An error occurred while retrieving the product data');
    }
  });

  $('#editProductModal').modal('show');
}
    </script>
  <br/>
<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="d-flex flex-row-reverse">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createProductModal">
              Create Product
          </button>
      </div>
<br/>
<br/>
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('products.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" id="product_id" value="">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="category_id">Category</label>
                      <select class="form-control" id="category_id" name="category_id">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="price">Price</label>
                      <input type="number" class="form-control" id="price" name="price" placeholder="Enter price">
                    </div>
                    <div class="form-group">
                      <label for="image">Image</label>
                      <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModalLabel" aria-hidden="true">
    
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-body">
            <!-- Category create form goes here -->
            <form action="{{ route('products.insert') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name">
              </div>
              <div class="form-group">
                <textarea id="description" name="description" placeholder="Type here Your description" rows="5" cols="40"></textarea>
              </div>
              <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" class="form-control" min="0" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-control" id="category_id" name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" name="image" id="image" class="form-control-file">
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
      <form action="{{ route('product.index') }}" method="GET">
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
        <th>price</th>
        <th>description</th>
        <th>Thumbnail</th>
        <th>Category</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{$product->id}}</td>
            <td>{{$product->name}}</td>
            <td>{{$product->price}}</td>
            <td>{{$product->description}}</td>
            <td><a href="{{ asset('storage/images/'.$product->image) }}"><img src="{{ asset('storage/images/'.$product->image) }}" width="50" height="50"></a></td>
            <td>{{$product->category->name}}</td>
            <td>
                <a href="#" class="btn btn-primary" onclick="editProduct({{$product->id}})">Edit</a>

            </td>
            <td>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                 </form>
            </td>
          </tr>
          @endforeach
    </tbody>
</table> 
{{ $products->links() }}
</div>
</div>
</div>
</div>
</div>
</x-app-layout>