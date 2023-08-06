<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GGatepassMaster;
use DB;

class GpPagination extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $orderColumn = "pass_no";
    public $sortOrder = "desc";
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';
    public $searchTerm = "";

    public function updated(){
         $this->resetPage();
    }
    public function sortOrder($columnName=""){
        $caretOrder = "up";
        if($this->sortOrder == 'asc'){
             $this->sortOrder = 'desc';
             $caretOrder = "down";
        }else{
             $this->sortOrder = 'asc';
             $caretOrder = "up";
        } 
        $this->sortLink = '<i class="sorticon fa-solid fa-caret-'.$caretOrder.'"></i>';

        $this->orderColumn = $columnName;

   }
   public function render(){ 
    $gp_master = DB::table('G_Gatepass_Master')
    ->orderby($this->orderColumn,$this->sortOrder)->select('*');

    if(!empty($this->searchTerm)){

         $gp_master->orWhere('pass_no','like',"%".$this->searchTerm."%");
         $gp_master->orWhere('pass_date','like',"%".$this->searchTerm."%");
    }

    $gp_master = $gp_master->paginate(20);

    return view('livewire.gp-pagination', [
         'gp_master' => $gp_master,
    ]);

}


}
