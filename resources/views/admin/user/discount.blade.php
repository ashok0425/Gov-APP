@extends('admin.layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Subcategory and Discount for it ({{$user->name}})</h5>
            </div>
        </div>
        <table id="myTable" class="table table-responsive-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subcategory</th>
                    <th>Percentage</th>
                    <th>Type%</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user->discounts as $discount)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $discount->subcategory->name }}</td>
                        <td>{{ $discount->discount_percentage }}</td>
                        <td>{{ $discount->type?'Descrease':'Increase' }}</td>

                        <td><a href="{{route('admin.user.discount',$discount->id)}}" data-percentage="{{$discount->discount_percentage}}" class="btn btn-primary edit-btn"data-toggle="modal" data-target="#exampleModal" >Edit</a></td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Discount Percentage</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
               <form action="" method="post" id="edit-form">
                @csrf
                <div class="form-group">
                    <label for="">Discount Percent</label>
                    <input type="text" class="form-control" name="percentage" id="percentage">
                </div>
                <div class="form-group">
                    <label for="">Type</label>
                    <select name="type" id="" class="form-select">

                        <option value="1">Descrease</option>
                        <option value="0">Increase</option>
                    </select>
                </div>
            <div class="text-right mt-2">
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
        </div>

          </div>
        </div>
      </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('.edit-btn').on('click',function(){
            var percentage=$(this).attr('data-percentage');
            var url=$(this).attr('href');
            $('#edit-form').attr('action',url)
            $('#percentage').val(percentage)


        })
    })
</script>

@endpush
