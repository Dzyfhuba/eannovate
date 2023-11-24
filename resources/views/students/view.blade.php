@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Students</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="text-right mb-3">
            <a href="{{ route('student.create') }}" class="btn btn-primary">New Student</a>
        </div>
        <button id="delete" onclick="OnDelete()" class="btn btn-danger">delete</button>
        <table id="example" class="table-responsive">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Username</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Phone Number</th>
                    <th>Picture</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
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
                url: '/json',
                type: 'GET'
            },
            columns: [{
                    data: 'username'
                },
                {
                    data: 'email'
                },
                {
                    data: 'age'
                },
                {
                    data: 'phone_number'
                },
                {
                    data: 'picture',
                    render: (data) => `<img src="/pictures/${data}" height="100" width="100" />`
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
                    render:(data) => `<a href='/edit/${data}' class="btn btn-warning">Edit</a>`
                }
            ]
        });

        const OnDelete = () => {
            // $('#example').DataTable()

            console.log('asd')
            console.log(table.rows({
                selected: true
            }).ids().toArray());
            const ids = table.rows({
                selected: true
            }).ids().toArray()

            if (ids.lenght === 0) {
                alert('select at least one.')
                return
            }

            if (confirm("Delete?")) {
                ids.forEach(e => {
                    const res = fetch(`/delete/${e}`, {
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
