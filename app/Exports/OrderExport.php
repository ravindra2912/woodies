<?php

namespace App\Exports;

use App\Models\Orders;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class OrderExport implements FromCollection,WithHeadings, WithEvents
{
	public function  __construct($user_id = null, $start_date = null, $end_date = null, $status = null,  $search = null)
    {
        $this->user_id= $user_id;
        $this->start_date= $start_date;
        $this->end_date= $end_date;
        $this->status= $status;
        $this->search= $search;
        $this->rows = 0;
    }

	
	public function headings():array{
        return[
            'Order Id',
            'Customer Name',
            'Delivery Name',
            'Delivery Contact',
            'Delivery Address',
            'Delivery Address2',
            'Country',
            'State',
            'City',
            'Zip Code',
            'SubTotal',
            'Discount',
            'Tax',
            'Total',
            'Order Status',
            'Payment Transaction Id',
            'Payment Status',
            'Payment By',
            'Return At',
            'Return Receive At',
            'Return Reason',
            'Created At',
            'Updated At',
        ];
    } 
	
    
    public function collection()
    {
        $res = Orders::select(
					'orders.id',
					'users.first_name',
					'orders.name',
					'orders.contact',
					'orders.address',
					'orders.address2',
					'orders.country',
					'orders.state',
					'orders.city',
					'orders.zipcode',
					'orders.subtotal',
					'orders.discount',
					'orders.tax',
					'orders.total',
					'order_statuses.name as order_satatus_name',
					'orders.payment_transaction_id',
					'orders.payment_status',
					'orders.payment_by',
					'orders.return_at',
					'orders.return_receive_at',
					'orders.return_reason',
					'orders.created_at',
					'orders.updated_at',
					)
					->join('users','users.id','orders.user_id')
					->join('order_statuses','order_statuses.id','orders.status');
		if($this->user_id != null){
			$res = $res->where('orders.user_id',$this->user_id);
		}			
		
		if($this->search != null){ $res = $res->where('id','LIKE','%'.$this->search.'%'); }
		if($this->start_date != null){ $res = $res->where('created_at','>=',$this->start_date); }
		if($this->end_date != null){ $res = $res->where('created_at','<=',date('Y-m-d', strtotime('+1 day', strtotime($this->end_date)))); }
		if($this->status != null){ $res = $res->where('status',$this->status); }
					
		$res = $res->get();
			
		$this->rows = count($res) + 1;
				
		return $res;
		
		return collect([
            [
                'name' => 'Povilas',
                'surname' => 'Korop',
                'email' => 'povilas@laraveldaily.com',
                'twitter' => '@povilaskorop'
            ],
            [
                'name' => 'Taylor',
                'surname' => 'Otwell',
                'email' => 'taylor@laravel.com',
                'twitter' => '@taylorotwell'
            ]
        ]);
    }
	
	public function registerEvents(): array
    {
        return [
			
            AfterSheet::class => function(AfterSheet $event) {
  
				//set color
                $event->sheet->getDelegate()->getStyle('A1:W1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('dee2e6');
				
				//text align center
				$event->sheet->getDelegate()->getStyle('A1:W'.$this->rows)
						->getAlignment()
						->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
						
				//text Bold
				$event->sheet->getDelegate()->getStyle('A1:W1')
                                ->getFont()
                                ->setBold(true);

				//set auto cell size
				foreach(range('A','W') as $columnID) {
					$event->sheet->getColumnDimension($columnID)
						->setAutoSize(true);
				}
            },
			
        ];
    }
}
