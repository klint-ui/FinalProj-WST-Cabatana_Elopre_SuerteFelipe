document.addEventListener('DOMContentLoaded', () => {
    loadTable();
});

function loadTable() {
    const tbody = document.getElementById('studentTable');
    tbody.innerHTML = ''; // Clear table before loading

    fetch('process.php')
        .then(response => response.json())
        .then(data => {
            if (data && data.student) {
                const studentList = Array.isArray(data.student) ? data.student : [data.student];
                
                studentList.forEach(student => {
                    const row = `
                        <tr>
                            <td>${student.id}</td>
                            <td>${student.name}</td>
                            <td>${student.course}</td>
                            <td>
                                <a href="process.php?delete=${student.id}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">DELETE</a>
                                <button class="btn btn-primary btn-sm" onclick="prepareEdit('${student.id}', '${student.name}', '${student.course}')">UPDATE</button>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            }
        });
}

// Fill the form with existing data to edit
function prepareEdit(id, name, course) {
    document.querySelector('input[name="id"]').value = id;
    document.querySelector('input[name="id"]').readOnly = true; // ID shouldn't be changed
    document.querySelector('input[name="name"]').value = name;
    document.querySelector('input[name="course"]').value = course;

    // Change the button to "UPDATE" mode
    const btn = document.querySelector('button[name="add"]');
    btn.innerText = "SAVE";
    btn.name = "update";
    btn.className = "btn btn-warning w-100";
}