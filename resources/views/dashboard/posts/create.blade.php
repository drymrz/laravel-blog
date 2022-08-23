@extends('dashboard.layouts.main')

@section('container')
<form class="my-4" id="postForm" action="/dashboard/posts" method="post" enctype="multipart/form-data">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}" autofocus required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4 d-none">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                            name="slug" value="{{ old('slug') }}" required>
                        @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="category" class="form-label">Category</label>
                        <select id="category" class="form-select @error('category_id') is-invalid @enderror"
                            name=" category_id" required>
                            @foreach ($categories as $category)
                            @if (old('category_id') == $category->id)
                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                            @else
                            <option value="" hidden></option>
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="body" class="form-label">Caption</label>
                        <input id="body" type="hidden" name="body" value="{{ old('body') }}">
                        <trix-editor id="trix" input="body"></trix-editor>
                        @error('body')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Image</label>
                        <img class="img-preview img-fluid mb-3 col-sm-5">
                        <input class="form-control  @error('image') is-invalid @enderror" name="image[]"
                            accept="image/*" type="file" id="image" data-max-file-size="3MB" data-max-files="6"
                            multiple>
                        <p class="filepond--warning" id="warning" data-state="hidden">The maximum number of files is 6
                        </p>
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <button type="button" class="btn btn-primary float-end" id="uploadBtn" onclick="uploadImages()"
                            disabled>Upload
                            Post</button>
                        <button type="submit" class="btn btn-primary" id="createBtn" hidden>Create
                            Post</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@section('scripts')
<script>
    const title = document.querySelector("#title");
        const slug = document.querySelector("#slug");
        title.addEventListener("keyup", function() {
            let preslug = title.value;
            preslug = preslug.replace(/ /g, "-");
            slug.value = preslug.toLowerCase();
        });

        const inputElement = document.querySelector('input[id="image"]');

        FilePond.registerPlugin(FilePondPluginImagePreview,
                                FilePondPluginFileValidateSize,
                                FilePondPluginFileValidateType,
                                FilePondPluginImageExifOrientation);

        const pond = FilePond.create(inputElement);
        FilePond.setOptions({
            required: true,
            labelIdle: `Drag & Drop your picture or <span class="filepond--label-action">Browse</span>`,
            instantUpload: false,
            allowMultiple: true,
            allowReorder: true,
            allowProcess: false,
            checkValidity: true,
            acceptedFileTypes: ['image/png','image/jpeg','image/jpg','image/webp','image/svg'],
            onprocessfiles: (files) => {
                uploadPost()
            },
            onaddfilestart : (file) => {
                uploadBtnState()
            },
            onremovefile : (error, file) => {
                uploadBtnState()
            },
            server: {
                url: '/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        })

        function uploadBtnState(){
            if($('#title,#body').val().length > 0 && pond.status != "0" && $('#category').val().length > 0 ){
            $('#uploadBtn').prop('disabled', false);
            }else{
            $('#uploadBtn').prop('disabled', true);
            }
        }

        pond.on('warning', (error, file) => {
            if (error.body == "Max files") {
                document.getElementById('warning').setAttribute('data-state', 'visible');
                setTimeout(() => {
                    document.getElementById('warning').setAttribute('data-state', 'hidden');
                }, 5000);
            }
        });

        function uploadImages() {
            pond.processFiles()
            if (pond.status == "4") {
                uploadPost();
            }
        }

        $(document).keyup(function (e) { 
            uploadBtnState();
            console.log($("#category").val().length);
        });

        function uploadPost() {
            $('#createBtn').click();
        }
</script>
@endsection
@endsection