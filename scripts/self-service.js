function getEmployeeInfo() {
    const employeeId = document.getElementById('employeeId').value;
    const passcode = document.getElementById('passcode').value;

    const formData = new FormData();
    formData.append('emp_id', employeeId);
    formData.append('passcode', passcode);

    fetch('/api/employee-info.php', 
    {
        method: 'POST',
        body: formData
    })
    .then(response=>response.text())
    .then(displayOutput);
    
    
}

function changePasscode() {
    const employeeId = document.getElementById('employeeIdPasscode').value;
    const passcode = document.getElementById('oldPasscode').value;
    const newPasscode = document.getElementById('newPasscode').value;

    const formData = new FormData();
    formData.append('emp_id', employeeId);
    formData.append('passcode', passcode);
    formData.append('new_passcode', newPasscode);

    fetch('/api/change-passcode.php', 
    {
        method: 'POST',
        body: formData
    })
    .then(response=>response.text())
    .then(alert);
}

function displayOutput(output){
    document.getElementById('employeeInfo').innerHTML = `<h2>Employee Info</h2><div>${output}</div>`;
}