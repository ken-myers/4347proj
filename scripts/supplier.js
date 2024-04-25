const shipmentItems = [];

function addItem() {
  const itemId = document.getElementById('itemId').value;
  const quantity = parseInt(document.getElementById('quantity').value);
  if (!itemId || quantity < 1) {
    alert('Please enter valid item ID and quantity.');
    return;
  }
  
  const table = document.getElementById('shipmentTable');
  const tbody = table.getElementsByTagName('tbody')[0]
  const row = tbody.insertRow();
  const cell1 = row.insertCell(0);
  const cell2 = row.insertCell(1);
  const cell3 = row.insertCell(2);
  const cell4 = row.insertCell(3);
  
  cell1.textContent = itemId;
  cell2.textContent = '...'; // Placeholder for item name
  cell3.textContent = quantity;
  const removeButton = document.createElement('button');
  removeButton.textContent = 'Remove';
  removeButton.onclick = function() { removeItem(row, itemId); };
  cell4.appendChild(removeButton);
  table.scrollTop = table.scrollHeight;
  resolve_name(itemId, cell2); // Call to resolve name
  shipmentItems.push({ itemId, quantity });
}

function removeItem(row, itemId) {
  document.getElementById('shipmentTable').deleteRow(row.rowIndex);
  const index = shipmentItems.findIndex(item => item.itemId === itemId);
  if (index > -1) {
    shipmentItems.splice(index, 1);
  }
}

function submitShipment() {
  const supplierID = document.getElementById('supplierID').value;
  const managerID = document.getElementById('managerID').value;
  
  const shipment = {
    supplierID,
    managerID,
    items: shipmentItems
  };
  

  fetch('/api/submit-shipment.php', 
  {
      method: 'POST',
      body: JSON.stringify(shipment)
  })
  .then(
    response => {
      if (response.ok) {
        displayOutput('Shipment submitted successfully');
      } else {
        response.text().then(displayOutput);
      }
    }
  )
  console.log(JSON.stringify(shipment));
}
function displayOutput(output){
  alert(output);
}

function resolve_name(itemId, nameCell) {
 fetch(`/api/item-name.php?item_id=${itemId}`)
 .then(response => response.text())
 .then(name => {
   nameCell.textContent = name;
 });
}