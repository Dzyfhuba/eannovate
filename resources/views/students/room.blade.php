<div>
    <form id="assign-class">
        <select name="class" id="class" class="custom-select mb-3">
            <option value="" hidden>--- Select Class ---</option>
        </select>
        <button type="submit" class="btn btn-primary w-100">Assign</button>
    </form>

    <table id="example">
        <thead>
            <th>Class</th>
            <th>Major</th>
            <th>Created By</th>
            <th>Created At</th>
        </thead>
    </table>
</div>


<script>
    const table = new DataTable('#example', {
            ajax: '/student/room/{{ $student->id }}',
            columns: [{
                    data: 'name',
                },
                {
                    data: 'major',
                },
                {
                    data: 'created_by',
                },
                {
                    data: 'created_at',
                }
            ]
        });

    const classSelect = document.querySelector('#class')

    // fetch from /room/json
    fetch('/room/json')
        .then(response => response.json())
        .then(data => {
            data.data.forEach(room => {
                const option = document.createElement('option')
                option.value = room.id
                option.text = room.name + ' - ' + room.major
                classSelect.appendChild(option)
            })
        })

    // #assign-class on submit post to /student/assign
    document.querySelector('#assign-class').addEventListener('submit', (e) => {
        e.preventDefault()
        const classId = classSelect.value
        console.log(classId)
        const studentId = {{ $student-> id
    }}
        fetch('/student/assign', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                class_id: classId,
                student_id: studentId
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Class assigned successfully.')
                } else {
                    alert('Class already assigned.')
                    console.error(JSON.stringify(data))
                }
            })
            .catch(error => {
                console.log(error)
            })
    })
</script>
