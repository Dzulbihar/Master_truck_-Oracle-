<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    // protected $guarded = ['id'];

	protected $table = 'company';
    protected $fillable = 
    		[
            'user_id',
            'owner_name',
            'contact',
            'email_company',
            'addr_company',
            'nib_company',
            'file_nib_company',
            'npwp_company',
            'file_npwp_company',
            'pmku_company',
            'file_pmku_company',

            'pic_nama',
            'pic_contact',
            'email',
            'statement_form',
        	];

    public function getfile_nib_company()
    {
        if(!$this->file_nib_company){
            return asset('images/default.jpg');
        }           
        return asset('images/' .$this->file_nib_company);
    }

    public function getfile_npwp_company()
    {
        if(!$this->file_npwp_company){
            return asset('images/default.jpg');
        }           
        return asset('images/' .$this->file_npwp_company);
    }    

    public function getfile_pmku_company()
    {
        if(!$this->file_pmku_company){
            return asset('images/default.jpg');
        }           
        return asset('images/' .$this->file_pmku_company);
    } 

    public function getstatement_form()
    {
        if(!$this->statement_form){
            return asset('images/default.jpg');
        }           
        return asset('images/' .$this->statement_form);
    }



    public function truck()
    {
        return $this->hasMany(Truck::class);
    }

    public function driver()
    {
        return $this->hasMany(Driver::class);
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }

}
