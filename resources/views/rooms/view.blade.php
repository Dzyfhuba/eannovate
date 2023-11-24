@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
    <div class="alert alert-success">{{session('success')}}</div>
    @endif
    <div class="text-right">
        <a href="{{route('room.create')}}" class="btn btn-primary">New Room</a>
    </div>
    <button id="delete" onclick="OnDelete()" class="btn btn-danger">delete</button>

    <table id="example">
        <thead>
            <tr>
                <th>Name</th>
                <th>Major</th>
                <th>Created By</th>
                <th>Updated By</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection

@section('script')
<script>
    const table = new DataTable('#example', {
        select: true,
        dom: 'Bfrtip',
        rowId: 'id',
        ajax: {
            url: '/room/json',
            type: 'GET'
        },
        columns: [
            {
                data: 'name'
            },
            {
                data: 'major'
            },
            {
                data: 'created_by'
            },
            {
                data: 'updated_by'
            },
            {
                data: 'created_at'
            },
            {
                data: 'updated_at'
            },
            {
                data: 'id',
                render: (data) => `<a href='/room/edit/${data}' class="btn btn-warning">Edit</a>`
            }
        ]
    });
    console.log(table)

    const OnDelete = () => {
        // $('#example').DataTable()

        const ids = table.rows({
            selected: true
        }).ids().toArray()
        console.log(typeof ids)

        if (ids.lenght === 0) {
            alert('select at least one.')
            return
        }

        if (confirm("Delete?")) {
            ids.forEach(e => {
                const res = fetch(`/room/delete/${e}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                    .then(r => console.log(table.ajax.reload()))
                    .catch(e => console.error(e))

            });
        }
    }
</script>
@endsection
