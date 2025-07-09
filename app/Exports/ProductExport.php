<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductExport implements FromCollection, WithHeadings, WithEvents
{
	public function  __construct($user_id = null, $start_date = null, $end_date = null, $status = null,  $search = null)
    {
		$this->user_id= $user_id;
        $this->start_date= $start_date;
        $this->end_date= $end_date;
        $this->status= $status;
        $this->search= $search;
        $this->rows = 0;
        $this->variant_heaser_format = array();
    }
	
   public function headings():array{
        return[
            'product Id',
            'Name',
            'Category',
            'Category',
            'Sub Category',
            'Price',
            'is Variants',
            'is Replacement',
            'Replacement Days',
            'is Tax Applicable',
            'igst',
            'cgst',
            'sgst',
            'Status',
            'created At',
            'updated At',
            
        ];
    } 
    public function collection()
    {
     
        $res = Product::select(
				'products.*',
				'cat1.name as cat1_name',
				'cat2.name as cat2_name',
				'cat3.name as cat3_name',
				)
				->with(['variants_data'])
				->join('categories as cat1','cat1.id','products.category_id')
				->join('categories as cat2','cat2.id','products.sub_category_id')
				->join('categories as cat3','cat3.id','products.sub_category2_id')
				->whereNull('products.deleted_at')
				->orderBy('products.created_at','ASC');
		//filter		
		if($this->user_id != null){ $res = $res->where('products.user_id',$this->user_id); }
		if($this->search != null){ $res = $res->where('products.id','LIKE','%'.$this->search.'%')->orwhere('products.name','LIKE','%'.$this->search.'%'); }
		if($this->start_date != null){ $res = $res->where('products.created_at','>=',$this->start_date); }
		if($this->end_date != null){ $res = $res->where('products.created_at','<=',date('Y-m-d', strtotime('+1 day', strtotime($this->end_date)))); }
		if($this->status != null){ $res = $res->where('products.status',$this->status); }		
		$res = $res->get();
	
		$variant_header = [
			"1"=>'',
			"3"=>'Product Variants',
            "4"=>'Variants Qty',
            "5"=>'Variants Alert Qty',
            "6"=>'Variants Amount',
			"7"=>'Variants status',
			"8"=>'Variants created At',
            "9"=>'Variants updated At',
		];

		
		$count = 1;
		$data = array();
		foreach($res as $val){
			$array = [
				"1"=>$val->id,
				"2"=>$val->name,
				"3"=>$val->cat1_name,
				"4"=>$val->cat2_name,
				"5"=>$val->cat3_name,
				"6"=>$val->price,
				"7"=>$val->is_variants,
				"8"=>$val->is_replacement,
				"9"=>$val->replacement_days,
				"10"=>$val->is_tax_applicable,
				"11"=>$val->igst,
				"12"=>$val->cgst,
				"13"=>$val->sgst,
				"14"=>$val->status,
				"15"=>$val->created_at,
				"16"=>$val->updated_at,
			];
			$data[] = $array;
			$count ++;
			if(isset($val->variants_data) && !empty($val->variants_data) && count($val->variants_data) > 0){
				$count ++;
				$data[] = $variant_header;
				$this->variant_heaser_format[] = $count;
				foreach($val->variants_data as $pvar){
					$variant_array = [
						"1"=>'',
						"18"=>$pvar->variants,
						"19"=>$pvar->qty,
						"20"=>$pvar->alert_qty,
						"21"=>$pvar->amount,
						"22"=>$pvar->status,
						"23"=>$pvar->created_at,
						"24"=>$pvar->updated_at,
					];
					$data[] = $variant_array;
					$count ++;
				}
				$data[] = [''=>''];
				$count ++;
			}
		}	
		$this->rows += $count;
		return collect($data);
    }
	
	public function registerEvents(): array
    {
        return [
			
            AfterSheet::class => function(AfterSheet $event) {
  
				//set color
                $event->sheet->getDelegate()->getStyle('A1:P1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('dee2e6');
				
				//text align center
				$event->sheet->getDelegate()->getStyle('A1:P'.$this->rows)
						->getAlignment()
						->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
						
				//text Bold
				$event->sheet->getDelegate()->getStyle('A1:P1')
                                ->getFont()
                                ->setBold(true);

				//set auto cell size
				foreach(range('C','P') as $columnID) {
					$event->sheet->getColumnDimension($columnID)
						->setAutoSize(true);
				}
				
				//variant header
				foreach($this->variant_heaser_format as $val){
					$event->sheet->getDelegate()->getStyle('B'.$val.':I'.$val)
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('b9bdc1');
						
					//text Bold
					$event->sheet->getDelegate()->getStyle('B'.$val.':I'.$val)
                                ->getFont()
                                ->setBold(true);
				}
            },
			
        ];
    }
}
