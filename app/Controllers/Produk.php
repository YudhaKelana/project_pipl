<?php namespace App\Controllers;
use App\Models\ProductModel;

class Produk extends BaseController
{
    public function index()
    {
        $model = new ProductModel();
        $data['products'] = $model->findAll();
        return view('produk/index', $data);
    }

    public function create()
    {
        return view('produk/create');
    }

    public function store()
    {
        $model = new ProductModel();
        $data = [
            'barcode' => $this->request->getPost('barcode'),
            'name'    => $this->request->getPost('name'),
            'category'=> $this->request->getPost('category'),
            'price'   => $this->request->getPost('price'),
            'stock'   => $this->request->getPost('stock'),
        ];
        $model->insert($data);
        return redirect()->to('/produk');
    }

    public function delete($id)
    {
        $model = new ProductModel();
        $model->delete($id);
        return redirect()->to('/produk');
    }
}