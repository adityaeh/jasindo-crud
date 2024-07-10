document.addEventListener('DOMContentLoaded', () => {
    let modal = document.getElementById("modal");
    let addButton = document.getElementById("addButton");
    let closeButton = document.getElementsByClassName("close-button")[0];
    let crudForm = document.getElementById("crudForm");
    let tableBody = document.getElementById("tableBody");
    let modalTitle = document.getElementById("modalTitle");
    let submitButton = document.getElementById("submitButton");

    let items = [];

    function renderTable() {
        tableBody.innerHTML = '';
        items.forEach((item, index) => {
            let row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.id}</td>
                <td>${item.name}</td>
                <td>
                    <button class="editButton" data-index="${index}">Edit</button>
                    <button class="deleteButton" data-index="${index}">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        document.querySelectorAll('.editButton').forEach(button => {
            button.addEventListener('click', (event) => {
                let index = event.target.dataset.index;
                openModal('Edit Item', items[index], index);
            });
        });

        document.querySelectorAll('.deleteButton').forEach(button => {
            button.addEventListener('click', (event) => {
                let index = event.target.dataset.index;
                items.splice(index, 1);
                renderTable();
            });
        });
    }

    function openModal(title, item = null, index = null) {
        modalTitle.innerText = title;
        if (item) {
            document.getElementById("itemId").value = item.id;
            document.getElementById("itemName").value = item.name;
        } else {
            document.getElementById("itemId").value = items.length + 1;
            document.getElementById("itemName").value = '';
        }
        submitButton.dataset.index = index;
        modal.style.display = "block";
    }

    addButton.addEventListener('click', () => {
        openModal('Add New Item');
    });

    closeButton.addEventListener('click', () => {
        modal.style.display = "none";
    });

    window.onclick = (event) => {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    crudForm.addEventListener('submit', (event) => {
        event.preventDefault();
        let id = document.getElementById("itemId").value;
        let name = document.getElementById("itemName").value;
        let index = submitButton.dataset.index;

        if (index === "") {
            items.push({ id, name });
        } else {
            items[index] = { id, name };
        }
        modal.style.display = "none";
        renderTable();
    });

    renderTable();
});
