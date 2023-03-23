<?php 
  require_once '../fpdf/fpdf.php';
  require_once '../homeIncludes/dbconfig.php';


  //customer and invoice details
  $info=[
    "customer"=>"",
    "address"=>"",
    "phone"=>"",
    "invoice_no"=>"",
    "invoice_date"=>"",
    "total_amt"=>"",
    "transaction_id"=>"",
    "initial_payments"=>"",
  ];
  

  $query = "SELECT * FROM invoice
  JOIN rprq ON invoice.invoice_id = rprq.invoice_id
  JOIN customer ON rprq.cust_id = customer.cust_id
  WHERE invoice.invoice_id = '{$_GET['invoice_id']}'";

  $res=$conn->query($query);
  if ($res->num_rows > 0){
    $row=$res->fetch_assoc();
    $info=[
      "customer"=>$row["fname"]." ".$row["lname"],
      "address"=>$row["address"],
      "phone"=>$row["phone"],
      "invoice_no"=>$row["invoice_no"],
      "invoice_date"=>$row["invoice_date"],
      "total_amt"=>$row["grand_total"],
      "transaction_id"=>$row["transaction_code"],
    ];
    $info["initial_payments"] = $row["initial_payments"];
  }

    //invoice Products
  $products_info=[];
  $query = "SELECT * FROM invoice_desc
  WHERE invoice_id = '{$_GET['invoice_id']}'";

  $res=$conn->query($query);
  if ($res->num_rows > 0){
    while($row=$res->fetch_assoc()){
      $products_info[] = [
        "name" => $row["descname"],
        "price" => $row["descPrice"],
        "qty" => $row["descQty"],
        "total" => $row["total"]
    ];    
    }
  }
  
  
  class PDF extends FPDF
  {
    function Header(){
      

      //Display Company Info
      $this->SetFont('Arial','B',14);
      $this->Cell(50,10,"PROTON ELECTRONICS AND SERVICES",0,1);
      $this->SetFont('Arial','',14);
      $this->Cell(50,7,"Aguinaldo street,",0,1);
      $this->Cell(50,7,"Lamitan.",0,1);
      $this->Cell(50,7,"PH : 0935 223 2051",0,1);
      
      //Display INVOICE text
      $this->SetY(15);
      $this->SetX(-40);
      $this->SetFont('Arial','B',18);
      $this->Cell(50,10,"INVOICE",0,1);
      
      //Display Horizontal line
      $this->Line(0,48,210,48);
    }
    
    function body($info,$products_info){

      //Billing Details
      $this->SetY(55);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,10,"Bill To: ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(50,7,$info["customer"],0,1);
      $this->Cell(50,7,"PH: " . $info["phone"],0,1); // Added phone number
      $this->Cell(50,7,$info["address"],0,1);
        
      //Display Invoice No
      $this->SetY(55);
      $this->SetX(-60);
      $this->Cell(50,7,"Invoice No : ".$info["invoice_no"]);
        
      //Display Invoice date
      $this->SetY(63);
      $this->SetX(-60);
      $this->Cell(50,7,"Invoice Date : ".$info["invoice_date"]);

      //Display Transaction ID
      $this->SetY(71);
      $this->SetX(-60);
      $this->Cell(50,7,"Transaction ID : ".$info["transaction_id"]);
      
      //Display Table headings
      $this->SetY(95);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(80,9,"DESCRIPTION",1,0);
      $this->Cell(40,9,"PRICE",1,0,"C");
      $this->Cell(30,9,"QTY",1,0,"C");
      $this->Cell(40,9,"TOTAL",1,1,"C");
      $this->SetFont('Arial','',12);
        
      //Display table product rows
      foreach($products_info as $row){
        $this->Cell(80,9,$row["name"],"LR",0);
        $this->Cell(40,9,$row["price"],"R",0,"R");
        $this->Cell(30,9,$row["qty"],"R",0,"C");
        $this->Cell(40,9,$row["total"],"R",1,"R");
      }
      //Display table empty rows
      for($i=0;$i<12-count($products_info);$i++)
      {
        $this->Cell(80,9,"","LR",0);
        $this->Cell(40,9,"","R",0,"R");
        $this->Cell(30,9,"","R",0,"C");
        $this->Cell(40,9,"","R",1,"R");
      }
      //Display table total row
      $this->SetFont('Arial','B',12);
      $this->Cell(150,9,"INITIAL PAYMENT",1,0,"R");
      $this->Cell(40,9,$info["initial_payments"],1,1,"R");

      //Display initial payment row
      $this->SetFont('Arial','B',12);
      $this->Cell(150,9,"GRAND TOTAL",1,0,"R");
      $this->Cell(40,9,$info["total_amt"],1,1,"R");
        
  }
  
    function Footer(){
      
      //set footer position
      $this->SetY(-50);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,10,"for PROTON ELECTRONICS AND SERVICES",0,1,"R");
      $this->Ln(15);
      $this->SetFont('Arial','',12);
      $this->Cell(0,10,"Authorized Signature",0,1,"R");
      $this->SetFont('Arial','',10);
      
      //Display Footer Text
      $this->Cell(0,10,"This is a computer generated invoice",0,1,"C");
      
    }
    
  }
  //Create A4 Page with Portrait 
  $pdf=new PDF("P","mm","A4");
  $pdf->AddPage();
  $pdf->body($info,$products_info);
  $pdf->Output();
?>

