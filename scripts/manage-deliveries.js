
function fetchShipments() {
    
    return fetch("/api/shipments.php")
    .then(response => {
        if(!response.ok) {
            throw new Error("Something went wrong.");
        }
        return response.json();
    })
    .then(data => {
        var queryResults = [];
        for(var i in data) {
            var json_string = JSON.stringify(data[i]);
            var json_object = JSON.parse(json_string);
            queryResults.push(json_object);
        }

        
        return queryResults;
    });
    
}

// Function to render delivery items
function generateTableRows(data) {
    
    // Get the tableBody element from HTML body
    var tableBody = document.getElementById("queryResults");

    tableBody.innerHTML = "";

    // Generate the headers of the table
    var headers = Object.keys(data[0]);
    var headerRow = "<tr>";
    headers.forEach(function(header) {
        headerRow += "<th>" + header + "</th>";
    });
    headerRow += "</tr>";
    tableBody.innerHTML += headerRow;

    // Generate the rows of the table
    data.forEach(function(row) {
        var rowData = "<tr>";
        headers.forEach(function(header) {
            rowData += "<td>" + row[header] + "</td>";
        });
        rowData += "</tr>";
        tableBody.innerHTML += rowData;
});
}

// Function to update delivery status
function confirmDelivery() {
    // var conf = confirm('Confirm delivery')

    const shipmentId = document.getElementById('shipmentId').value;
    const managerId = document.getElementById('managerId').value;

    fetchShipments().then(data => {
        console.log(managerId);
        data = data.filter(function (ship){
            return ship.ship_id == Number(shipmentId);
        });
        if(data.length == 0) alert("Shipment " + shipmentId + " does not exist.");
        else if(data[0].status === 'Confirmed') alert("Delivery " + shipmentId + " has already been confirmed.");
        else if(data[0].mgr_id !== Number(managerId)) alert("Manager " + data[0].mgr_id + " must confirm this delivery.");
        else {
            var conf = confirm("Confirm delivery " + shipmentId + "?");
            if(conf) {
                fetch('/api/confirm-delivery.php?shipmentId=' + shipmentId + '&managerId=' + managerId)
                .then(response => response.text())
                .then(output => {
                    alert(output); 
                });
                fetchShipments().then(data => generateTableRows(data));
            }
        }

    });

    
}

// Initial rendering of deliveries
//generateTableRows(fetchShipments());
fetchShipments().then(data => {generateTableRows(data); console.log(data)});
