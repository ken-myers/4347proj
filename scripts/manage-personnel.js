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
    // Alert the user if the employee ID is not in the database
    if(name == "No employee found with that ID."){
        alert("No employee found with that ID");
        return;
    }

    conf = confirm('Are you sure you want to terminate employee #' + employeeId + " (" + name + ')?');
    
    if (conf) {
        fetch('/api/remove-employee.php?employeeId=' + employeeId)
        .then(response => response.text())
        .then(output => {alert(output); reloadTable();});
    }
}



function startFire() {
    const employeeId = document.getElementById('employeeId').value;
    // Alert the user that they must enter an ID if they left the input field blank
    if(employeeId == ""){
        alert("You must enter an employee ID");
        return;
    }
    fetch('/api/employee-name.php?employeeId=' + employeeId)
    .then(response=>response.text())
    .then(name => confirmFire(employeeId, name));
}


