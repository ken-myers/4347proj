document.addEventListener('DOMContentLoaded', function() {

reloadTable();
});

function reloadTable() {
    const table = document.getElementById('personnel-table');

    //clear table except for header
    while (table.rows.length > 1) {
        table.deleteRow(1);
    }

    //populate table

    fetch('/api/employees.php')
    .then(response => response.json())
    .then(employees => {
        employees.forEach(employee => {
            const row = document.createElement('tr');
            row.innerHTML = `
            <td>${employee.emp_id}</td>
            <td>${employee.f_name}</td>
            <td>${employee.l_name}</td>
            `;
            table.appendChild(row);
        });
    });

}

function confirmFire(employeeId, name) {    
    conf = confirm('Are you sure you want to terminate employee #' + employeeId + " (" + name + ')?');
    
    if (conf) {
        fetch('/api/remove-employee.php?employeeId=' + employeeId)
        .then(response => response.text())
        .then(output => {alert(output); reloadTable();});
    }
}



function startFire() {
    const employeeId = document.getElementById('employeeId').value;

    fetch('/api/employee-name.php?employeeId=' + employeeId)
    .then(response=>response.text())
    .then(name => confirmFire(employeeId, name));
}


