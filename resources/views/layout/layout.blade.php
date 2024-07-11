<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @yield('body')


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
