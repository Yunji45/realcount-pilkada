@extends('layouts.dashboard.app')

@section('title')
    My Gerindra | {{ $title }}
@endsection

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">DataTables {{ $title }}</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $title }}</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @can('Create Article')
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Add {{ $title }}</h4>
                                <a href="{{ route('articles.create') }}" class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    {{ $title }}
                                </a>
                            </div>
                        </div>
                    @endcan
                    <div class="card-body">
                        <div class="table-responsive">
                            <form id="mass-delete-form" action="{{ route('article.massDelete') }}" method="POST">
                                @csrf
                                @method('DELETE')

                                @can('Delete Article')
                                    <!-- Tombol untuk hapus massal -->
                                    <button type="button" class="btn btn-danger btn-sm mb-4" style="margin-left:10px"
                                        id="deleteSelected">
                                        Delete Selected &nbsp;&nbsp;<i class="fas fa-trash-alt"></i>
                                    </button>
                                @endcan
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            @can('Delete Article')
                                                <th><input type="checkbox" id="select-all"></th>
                                            @endcan
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Kategori</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Kategori</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($articles as $article)
                                            <tr>
                                                @can('Delete Article')
                                                    <td><input type="checkbox" name="ids[]" value="{{ $article->id }}"
                                                            class="select-item"></td>
                                                @endcan
                                                <td>{{ $article->id }}</td>
                                                <td>{{ $article->title }}</td>
                                                <td>
                                                    @if ($article->image)
                                                        <img src="{{ asset('storage/' . $article->image) }}"
                                                            alt="{{ $article->title }}" width="150"
                                                            style="border-radius: 10px">
                                                    @else
                                                        No image
                                                    @endif
                                                </td>
                                                <td>{{ $article->categoryArticle->category_name }}</td>
                                                <td>
                                                    @can('Show Article')
                                                        <a href="{{ route('articles.show', $article->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    @can('Edit Article')
                                                        <a href="{{ route('articles.edit', $article->id) }}"
                                                            class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('Delete Article')
                                                        <form action="{{ route('articles.destroy', $article->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to delete this article?')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>

                    <script>
                        // Select all checkboxes functionality
                        document.getElementById('select-all').addEventListener('click', function(event) {
                            const checkboxes = document.querySelectorAll('.select-item');
                            checkboxes.forEach(checkbox => checkbox.checked = event.target.checked);
                        });

                        // Optional: to synchronize header and footer select-all checkboxes
                        document.getElementById('select-all-footer').addEventListener('click', function(event) {
                            const checkboxes = document.querySelectorAll('.select-item');
                            checkboxes.forEach(checkbox => checkbox.checked = event.target.checked);
                        });
                    </script>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        document.getElementById('deleteSelected').addEventListener('click', function(event) {
                            event.preventDefault(); // Mencegah form submit otomatis

                            var form = document.getElementById('mass-delete-form'); // Ambil form mass delete
                            var checkedBoxes = document.querySelectorAll('.select-item:checked'); // Checkbox yang dipilih

                            if (checkedBoxes.length === 0) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'No Elections Selected',
                                    text: 'Please select at least one election to delete.',
                                    confirmButtonText: 'OK'
                                });
                                return;
                            }

                            // SweetAlert2 konfirmasi
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    form.submit(); // Lanjutkan submit form jika konfirmasi diterima
                                }
                            });
                        });
                    </script>


                </div>
            </div>
        </div>
    </div>
@endsection
