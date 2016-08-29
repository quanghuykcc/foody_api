<table class="table table-responsive" id="restaurants-table">
    <thead>
        <th>Name</th>
        <th>Address</th>
        <th>Open Time</th>
        <th>Category Id</th>
        <th>Close Time</th>
        <th>Phone Number</th>
        <th>Image</th>
        <th>Content</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($restaurants as $restaurant)
        <tr>
            <td>{!! $restaurant->name !!}</td>
            <td>{!! $restaurant->address !!}</td>
            <td>{!! $restaurant->open_time !!}</td>
            <td>{!! $restaurant->category_id !!}</td>
            <td>{!! $restaurant->close_time !!}</td>
            <td>{!! $restaurant->phone_number !!}</td>
            <td>{!! $restaurant->image !!}</td>
            <td>{!! $restaurant->content !!}</td>
            <td>
                {!! Form::open(['route' => ['restaurants.destroy', $restaurant->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('restaurants.show', [$restaurant->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('restaurants.edit', [$restaurant->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
