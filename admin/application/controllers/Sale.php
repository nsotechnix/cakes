<?php
defined('BASEPATH') or exit('nikal bey');

class Sale extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('form');

        $this->load->model('Admin_Sale_Model');
        $this->load->library('upload');
        // $this->logged_in();
    }

    public function newSale()
    {

        $data['product'] = $this->Admin_Sale_Model->get_product();

        $record = $this->Admin_Sale_Model->get_sales_max();
        $ddd = $record->sales_no;
        $data['sales_no'] = $ddd + 1;
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('sale/new-sale', $data);
        $this->load->view('layouts/footer');
    }

    public function viewSale()
    {
        $data['sales'] = $this->Admin_Sale_Model->select_sales();
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('sale/view-sale', $data);
        $this->load->view('layouts/footer');
    }


    public function editSale_old()
    {
        $data['sales'] = $this->Admin_Sale_Model->select_sales();
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('sale/edit-sale', $data);
        $this->load->view('layouts/footer');
    }


    public function editSale($id)
    {

        $record = $this->Admin_Sale_Model->get_sales_max();
        $ddd = $record->sales_no;
        $data['sales_no'] = $ddd + 1;
        $data['product'] = $this->Admin_Sale_Model->get_product();
        $data['saledetails'] = $this->Admin_Sale_Model->fetchsaledetails($id);
        $data['saleproduct'] = $this->Admin_Sale_Model->get_salesHistory($id);
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('sale/edit-sale', $data);
        $this->load->view('layouts/footer');
    }


    //Sale invoice for paid sales(where due amount is 0.00)

    public function saleInvoice($id)
    {

        $data['invoice'] = $this->Admin_Sale_Model->get_saleInvoice($id);
        // $data['invoice'] = $this->Admin_Sale_Model->get_salesHistory($id);
        $sql = $this->db->query("select * from sales where sales_no = $id");
        $data['amount'] = $sql->row();
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('sale/sale-invoice', $data);
        $this->load->view('layouts/footer');
    }

    // Pending Sale Ledger 
    public function pendingLedger()
    {

        // $id = $this->session->userdata('abCashierId');
        $sale_id = $this->input->post('sales_no');
        $data['ledger'] = $this->Admin_Sale_Model->select_pending_ledger();
        // $data['product'] = $this->Admin_Sale_Model->get_productSales($sale_id);
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('sale/pending-ledger', $data);
        $this->load->view('layouts/footer');
    }

    // Complete Sale Ledger 
    public function completeLedger()
    {

        $id = $this->session->userdata('abCashierId');
        $sale_id = $this->input->post('sales_no');
        $data['ledger'] = $this->Admin_Sale_Model->select_complete_ledger($id);
        // $data['product'] = $this->Admin_Sale_Model->get_productSales($sale_id);
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('sale/complete-ledger', $data);
        $this->load->view('layouts/footer');
    }


    // Update  Ledger Pay Outstanding Details
    public function update_sales_ledger()
    {
        $ledger_id = $this->input->post('sales_no');
        $payamount = $this->input->post('last_payment_amount');
        $ledger = array(
            'last_payment_amount' => $payamount,
            'due_amount' => $this->input->post('due_amount') - $payamount,
            'sales_paid_amount' => $payamount + $this->input->post('sales_paid_amount'),
            'last_payment_date' => date('Y-m-d')

        );

        $where = array('sales_no' => $ledger_id);
        $response = $this->Admin_Sale_Model->update_sales_ledger($ledger, $where);

        $sales = array(

            'sales_balance_amount' => $this->input->post('due_amount') - $payamount,
            'sales_paid_amount' => $payamount + $this->input->post('sales_paid_amount'),
            'last_payment_date' => date('Y-m-d')

        );

        $where1 = array('sales_no' => $ledger_id);
        $response1 = $this->Admin_Sale_Model->update_sales_ledger1($sales, $where1);

        if ($response) {
            $this->session->set_flashdata('success', 'Amount Paid Successfully..!');
            redirect('sale/pendingLedger');
        } else {
            $this->session->set_flashdata('danger', 'Something went wrong..please pay Again!');
            redirect('sale/pendingLedger');
        }
    }

    //Ledger Receipt for pending and complete payment
    public function saleReceipt($id)
    {

        $data['invoice'] = $this->Admin_Sale_Model->get_ledgerReceipt($id);
        $sql = $this->db->query("select * from sales as s,cashier as c where sales_no = $id AND s.cashier_id = c.id");
        $data['amount'] = $sql->row();
        $this->load->view('layouts/header');
        $this->load->view('layouts/bar');
        $this->load->view('layouts/sub-header');
        $this->load->view('layouts/nav');
        $this->load->view('sale/ledger-receipt', $data);
        $this->load->view('layouts/footer');
    }


    //Get product list by selecting product
    public function get_data_for_sale()
    {
        $product_id = $this->input->post('id');
        $count = $this->input->post('total');
        $this->load->model('Admin_Sale_Model');

        $where = array('product_id' => $product_id);
        $data = $this->Admin_Sale_Model->get_sales($product_id);

        if ($product_id != 0) {
            $output = '';
            $output .= '<tr id="entry_row_' . $count . '">';

            $output .= '<input type="hidden" name="product_id[]" value="' . $data->id . '"> ';
            $output .= '<input type="hidden" name="category_id[]" value="' . $data->category_id . '">';
            $output .= '<td class="text-center">' . $data->product_name . '</td>';

            $output .= '<td class="text-center text-danger">' . $data->expiry_date . '</td>';
            $output .= '<td class="text-center"><input type="text" name="stock[]" readonly="readonly" id="stock' . $count . '" class="form-control border-0 text-center text-center text-success input-number p-0 m-0" style="width:100px; height:30px;" onkeyup="calculate_stock(' . $count . ')"  value="' . $data->stock . '"></td>';
            $output .= '<td class="text-center">
                
                                    
                            <input type="number" name="quantity[]" tabindex="1" id="quantity_' . $count . '" onchange="calculate_single_entry_sum(' . $count . ')" value="1" min="1" max="100" class="form-control text-center input-number p-0 m-0" style="width:50px; height:25px; onkeyup="calculate_single_entry_sum(' . $count . ')">
                               
                        </td>';





            $output .= '<td class="text-center"><input type="text" name="unit_price[]" readonly="readonly" id="unit_price_' . $count . '" class="form-control border-0 text-center input-number p-0 m-0" style="width:100px; height:30px;"  value="' . $data->market_price . '"></td>';




            $output .= '<td class="text-center">
                        
                                
                                <input type="number" name="discount1[]" tabindex="1" id="discount_' . $count . '" value="0" onkeyup="calculate_single_entry_sum(' . $count . ')" min="0" max="100" maxlength="2" class="form-control text-center input-number p-0 m-0" style="width:50px; height:30px;" onchange="calculate_single_entry_sum(' . $count . ')">
                                
                    </td>';

            $output .= '<td class="text-center">
            
                    
                    <input type="text" name="discount2[]" tabindex="1" id="discount2_' . $count . '" value="0"  onkeyup="calculate_single_entry_sum(' . $count . ')" min="0" max="100" class="form-control text-center input-number p-0 m-0" style="width:50px; height:30px;" onchange="calculate_single_entry_sum(' . $count . ')">
                    
                    </td>';
            $output .= '<td class="text-center">
                        <input type="text" name="sales_amount[]" readonly="readonly" id="single_entry_total_' . $count . '" class="form-control border-0 text-center input-number p-0 m-0" style="width:100px; height:30px;"  value="' . $data->market_price . '">
                        </td>';


            $output .= '<td class="text-center text-danger">
                        <i style="cursor: pointer;" id="delete_button_' . $count . '" onclick="delete_row(' . $count . ')" class="fa fa-trash"></i>
				</td>';
            $output .= '</tr>';

            echo $output;
        } else {
            echo $output = 0;
        }
    }


    // Insert new Sale to Database
    function insert_sale()
    {

        $product_id = $this->input->post('product_id');
        $category_id = $this->input->post('category_id');
        $itemID = $this->input->post('unit_price');
        $unit_price = $this->input->post('unit_price');
        $quantity = $this->input->post('quantity');
        $discount1 = $this->input->post('discount1');
        $discount2 = $this->input->post('discount2');

        $sales_code = $this->input->post('sales_code');
        $sales_amount = $this->input->post('sales_amount');

        for ($i = 0; $i < count($itemID); $i++) {
            extract($_POST);

            if (strlen($unit_price[$i]) > 0) {
                $data1 = $this->Admin_Sale_Model->check_stock_record($product_id[$i], $category_id[$i]);
                if ($data1) {

                    $data = $this->Admin_Sale_Model->get_stock_qty($product_id[$i], $category_id[$i]);
                    $id = $data->stock;
                    $new_id = $id - $quantity[$i];

                    $data = array(
                        "stock" => $new_id,
                        "market_price" => $unit_price[$i],

                    );
                    $where = array('id' => $product_id[$i], 'category_id' => $category_id[$i]);
                    $this->Admin_Sale_Model->update_record('products', $data, $where);
                } else {
                    $data = array(
                        "id" => $product_id[$i],
                        "category_id" => $category_id[$i],
                        "stock" => $quantity[$i],
                        "market_price" => $unit_price[$i],
                    );
                    $this->Admin_Sale_Model->add_record('products', $data);
                }
            }

            $maxID = $this->Admin_Sale_Model->get_sale_max1();
            $max = $maxID->sales_id;
            $pu_id = $max + 1;
            $sales_data = array(
                'sales_id' => $pu_id,
                'sales_no' => $sales_code,
                'product_id' => $product_id[$i],
                'category_id' => $category_id[$i],
                'product_discount_percent' => $discount1[$i],
                'product_discount_amount' => $discount2[$i],
                'sales_qty' => $quantity[$i],
                'sales_amount' => $sales_amount[$i],
                'product_price' => $unit_price[$i],

            );


            $data_entry = $this->Admin_Sale_Model->add_record('sales_detail', $sales_data);
        } //for loop
        $discount = $this->input->post('round_discount');
        $discount_total = $this->input->post('discount_total');
        $paymentTotal = $this->input->post('paymentTotal');
        $due_amount = $this->input->post('due_amount');
        $roundTotal = $this->input->post('net_payment');
        $sub_total = $this->input->post('sub_total');
        $invoice = "SALE-" . date('Y-m') . $sales_code;
        $Sales_comp_Ins = array(
            'sales_no' => $sales_code,
            'invoice_no' => $invoice,
            'payment_cash' => $payment_cash,
            'payment_debit_card' => $payment_debit_card,
            'payment_credit_card' => $payment_credit_card,
            'payment_upi' => $payment_upi,
            'payment_cheque' => $payment_cheque,

            'cashier_id' => $this->session->userdata('abCashierId'),


            // 'GST_percent' => $this->input->post('GST_percent'),
            // 'CGST' => $CGST,
            // 'SGST' => $SGST,

            'sales_round_amount' => $roundTotal,
            'sales_paid_amount' => $paymentTotal,
            'sales_discount' => $discount,
            'sales_discount_total' => $discount_total,
            'sales_balance_amount' => $due_amount,
            'grand_total' => $sub_total,
            'sales_date' => $this->input->post('sales_date'),
            'sales_by' => 'CASHIER',

            'customer_name' => $this->input->post('customer_name'),
            'customer_phone' => $this->input->post('customer_phone'),

        );
        $data_entry = $this->Admin_Sale_Model->add_record('sales', $Sales_comp_Ins);

        // Insert sale to ledger Begin
        $ledger = "SREC" . date('Y') . $sales_code;
        $sales_ledger = array(
            'sales_no' => $sales_code,
            'ledger_no' => $ledger,
            'cashier_id' => $this->session->userdata('abCashierId'),
            // 'GST_percent' => $this->input->post('GST_percent'),
            'sales_round_amount' => $this->input->post('net_payment'),
            'sales_paid_amount' => $this->input->post('paymentTotal'),
            'due_amount' => $this->input->post('due_amount'),
            'grand_total' => $this->input->post('sub_total'),
            'ledger_date' => $this->input->post('sales_date'),
            'sales_by' => 'CASHIER',

        );
        $data_entry = $this->Admin_Sale_Model->add_record('sales_ledger', $sales_ledger);
        //Insert Sale to ledger End

        if ($data_entry == false) {

            $this->session->set_flashdata('danger', 'Something went wrong, please try again');
            redirect('sale/newSale');
        } else {

            $this->session->set_flashdata('success', 'Sale Successful');

            redirect('sale/viewSale');
        }
    }

    // Insert new Sale to Database end
}
