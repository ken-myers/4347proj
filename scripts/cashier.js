const transactionItems = [];

function addItem() {
  const itemId = document.getElementById('itemId').value;
  const quantity = parseInt(document.getElementById('quantity').value);
  if (!itemId || quantity < 1) {
    alert('Please enter valid item ID and quantity.');
    return;
  }
  
  const table = document.getElementById('transactionTable');
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
  transactionItems.push({ itemId, quantity });
}

function removeItem(row, itemId) {
  document.getElementById('transactionTable').deleteRow(row.rowIndex);
  const index = transactionItems.findIndex(item => item.itemId === itemId);
  if (index > -1) {
    transactionItems.splice(index, 1);
  }
}

function completeTransaction() {
  const customerEmail = document.getElementById('customerEmail').value;
  const cashierId = document.getElementById('cashierId').value;
  
  const transaction = {
    customerEmail,
    cashierId,
    items: transactionItems
  };
  
  fetch('/api/complete-transaction.php', 
  {
      method: 'POST',
      body: JSON.stringify(transaction)
  })
  .then(
    response => {
      if (response.ok) {
        displayOutput('Transaction completed successfully');
      } else {
        response.text().then(displayOutput);
      }
    }
  )
}

function displayOutput(output){
  if(output.includes(" FOREIGN KEY (`customer_email`) ")){
    output = "No customer found with that email address";
  }

  else if (output.includes("FOREIGN KEY (`item_id`) REFERENCES `Items` (`item_id`) ")){
    output = "Transaction includes an invalid item ID";
  }

  else if (output.includes("FOREIGN KEY (`cash_id`) REFERENCES ")){
    output = "No cashier found with that ID";
  }

  else if (output.includes(" BIGINT UNSIGNED value is out of range in '(`db_project`.`Items`.`stock` - ?)'")){
    output = "Transaction includes an item with insufficient stock";
  }
  alert(output);
}

function resolve_name(itemId, nameCell) {
 fetch(`/api/item-name.php?item_id=${itemId}`)
 .then(response => response.text())
 .then(name => {
   nameCell.textContent = name;
 });
}