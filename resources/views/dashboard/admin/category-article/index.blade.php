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
                    <div class="card-header">
                        @can('Create Article')
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Add {{ $title }}</h4>
                                <a href="{{ route('category_articles.create') }}" class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    {{ $title }}
                                </a>
                            </div>
                        @endcan

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form id="massDeleteForm" action="{{ route('category_article.massDelete') }}" method="POST">
                                @csrf
                                @method('DELETE') <!-- Method spoofing for DELETE -->
                                @can('Delete Article')
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
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($articles as $category_article)
                                            <tr>
                                                @can('Delete Article')
                                                    <td><input type="checkbox" name="ids[]"
                                                            value="{{ $category_article->id }}" class="select-item"></td>
                                                @endcan
                                                <td>{{ $category_article->id }}</td>
                                                <td>{{ $category_article->category_name }}</td>
                                                <td>
                                                    @can('Edit Article')
                                                        <a href="{{ route('category_articles.edit', $category_article->id) }}"
                                                            class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan

                                                    @can('Delete Article')
                                                        <form
                                                            action="{{ route('category_articles.destroy', $category_article->id) }}"
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

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Select all checkboxes functionality
        document.getElementById('select-all').addEventListener('click', function(event) {
            const checkboxes = document.querySelectorAll('.select-item');
            checkboxes.forEach(checkbox => checkbox.checked = event.target.checked);
        });

        // SweetAlert2 confirmation for mass delete
        document.getElementById('deleteSelected').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default form submit

            var form = document.getElementById('massDeleteForm'); // Correct form ID
            var checkedBoxes = document.querySelectorAll('.select-item:checked'); // Selected checkboxes

            if (checkedBoxes.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Category Articles Selected',
                    text: 'Please select at least one category article to delete.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // SweetAlert2 confirmation
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
                    form.submit(); // Proceed with form submission if confirmed
                }
            });
        });
    </script>
@endsection
