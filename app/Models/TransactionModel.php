<?php namespace App\Models;
use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['invoice_no', 'total_amount'];
    protected $useTimestamps = false; 
}