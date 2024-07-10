<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
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
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="dataTableBody">
                        <!-- Data rows will go here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Add/Edit -->
    <div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
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
                            <input type="text" class="form-control" id="dataName" required>
                        </div>
                        <div class="form-group">
                            <label for="dataEmail">Email</label>
                            <input type="email" class="form-control" id="dataEmail" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        let dataList = [];

        function renderTable() {
            const tableBody = document.getElementById('dataTableBody');
            tableBody.innerHTML = '';
            dataList.forEach((data, index) => {
                tableBody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${data.name}</td>
                        <td>${data.email}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editData(${index})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete(${index})">Delete</button>
                        </td>
                    </tr>
                `;
            });
        }

        function addOrUpdateData(event) {
            event.preventDefault();
            const id = document.getElementById('dataId').value;
            const name = document.getElementById('dataName').value;
            const email = document.getElementById('dataEmail').value;
            if (id) {
                dataList[id] = {
                    name,
                    email
                };
            } else {
                dataList.push({
                    name,
                    email
                });
            }
            $('#crudModal').modal('hide');
            renderTable();
        }

        function editData(index) {
            const data = dataList[index];
            document.getElementById('dataId').value = index;
            document.getElementById('dataName').value = data.name;
            document.getElementById('dataEmail').value = data.email;
            $('#crudModal').modal('show');
        }

        function confirmDelete(index) {
            $('#deleteModal').modal('show');
            document.getElementById('confirmDeleteBtn').onclick = function() {
                deleteData(index);
            };
        }

        function deleteData(index) {
            dataList.splice(index, 1);
            $('#deleteModal').modal('hide');
            renderTable();
        }

        document.getElementById('crudForm').addEventListener('submit', addOrUpdateData);

        renderTable();
    </script>
</body>

</html>
