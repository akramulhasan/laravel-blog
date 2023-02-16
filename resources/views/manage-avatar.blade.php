<x-layout>
    <div class="container --container-narrow">
        <h2 class="text-center mb-3">Upload a New avatar</h2>
        <form action="/manage-avatar" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" name="avatar" required>
                @error('avatar')
                    <p class="alert small alert-danger shadow-sm">
                        {{$message}}
                    </p>

                @enderror
                <button class="btn btn-primary" type="submit">Save</button>
            </div>

        </form>
    </div>
</x-layout>