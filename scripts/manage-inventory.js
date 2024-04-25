// Fetch Item table from php file
fetch("/api/items.php")
// Check if response was received
.then(response => {
    if(!response.ok){
        throw new Error("Something went wrong.");
    }
    return response.json();
})
.then(data =>{
    // Fill queryResults array with tuple objects
    var queryResults = [];
    for(var i in data){
        var json_string = JSON.stringify(data[i]);
        var json_object = JSON.parse(json_string);
        queryResults.push(json_object);
    }
    
    // Generates inital full table
    generateTableRows(queryResults, "");

    var itemNameSearch = document.getElementById("itemNameSearch");

    // Call the generateTableRows function every time itemNameSearch is changed
    itemNameSearch.addEventListener("input", function() {
        generateTableRows(queryResults, itemNameSearch.value);
    });
});

// Code to create the table
function generateTableRows(data, filter) {
for(var i in data){
        console.log(data[i]);
    }
// Get the tableBody element from HTML body
var tableBody = document.getElementById("queryResults");

// Clear old table data
tableBody.innerHTML = "";

// Filter query results by item name. If filter is empty string then whole table is displayed
if(filter != "") {
    var regexPattern = new RegExp(filter.toLowerCase());
    data = data.filter(function(item) {
        return regexPattern.test(item.name.toLowerCase());
    });
}

// Generate the headers of the table
var headers = Object.keys(data[0]);
//var headers = ["item_id", "name", "stock"];
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
