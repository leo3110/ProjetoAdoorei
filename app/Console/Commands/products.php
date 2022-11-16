<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class products extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from external API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $p = Http::get("https://fakestoreapi.com/products/".$this->option('id'))->json();
        if ($this->option('id')) {
            $prod = new Product();
            $prod->name = $p['title'];
            $prod->price = $p['price'];
            $prod->description = $p['description'];
            $prod->category = $p['category'];
            $prod->image_url = $p['image'];    
            $prod->save();
        } else {
            foreach ($p as $p => $value) {
                $prod = new Product();
                $prod->name = $value['title'];
                $prod->price = $value['price'];
                $prod->description = $value['description'];
                $prod->category = $value['category'];
                $prod->image_url = $value['image'];    
                $prod->save();
            }
        }
    }
}
