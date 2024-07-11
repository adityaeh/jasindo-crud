@extends('layout.layout')
@section('body')


    <div class="container mt-5">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>

        <!-- Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Table</h3>
                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#crudModal">Add
                    New</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    @foreach ($datas as $data)
                        <tbody id="dataTableBody">
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td><a href="#modalEdit" data-toggle="modal"
                                    data-target="#modalEdit{{ $data->id }}">Edit</a>
                                <a href="#modalDelete" data-toggle="modal"
                                    data-target="#modalDelete{{ $data->id }}">Delete</a>
                            </td>
                        </tbody>



                        <div class="modal fade" id="modalEdit{{ $data->id }}" tabindex="-1"
                            aria-labelledby="modalEditLabel" aria-hidden="true" role="dialog">
                            <form method="POST" action="{{ route('edit.table') }}">
                                @csrf
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="crudModalLabel">Add/Edit Data</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="crudForm">
                                                <input type="hidden" id="dataId">
                                                <div class="form-group">
                                                    <label for="dataName">Name</label>
                                                    <input placeholder="{{ $data->name }}" type="text" name="user_name"
                                                        class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="dataEmail">Email</label>
                                                    <input placeholder="{{ $data->email }}" type="email"
                                                        name="user_email" class="form-control" required>
                                                </div>
                                                <input type="hidden" name="user_id" value="{{ $data->id }}"
                                                    id="">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal" id="modalDelete{{ $data->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <form method="POST" action="{{ route('delete.table') }}">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Apus</p>
                                        </div>
                                        <input type="hidden" name="user_id" value="{{ $data->id }}" id="">
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Add/Edit -->
    <div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
        <form method="POST" action="{{ route('save.table') }}">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crudModalLabel">Add/Edit Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="crudForm">
                            <input type="hidden" id="dataId">
                            <div class="form-group">
                                <label for="dataName">Name</label>
                                <input type="text" name="user_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="dataEmail">Email</label>
                                <input type="email" name="user_email" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </form>
    </div>



    <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
