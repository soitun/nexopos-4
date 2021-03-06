<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NexoPOS_Providers_Model extends Tendoo_Module
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *  Get Providers
     *  @param int provider id
     *  @return array
    **/

    public function get( $id = null )
    {
        if( $id != null ) {
            $this->db->where( 'id', $id );
        }
        return $this->db->get( 'nexopos_providers' )->result();
    }
}
