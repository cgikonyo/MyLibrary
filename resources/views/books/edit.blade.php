<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT') <!-- Critical for Update -->
    <input type="text" name="name" value="{{ $user->name }}">
    <input type="email" name="email" value="{{ $user->email }}">
    <button type="submit">Update Profile</button>
</form>