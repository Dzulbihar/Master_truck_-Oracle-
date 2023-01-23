<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Truck extends Model
{
    use HasFactory;

    // protected $guarded = ['id'];

	protected $table = 'truck';
    protected $fillable = 
    		[

            'company_id',               //
            'status',                   //

            'owner_name',
            'pic_nama',                 //
            'email',                    //

            'police_no', 
            'stnk_no',
            'machine_no',
            'design_no',
            'expired_lisence',                        
            'foto_stnk',                //

            'trade_mark',
            'year_made',
            'state',

            'truck_weight',
            'foto_truck',               //
            'foto_kir_truck',           //

            'chassis_code',
            'jenis_chassis',       //
            'chassis_weight',           //
            'foto_chassis',        //
            'foto_kir_chassis',    //

            'id_customer',  
            'customer',
            'site_id',
            'truck_code',
            'upd_ts',
            'opername',
            'gate_no',
            'total_weiht_ht_ch',
            'bbg_yn',
            'otl_yn',
            'id_rfid',

            'alasan_blokir',
            'tanggal_blokir',
            'nama_blokir',
            'tanggal_pengajuan',
            'tanggal_setujui',
            'nama_setujui',

      //       'id_customer',

    		// 'company_id',
      //       'status',

      //       'owner_name',
      //       'email',
      //       'pic_nama',

      //       'police_no',
      //       'truck_code',

      //       'site_id',

      //       'stnk_no',
      //       'machine_no',
      //       'design_no',
      //       'file_stnk',

      //       'trade_mark',
      //       'year_made',

      //       'chassis_code',
      //       'chassis_weight',
      //       'truck_weight',
      //       'total_weiht_ht_ch',

      //       'expired_lisence',
      //       'state',
            
      //       'gate_no',

      //       'bbg_yn',
      //       'otl_yn',

      //       'rfid',

      //       'kir_hard_head_truck',
      //       'kir_hard_chasis_20',
      //       'kir_hard_chasis_40_45',
      //       'file_kir',

      //       'photo_head_truck',
      //       'photo_chasis_truck',

      //       'alasan_blokir',
      //       'tanggal_pengajuan',
      //       'tanggal_setujui',
      //       'nama_setujui',

        	];

    public function get_expired_lisence()
    {
        return Carbon::parse($this->attributes['expired_lisence'])
        ->translatedFormat('l, d F Y');
    }

    public function get_tanggal_pengajuan()
    {
        return Carbon::parse($this->attributes['tanggal_pengajuan'])
        ->translatedFormat('l, d F Y, H:i:s');
    }

    public function get_tanggal_setujui()
    {
        return Carbon::parse($this->attributes['tanggal_setujui'])
        ->translatedFormat('l, d F Y, H:i:s');
    }

    public function get_tanggal_blokir()
    {
        return Carbon::parse($this->attributes['tanggal_blokir'])
        ->translatedFormat('l, d F Y, H:i:s');
    }

    public function get_created_at()
    {
        return Carbon::parse($this->attributes['created_at'])
        ->translatedFormat('l, d F Y');
    }
//////////////////////////////////////////////////
    public function get_foto_stnk()
    {
        if(!$this->foto_stnk){
            return asset('images/default.jpg');
        }           
        return asset('images/' .$this->foto_stnk);
    }

    public function get_foto_truck()
    {
        if(!$this->foto_truck){
            return asset('images/default.jpg');
        }           
        return asset('images/' .$this->foto_truck);
    }

    public function get_foto_kir_truck()
    {
        if(!$this->foto_kir_truck){
            return asset('images/default.jpg');
        }           
        return asset('images/' .$this->foto_kir_truck);
    }

    public function get_foto_chassis()
    {
        if(!$this->foto_chassis){
            return asset('images/default.jpg');
        }           
        return asset('images/' .$this->foto_chassis);
    }
       
    public function get_foto_kir_chassis()
    {
        if(!$this->foto_kir_chassis){
            return asset('images/default.jpg');
        }           
        return asset('images/' .$this->foto_kir_chassis);
    }        
/////////////////////////////////////

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


}
