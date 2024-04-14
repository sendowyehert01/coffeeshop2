<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sales and Inventory Report</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="/Dashboard/css/reports.css">
  
</head>

<body>

<div class="container">
  <div class="row justify-content-center mt-3">
    <div class="col text-center">
      <button class="btn btn-primary" onclick="showReport('sales')">Show Daily Sales Report</button>
      <button class="btn btn-primary" onclick="showReport('inventory')">Show Inventory Report</button>
      <button class="btn btn-primary" onclick="showReport('feedback')">Show Feedback Report</button>
    </div>
  </div>

    <div id="salesReportContainer" class="report-container">
      <div class="search-filter">
        <label for="filterDropdownSales">Filter by Payment Type:</label>
        <select id="filterDropdownSales" class="form-control">
          <option value="all">All</option>
          <option value="card">Card</option>
          <option value="cash">Cash</option>
        </select>
        <div class="row mt-2 align-items-center">
          <div class="col-4">
            <label for="startDateSales">Start Date:</label>
            <input type="date" id="startDateSales" class="form-control">
          </div>
          <div class="col-4">
            <label for="endDateSales">End Date:</label>
            <input type="date" id="endDateSales" class="form-control">
          </div>
          <div class="col-4">
            <button onclick="searchSales()" class="btn btn-primary mt-4">Search</button>
          </div>
        </div>
      </div>
      <div class="table-responsive" style="max-height: 800px; overflow-y: auto;">
        <table id="salesTable" class="report-table table">
          <thead>
            <tr>
              <th>Payment ID</th>
              <th>Order Date Time</th>
              <th>Amount Paid</th>
              <th>Payment Type</th>
              <th>Customer ID</th>
              <th>Order ID</th>
            </tr>
          </thead>
          <tbody id="tableBodySales" style="height: 100%;"></tbody>
        </table>
      </div>
      <div class="row justify-content-center mb-2">
        <div class="col text-center">
          <button class="download-btn btn btn-primary" data-report-type="sales" onclick="downloadPDF('salesReportContainer')">Download as PDF</button>
        </div>
      </div>
    </div>

    <div id="inventoryReportContainer" class="report-container">
    <div class="search-filter">
      <div class="row align-items-center">
        <div class="col-5">
          <label for="quantityFilterInventory">Filter by Quantity:</label>
          <select id="quantityFilterInventory" class="form-control" onchange="filterTable('inventory')">
            <option value="">All</option>
            <option value="low">Low Quantity</option>
            <option value="high">High Quantity</option>
          </select>
        </div>
        <div class="col-7">
          <button onclick="filterTable('inventory')" class="btn btn-primary mt-4">Search</button>
        </div>
      </div>
    </div>

    <div class="table-responsive" style="max-height: 800px; overflow-y: auto;">
      <table id="inventoryTable" class="report-table table mt-2">
        <thead>
          <tr>
            <th>Inventory ID</th>
            <th>Item</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Supplier ID</th>
            <th>Product ID</th>
          </tr>
        </thead>
        <tbody id="inventoryTableBody" style="height: 100%;"></tbody>
      </table>
    </div>
    <div class="row justify-content-center mb-2">
      <div class="col text-center">
        <button class="download-btn btn btn-primary" data-report-type="inventory" onclick="downloadPDF('inventoryReportContainer')">Download as PDF</button>
      </div>
    </div>
  </div>

  <div id="feedbackReportContainer" class="report-container">
    <table id="feedbackTable" class="report-table table">
      <thead>
        <tr>
          <th>Feedback ID</th>
          <th>Title</th>
          <th>Description</th>
          <th>Customer ID</th>
        </tr>
      </thead>
      <tbody id="tableBodyFeedback"></tbody>
    </table>
    <div class="row justify-content-center mb-2">
      <div class="col text-center">
        <button class="download-btn btn btn-primary" data-report-type="feedback" onclick="downloadPDF('feedbackReportContainer')">Download as PDF</button>
      </div>
    </div>
  </div>

  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
  <script src="/Dashboard/js-dashboard/reports.js"></script>

 
  
</body>
</html>
