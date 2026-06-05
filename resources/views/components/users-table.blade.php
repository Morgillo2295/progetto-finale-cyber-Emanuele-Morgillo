<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Admin</th>
            <th scope="col">Revisor</th>
            <th scope="col">Writer</th>
            <th scope="col">Assign roles</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if (is_null($user->is_admin))
                        <span class="badge text-bg-warning">Pending</span>
                    @elseif ($user->is_admin)
                        <span class="badge text-bg-success">Yes</span>
                    @else
                        <span class="badge text-bg-secondary">No</span>
                    @endif
                </td>
                <td>
                    @if (is_null($user->is_revisor))
                        <span class="badge text-bg-warning">Pending</span>
                    @elseif ($user->is_revisor)
                        <span class="badge text-bg-success">Yes</span>
                    @else
                        <span class="badge text-bg-secondary">No</span>
                    @endif
                </td>
                <td>
                    @if (is_null($user->is_writer))
                        <span class="badge text-bg-warning">Pending</span>
                    @elseif ($user->is_writer)
                        <span class="badge text-bg-success">Yes</span>
                    @else
                        <span class="badge text-bg-secondary">No</span>
                    @endif
                </td>
                <td class="d-flex flex-wrap gap-1">
                    @if (! $user->is_admin)
                        <form action="{{ route('admin.setAdmin', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-secondary">Admin</button>
                        </form>
                    @endif
                    @if (! $user->is_revisor)
                        <form action="{{ route('admin.setRevisor', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-secondary">Revisor</button>
                        </form>
                    @endif
                    @if (! $user->is_writer)
                        <form action="{{ route('admin.setWriter', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-secondary">Writer</button>
                        </form>
                    @endif
                    @if ($user->is_admin && $user->is_revisor && $user->is_writer)
                        <span class="text-muted small">All roles assigned</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
